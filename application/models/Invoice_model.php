<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Invoice_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
		$this->_set('table'	, 'invoice');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'id');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Invoice.json');
		$this->_init_def();
	}
	
	function get_recap($month,$year){
		if (isset($month) AND isset($year)){
			$datas = $this->db->select('*')
						   ->order_by('ID', 'DESC' )
						   ->where('month', $month)
						   ->where('year', $year)
						   ->get($this->table)
						   ->result();
		} else {
			$datas = $this->db->select('month,year,sum(sum) AS SUM')
						   ->order_by('ID', 'DESC' )
						   ->group_by('CONCAT(`month`,`year`)')
						   ->get($this->table)
						   ->result();
		} 
		return $datas;
	}	
}
?>
