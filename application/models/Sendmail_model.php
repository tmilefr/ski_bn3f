<?php
defined('BASEPATH') || exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Sendmail_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'Sendmail');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'date');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Sendmail.json');
		$this->_init_def();
	}
}
?>
