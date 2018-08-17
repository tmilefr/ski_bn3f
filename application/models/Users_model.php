<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Users_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', TRUE);
		
		$this->_set('table'	, 'users');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Users.json');
		$this->_init_def();
	}
	


}
?>

