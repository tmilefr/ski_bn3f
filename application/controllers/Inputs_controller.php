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
		$this->bootstrap_tools->_SetHead('assets/vendor/chart.js/Chart.js','js');
		for($year = date('Y');$year >= 2016 ; $year--){
			$this->data_view['years'][$year] = $year;
		}		
		$datas = $this->{$this->_model_name}->get_group_by();

		$tmp   = array();
		$stats = array();
		foreach($datas AS $key=>$obj){
			$stats['month'][$obj->MONTH] = $obj->MONTH;
			$stats['year'][$obj->YEAR] = $obj->YEAR;
			@$tmp[$obj->YEAR][$obj->MONTH] = $obj;
		}
		ksort($stats['month']);
		ksort($stats['year']);	
		
		foreach($stats['year'] AS $year){
			foreach($stats['month'] AS $month){
				if (isset($tmp[$year][$month])){
					$stats['line'][$year][$month] = $tmp[$year][$month]->SUM;
				} else {
					$stats['line'][$year][$month] = 0;
				}
			}
		}
	
		$stats['color']['2018'] = '#ff9933';
		$stats['color']['2017'] = '#0099ff';
		$stats['color']['2016'] = '#009933';
		
		$this->data_view['stats'] = $stats;
		
		$this->_set('view_inprogress','unique/list_view_input');
		$this->render_view();
	}


}
