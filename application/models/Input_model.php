<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Input_model extends Core_model{
	
	protected $group_by = array();
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', TRUE);
		
		$this->_set('table'	, 'inputs');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'id');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Input.json');
		$this->_init_def();
	}
	
	function get_last($nb, $order, $direction ){
		$this->db->limit( $nb , 0);
		
		$datas = $this->db->select( ($this->autorized_fields ? implode(',',$this->autorized_fields) : '*' ) )
						   ->order_by($order, $direction )
						   ->get($this->table)
						   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}


	public function get_group_by(){
		$datas = $this->db->select('MONTH(billing_date) AS MONTH,YEAR(billing_date) AS YEAR,count(*) AS NB')
					   ->order_by($this->order, $this->direction )
					   ->group_by('MONTH(billing_date),YEAR(billing_date)')
					   ->get($this->table)
					   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}

}
?>

