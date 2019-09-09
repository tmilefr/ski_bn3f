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
		$this->_model_name 		= 'Users_model';	   //DataModel
		$this->_controller_name = 'Home';  //controller name for routing
		$this->title = '';
		$this->data_view['content'] = '';
		$this->init();
	}
	
	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function index()
	{
		$error = '';
        if($this->input->server('REQUEST_METHOD') == 'POST'){
			if ($this->form_validation->run() == true) {
				$data = $this->input->post();
				$usercheck  = $this->Users_model->verifyLogin($data['name'], $data['password']);
                if ($usercheck->autorize){ 
					$this->session->set_userdata('usercheck', $usercheck);  
					redirect('/Home');
				}                
			} 			
        }
		
		$this->_set('view_inprogress','unique/login_view');
		$this->render_view();
	}	

	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
    public function logout(){
        $this->session->unset_userdata('user_id');
        redirect('/login');
    }

	
}
