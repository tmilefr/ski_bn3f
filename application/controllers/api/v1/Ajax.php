<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Ajax Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */
class Ajax extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Ajax';  //controller name for routing
		$this->title = '';
		$this->init();
		$this->load->model('GenericSql_model');
	}
	
	 /**
	 * @brief Generic list view ( Need PHP 7)
	 * @returns Json
	 */
	public function list()
	{
		
	}	
}
