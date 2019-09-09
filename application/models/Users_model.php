<?php
defined('BASEPATH') || exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Users_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'users');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Users.json');
		$this->_init_def();
	}
	
	function get_user($id,$user = true){
		if ($user){
			$this->key_value = $id;
			$datas = $this->get_one();
		} else {
			$datas =$this->db->select('*')
						   ->join('family','family.id='.$this->table.'.family','left')
						   ->where('family',$id)
						   ->get($this->table)
						   ->row();
		}
		return $datas;
	}
	
	function verifyLogin($user, $password){
		$usercheck = new stdClass();
		$usercheck->name = 'nico';
		$usercheck->autorize = true;
		$usercheck->id = 1;	
		$usercheck->msg = 'test message';
		return $usercheck;
	}
}
?>
