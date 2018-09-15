<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Invoice_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'Invoice');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'id');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Invoice.json');
		$this->_init_def();
	}
	


}
?>

