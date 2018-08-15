<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GenericSql_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function distinct($table,$id,$value){
		$this->db->distinct();
		return $this->db->select("$id,$value")->get($table)->result();
	}
	
}
