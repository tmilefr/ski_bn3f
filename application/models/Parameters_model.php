<?php
defined('BASEPATH') || exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Parameters_model extends Core_model{

	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);

		$this->_set('table'	, 'Parameters');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Parameters.json');
		$this->_init_def();
	}
}
?>
