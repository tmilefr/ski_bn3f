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
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>false);
		
		$this->title .= $this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		
		$this->init();
		$this->_set('next_view', 'add');
		
		$this->load->model('Users_model');
		$this->load->model('Rates_model');
		$this->load->model('Family_model');
		
		$this->load->library('Libinvoice');
		$this->Input_model->_set('_debug',TRUE);
		
		if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0) /* directory process is long ! TODO : change the method*/
		{
			@set_time_limit(300);
		}				
	}

	
	public function filter_set(){
		$this->session->set_userdata( $this->set_ref_field('month_in_progress') , $this->input->post('month_in_progress') );
		$this->session->set_userdata( $this->set_ref_field('year_in_progress') , $this->input->post('year_in_progress') );
		redirect('Inputs_controller/add');
	}

	public function add()
	{		
		$datas = array();
		$this->data_view['id'] = '';
		$this->data_view['month_in_progress'] = $this->session->userdata( $this->set_ref_field('month_in_progress') );	
		$this->data_view['year_in_progress'] = $this->session->userdata( $this->set_ref_field('year_in_progress') );	
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
				
				$this->render_object->_reset_value('duration');
				$this->render_object->_reset_value('rates');
				$this->render_object->_reset_value('close');
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
			$this->data_view['datas'] 	= $this->{$this->_model_name}->get_from($this->data_view['month_in_progress'],$this->data_view['year_in_progress']);			
			
		}	
		$this->_set('view_inprogress','edition/Input_form_add');
		$this->render_view();
	}
	
	function make_bill(){	
		$this->load->model('Invoice_model');
		$this->data_view['rates'] = array();
		$rates = $this->Rates_model->get_all();
		//std class with all defs
		$defs = new StdClass();
		$defs->rates = [];
		foreach($rates AS $rate){
			$defs->rates[$rate->id] = $rate;
		}
		ksort($_POST['month']);
		$defs->month = [];
		$defs->year = [];
		//std class with all datas
		$consos = new StdClass();
		foreach($_POST['month'] AS $period){
			list($month,$year) = explode('_', $period);
			$inputs 			= $this->{$this->_model_name}->get_inputs($month , $year);
			$defs->month[$month] = $month;
			$defs->year[$year]  = $year;
			/* DATA CONSOLIDATION */
			foreach( $inputs AS $input){
				$this->Users_model->_set('key_value',$input->user);
				if (!isset($consos->user[$input->user])){
					$user = new StdClass();
					$user->details = $this->Users_model->get_one();
					$defs->user[$input->user] = $user;
					if (!$user->details->family){
						//no family
						$user->details->family = 'u'.$input->user;
						$defs->family[$user->details->family] = $this->Users_model->get_one();
					} else {
						$this->Family_model->_set('key_value',$user->details->family );
						$defs->family[$user->details->family] = $this->Family_model->get_one();
					}					
				} else {
					$user = $consos->user[$input->user];
				}
			
				if (isset($consos->input[$user->details->family][$input->user]['dates'][$month][$input->billing_date][$input->rates])){
					$consos->input[$user->details->family][$input->user]['dates'][$month][$input->billing_date][$input->rates] += $input->duration;
				} else {
					$consos->input[$user->details->family][$input->user]['dates'][$month][$input->billing_date][$input->rates] = $input->duration;
				}
				
				if (isset($consos->input[$user->details->family][$input->user]['conso'][$input->rates])){
					$consos->input[$user->details->family][$input->user]['conso'][$input->rates] += $input->duration;
				} else {
					$consos->input[$user->details->family][$input->user]['conso'][$input->rates] = $input->duration;
				}
			}
			$this->{$this->_model_name}->update_inputs($month, $year);			
		}
		
		$this->libinvoice->_set('defs',$defs);
		ksort($consos->input);
		/*Invoice construct ( finaly JSON OBJET in DataBase )*/
		foreach($consos->input AS $family => $users){ 
			$this->libinvoice->_set('family', $family);
			$invoice = $this->libinvoice->MakeInvoice($users, $family);
			$invoice->month =  implode(',',$invoice->month);
			$invoice->year = implode(',',$invoice->year);
			
  			//update or create
			$exist = $this->Invoice_model->is_exist(null,null,['month'=>$invoice->month,'year'=>$invoice->year,'family'=>$invoice->family,'user'=>$invoice->user]);
			$datas = ['header'=>$invoice->header,'month' => $invoice->month, 'year'=>$invoice->year,'sum'=>$invoice->sum ,'content'=>$invoice->content,'family'=>$invoice->family,'user'=>$invoice->user];
			if (!$exist){
				$id = $this->Invoice_model->post( $datas );
			} else {
				$this->Invoice_model->_set('key_value', $exist->id);
				$this->Invoice_model->_set('datas', $datas);
				$this->Invoice_model->put();				
			}
			$this->libinvoice->DoPdf($invoice);
			//$this->libinvoice->SendByMail();
			
			//$this->data_view['invoices'][] = $invoice;
			//$this->data_view['month'] = $consos->month;
			//$this->data_view['year'] = $consos->year;
			
			//krsort($this->data_view['invoices']);*/
		}

		//$this->libinvoice->DoRecap($this->data_view);
		redirect('Inputs_controller/billed');
		
		//$this->_set('view_inprogress','unique/Invoices_view');
		//$this->render_view();
	}
	

	
	function billed(){
		
		//TODO use invoices table ...
		$this->{$this->_model_name}->_set('group_by',  ['MONTH(billing_date)','YEAR(billing_date)','billed']);
		$this->{$this->_model_name}->_set('order'			, 'billing_date');
		//GET DATAS
		$this->data_view['datas'] 	= $this->{$this->_model_name}->get_group_by();
		$this->data_view['MONTHS'] 	= [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
		$this->data_view['pdf_path'] = $this->libinvoice->_get('pdf_path');
		$this->data_view['pdf_url_path'] = $this->libinvoice->_get('pdf_url_path');

		$this->_set('view_inprogress','unique/list_view_input');
		
		
		
		$this->render_view();
	}


}
