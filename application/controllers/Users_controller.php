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
class Users_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Users_controller';  //controller name for routing
		$this->_model_name 		= 'Users_model';	   //DataModel
		$this->_edit_view 		= 'edition/Users_form';//template for editing
		$this->_list_view		= 'unique/Users_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		
		
		$this->title .= $this->lang->line($this->_controller_name);
		$this->init();

		$this->_set('_debug', TRUE);
		$this->Users_model->_set('_debug', TRUE);

	}
	
	function view($id){
		$this->bootstrap_tools->_SetHead('assets/vendor/chart.js/Chart.js','js');
		$this->load->model('Input_model');
		$this->data_view['stats'] = $this->Input_model->get_stats_user_month( null , null ,$id);
		
		parent::view($id);
	}

}
