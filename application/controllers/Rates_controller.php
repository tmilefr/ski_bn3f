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
class Rates_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Rates_controller';  //controller name for routing
		$this->_model_name 		= 'Rates_model';	   //DataModel
		$this->_edit_view 		= 'edition/Rates_form';//template for editing
		$this->_list_view		= '';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>false,'view'=>false);
		
		
		$this->title .= $this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		
		$this->init();
	}

}
