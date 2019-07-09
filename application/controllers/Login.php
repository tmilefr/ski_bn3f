<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_model_name 		= 'Input_model';	   //DataModel
		$this->_controller_name = 'Home';  //controller name for routing
		$this->title = '';
		$this->data_view['content'] = '';
		$this->init();
		$this->bootstrap_tools->_SetHead('assets/vendor/chart.js/Chart.js','js');
	}
	
	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function index()
	{
		
		$this->_set('view_inprogress','unique/login_view');
		$this->render_view();
	}	
	
}
