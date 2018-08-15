<?php  if ( ! defined('BASEPATH')) exit("No direct script access allowed");

class Setup extends CI_Controller
{
	
	protected $json_path = APPPATH.'models/json/';
	
	public function Reset(){
		
	}
  
	public function index()
	{
		$this->load->library('migration');

		if($this->migration->latest() === FALSE)
		{
			show_error($this->migration->error_string());
		}
		else
		{
			echo 'The migration has concluded successfully.';
		}
		
		
	}
	


}
