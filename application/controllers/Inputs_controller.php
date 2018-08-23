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
		parent::__construct();
		$this->_controller_name = 'Inputs_controller';  //controller name for routing
		$this->_model_name 		= 'Input_model';	   //DataModel
		$this->_edit_view 		= 'edition/Input_form';//template for editing
		$this->_list_view		= '';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>false,'view'=>false);
		
		$this->title .= $this->lang->line($this->_controller_name);
		
		$this->_set('_debug', TRUE);
		
		$this->init();
	}

	public function add()
	{		
		$datas = array();
		$this->data_view['id'] = '';
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
			}
		}	
		$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
		$this->data_view['month_in_progress'] = date('m');
		if ($this->session->userdata('month_in_progress')){
			//$datas = $this->{$this->_model_name}->get_last(500, 'id', 'desc' );
			$this->{$this->_model_name}->_set('filter'			, $this->session->userdata($this->set_ref_field('filter')));
			$this->{$this->_model_name}->_set('direction'		, $this->session->userdata($this->set_ref_field('direction')));
			//GET DATAS
			$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
			$this->data_view['datas'] 	= $this->{$this->_model_name}->get();			
			
		}	

		
		
		$this->_set('view_inprogress','edition/Input_form_add');
		$this->render_view();
	}
	
	/*function list(){

		
		$this->_set('view_inprogress','unique/list_view_input');
		$this->render_view();
	}*/


}
