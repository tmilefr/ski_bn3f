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
		/* GET 5 last input */
		$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
		$this->data_view['datas'] 	= $this->{$this->_model_name}->get_last(500, 'id', 'desc' );
				
		$this->_set('view_inprogress','edition/Input_form_add');
		$this->render_view();
	}
	
	function list(){
		$config = array();
		$config['per_page'] 	= '10';
		$config['base_url'] 	= $this->config->item('base_url').$this->_controller_name.'/list/page/';
		$config['total_rows'] 	= $this->{$this->_model_name}->get_pagination();
		$this->pagination->initialize($config);	
		
		$this->{$this->_model_name}->_set('global_search'	, $this->session->userdata($this->set_ref_field('global_search')));
		$this->{$this->_model_name}->_set('order'			, $this->session->userdata($this->set_ref_field('order')));
		$this->{$this->_model_name}->_set('filter'			, $this->session->userdata($this->set_ref_field('filter')));
		$this->{$this->_model_name}->_set('direction'		, $this->session->userdata($this->set_ref_field('direction')));
		$this->{$this->_model_name}->_set('per_page'		, $config['per_page']);
		$this->{$this->_model_name}->_set('page'			, $this->session->userdata($this->set_ref_field('page')));
		
		//GET DATAS
		$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
		$this->data_view['datas'] 	= $this->{$this->_model_name}->get_group_by();
		
		
		$this->_set('view_inprogress','unique/list_view_input');
		$this->render_view();
	}


}
