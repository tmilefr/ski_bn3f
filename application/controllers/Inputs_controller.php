<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */
class Inputs_controller extends MY_Controller {

	public function __construct(){
		
		$this->_autorised_get_key[] = 'month';
		$this->_autorised_get_key[] = 'year';
		$this->_autorised_get_key[] = 'rebill';		
		
		
		parent::__construct();
		$this->_controller_name = 'Inputs_controller';  //controller name for routing
		$this->_model_name 		= 'Input_model';	   //DataModel
		$this->_edit_view 		= 'edition/Input_form';//template for editing
		$this->_list_view		= '';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>false,'view'=>false);
		
		$this->title .= $this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		
		$this->init();
		$this->_set('next_view', 'add');
		
		$this->load->model('Users_model');
		$this->load->model('Rates_model');
		$this->load->model('Family_model');
	}

	public function filter_set(){
		$this->session->set_userdata( $this->set_ref_field('month_in_progress') , $this->input->post('month_in_progress') );
		redirect('Inputs_controller/add');
	}

	public function add()
	{		
		$datas = array();
		$this->data_view['id'] = '';
		$this->data_view['month_in_progress'] = $this->session->userdata( $this->set_ref_field('month_in_progress') );	
		$this->data_view['last_date'] = date('Y-m-d');	
		$this->render_object->_set('form_mod', 'add');
		
		if ($this->form_validation->run() === FALSE){


		} else {
			$datas = array();
			foreach($this->{$this->_model_name}->_get('autorized_fields') AS $field){
				$datas[$field] 	= $this->input->post($field);
			}
			if ($this->input->post('form_mod') == 'edit'){
				if (isset($datas['id']) AND $id = $datas['id']){
					$this->{$this->_model_name}->_set('key_value', $id);	
					$this->{$this->_model_name}->_set('datas', $datas);
					$this->{$this->_model_name}->put();
				} 
			} else if ($this->input->post('form_mod') == 'add'){
				$this->{$this->_model_name}->post($datas);
				
				$this->data_view['last_date'] = $datas['billing_date'];
			}
		}	
		$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
		//$this->data_view['month_in_progress'] = date('m');
		if ($this->data_view['month_in_progress']){
			$this->{$this->_model_name}->_set('global_search'	, $this->session->userdata($this->set_ref_field('global_search')));
			$this->{$this->_model_name}->_set('order'			, $this->session->userdata($this->set_ref_field('order')));
			$this->{$this->_model_name}->_set('filter'			, $this->session->userdata($this->set_ref_field('filter')));
			$this->{$this->_model_name}->_set('direction'		, $this->session->userdata($this->set_ref_field('direction')));	
			//GET DATAS
			$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
			$this->data_view['datas'] 	= $this->{$this->_model_name}->get_from($this->data_view['month_in_progress'],date('Y'));			
			
		}	

		
		
		$this->_set('view_inprogress','edition/Input_form_add');
		$this->render_view();
	}
	
	function make_bill(){
		
		$this->load->model('Invoice_model');
		
		$inputs 	=  $this->{$this->_model_name}->get_inputs($this->session->userdata($this->set_ref_field('month')) , $this->session->userdata($this->set_ref_field('year')) );

		$this->data_view['rates'] = array();
		$rates = $this->Rates_model->get_all();
		
		$consos = new StdClass();
		$consos->month = $this->session->userdata($this->set_ref_field('month'));
		$consos->year = $this->session->userdata($this->set_ref_field('year'));
		$consos->rates = array();
		foreach($rates AS $rate){
			$consos->rates[$rate->id] = $rate;
		}
		/* DATA CONSOLIDATION */
		foreach( $inputs AS $input){
			$this->Users_model->_set('key_value',$input->user);
			
			$user = new StdClass();
			$user->details = $this->Users_model->get_one();
			$consos->user[$input->user] = $user;
			
			if (!$user->details->family){
				//no family
				$user->details->family = 'u'.$input->user;
				$consos->family[$user->details->family] = $this->Users_model->get_one();
			} else {
				$this->Family_model->_set('key_value',$user->details->family );
				$consos->family[$user->details->family] = $this->Family_model->get_one();
			}			
			if (isset($consos->input[$user->details->family][$input->user]['dates'][$input->billing_date][$input->rates])){
				$consos->input[$user->details->family][$input->user]['dates'][$input->billing_date][$input->rates] += $input->duration;
			} else {
				$consos->input[$user->details->family][$input->user]['dates'][$input->billing_date][$input->rates] = $input->duration;
			}
			
			if (isset($consos->input[$user->details->family][$input->user]['conso'][$input->rates])){
				$consos->input[$user->details->family][$input->user]['conso'][$input->rates] += $input->duration;
			} else {
				$consos->input[$user->details->family][$input->user]['conso'][$input->rates] = $input->duration;
			}
		}
		ksort($consos->input);
		//$this->data_view['consos'] 	= $consos;
		
		/*Invoice construct ( finaly JSON OBJET in DataBase )*/
		foreach($consos->input AS $family => $users){ 
			$invoice = new StdClass();
			$invoice->header = Lang('Family_bill').' '.$consos->family[$family]->name;
			$invoice->month = $consos->month;
			$invoice->year =  $consos->year;
			$invoice->family =  $family;
			$invoice->sum = 0;
			foreach($users as $user => $datas){
				$part = new StdClass();
				$part->name = $consos->user[$user]->details->name.' '.$consos->user[$user]->details->surname;
				foreach($datas['dates'] AS $key=>$values){
					$i = 0;
					foreach($values AS $rate=>$duration){
						$day = new StdClass();
						$day->date = $key;
						$day->rate = $consos->rates[$rate]->name;
						$day->duration = $duration;
						$part->days[] = $day;
					}
				}
				$total = 0;
				foreach($datas['conso'] AS $rate=>$duration){
					$footer = new StdClass();
					$footer->rate = $consos->rates[$rate]->name;
					$footer->duration = $duration;
					$footer->cost = round($duration * $consos->rates[$rate]->amount, 2);
					$total += round($duration * $consos->rates[$rate]->amount, 2);
					$part->footer[] = $footer;
				}
				$invoice->part[] = $part;
				$invoice->sum += $total;
			}
			$invoice->content = json_encode($invoice);
			
			//no family
			if ( substr($family,0,1) == 'u'){
				$user = substr($family,1);
				$family = '';
			} else {
				$user = '';
			}
			$exist = $this->Invoice_model->is_exist(null,null,['month'=>$invoice->month,'year'=>$invoice->year,'family'=>$family,'user'=>$user]);
			$datas = ['header'=>$invoice->header,'month' => $invoice->month, 'year'=>$invoice->year,'sum'=>$invoice->sum ,'content'=>$invoice->content,'family'=>$family,'user'=>$user];
			if (!$exist){
				$this->Invoice_model->post( $datas );
			} else {
				$this->Invoice_model->_set('key_value', $exist->id);
				$this->Invoice_model->_set('datas', $datas);
				$this->Invoice_model->put();				
			}
			$this->data_view['invoices'][$invoice->sum] = $invoice;
			krsort($this->data_view['invoices']);
		}
		
		$this->_set('view_inprogress','unique/Invoices_view');
		$this->render_view();
	}
	
	function billed(){
		$this->{$this->_model_name}->_set('group_by',  ['MONTH(billing_date)','YEAR(billing_date)','billed']);
		$this->{$this->_model_name}->_set('order'			, 'billing_date');
		//GET DATAS
		$this->data_view['datas'] 	= $this->{$this->_model_name}->get_group_by();
		
		$this->_set('view_inprogress','unique/list_view_input');
		$this->render_view();
	}


}
