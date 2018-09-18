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
class Family_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->_controller_name = 'Family_controller';  //controller name for routing
		$this->_model_name 		= 'Family_model';	   //DataModel
		$this->_edit_view 		= 'edition/Family_form';//template for editing
		$this->_list_view		= 'unique/Family_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		
		
		$this->title .= $this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		$this->init();
		
		$this->load->model('Users_model');
	}

	public function view($id){
		if ($id){
			$this->render_object->_set('id',		$id);
			$this->{$this->_model_name}->_set('key_value',$id);
			$dba_data = $this->{$this->_model_name}->get_one();
			$this->render_object->_set('dba_data',$dba_data);
		
			$this->Users_model->_set('filter',['family'=>$id]);
			$this->data_view['users'] = $this->Users_model->get_all();
		}	
		
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();		
		
	}	

	

}
