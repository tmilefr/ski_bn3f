<?php  if ( ! defined('BASEPATH')) exit("No direct script access allowed");

class Setup extends CI_Controller
{

	protected $json = null;
	protected $json_path = APPPATH.'models/json/';

	public function __construct(){
		parent::__construct();
		$this->load->dbforge();
	}	
	
	
	public function _get_json($json){
		$json = file_get_contents($this->json_path.$json);
		$json = json_decode($json);
		$fields = array();
		foreach($json AS $field => $define){
			$def = array();
			foreach($define->dbforge AS $key=>$value){
				$def[$key] = $value;
			}
			$fields[$field] = $def;
		}
		return $fields;
	}

	public function LoadData($json,$model,$path){
		$this->load->model($model);
		$json = file_get_contents($this->json_path.$json);
		$json = json_decode($json);
		foreach($json->{$path} AS $family){
			$this->{$model}->post($family);
		}
	}
	
	public function index(){
		$this->dbforge->add_field( $this->_get_json('Invoice.json') );
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('Invoice');  	
	}
  
	/*public function index()
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
		
		
	}*/
	


}
