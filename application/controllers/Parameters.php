<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @brief 
 * 
 * 
 */
class Parameters extends MY_Controller {

	protected $params = []; //list of parameters
	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function __construct(){
		parent::__construct();
		$this->_model_name 		= '';	   //DataModel
		$this->_controller_name = 'Parameters';  //controller name for routing
		$this->init();
		
		$this->params['app_name']	= ['type'=>'input','value'=>$this->config->item('item_name')];
		$this->params['slogan']	= ['type'=>'input','value'=>$this->config->item('slogan')];
		$this->params['debug_app']	= ['type'=>'input','value'=>$this->config->item('debug_app')];
	}

	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function index()
	{
		
		
	
		$this->_set('view_inprogress','unique/Parameters_view');
		$this->render_view();
	}
}
