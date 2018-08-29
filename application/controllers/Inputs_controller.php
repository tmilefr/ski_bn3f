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
		
		$this->{$this->_model_name}->_set('filter'			, ['MONTH(billing_date)' => $this->session->userdata($this->set_ref_field('month')) ,'YEAR(billing_date)' => $this->session->userdata($this->set_ref_field('year')), 'billed'=> (( $this->session->userdata($this->set_ref_field('rebill')) ==  'on' ) ? 1 : 0 ) ] );
		$inputs 	=  $this->{$this->_model_name}->get();

		$stat = new StdClass();
		foreach( $inputs AS $input){
			
			if (isset($stat->input[$input->user]['dates'][$input->billing_date][$input->rates])){
				$stat->input[$input->user]['dates'][$input->billing_date][$input->rates] += $input->duration;
			} else {
				$stat->input[$input->user]['dates'][$input->billing_date][$input->rates] = $input->duration;
			}
			
			if (isset($stat->input[$input->user]['conso'][$input->rates])){
				$stat->input[$input->user]['conso'][$input->rates] += $input->duration;
			} else {
				$stat->input[$input->user]['conso'][$input->rates] = $input->duration;
			}
		}
		$this->data_view['consos'] 	= $stat;
		$this->_set('view_inprogress','unique/bill');
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
