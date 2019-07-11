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
		$this->_model_name 		= 'User_model';	   //DataModel
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

		$user_id = $this->session->userdata('user_id');
        $error = '';
        if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == true) {
                $data = $this->input->post();
                if ($this->UsersModel->verifyLogin($data['username'], $data['password'])){                
					redirect('/Home');
				}                 
			} else {
				//$this->session->set_flashdata('message', '');
				
			}			
        }
		
		$this->_set('view_inprogress','unique/login_view');
		$this->render_view();
	}	

	**
     * Logout page
     * 
     * @AclName Logout
     */
    public function logout(){
        $this->session->unset_userdata('user_id');
        redirect('/login');
    }

	
}
