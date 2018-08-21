<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');
class Input_model extends Core_model{
	
	protected $group_by = array();
	
	function __construct(){
		parent::__construct();
		$this->_set('_debug', FALSE);
		
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

	public function get_group_by($month = null ,$year = null){
		
		if ($month)
			$this->db->where('MONTH(billing_date)',$month);
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);

		$datas = $this->db->select('MONTH(billing_date) AS MONTH,YEAR(billing_date) AS YEAR,SUM(duration) AS SUM, count(*) AS NB')
					   ->order_by($this->order, $this->direction )
					   ->group_by(implode(',',$this->group_by))
					   ->get($this->table)
					   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}

	function get_stats_user($month = null ,$year = null, $user = null){
		if ($month)
			$this->db->where('MONTH(billing_date)',$month);
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);
		if ($user)
			$this->db->where('user',$user);
		$this->db->where('duration > 0 ', null);
		$datas = $this->db->select('YEAR(billing_date) AS YEAR,SUM(duration) AS SUM_TOUR, count(*) AS NB_TOUR, CONCAT(users.name," ",users.surname) AS UserName, ROUND(SUM(duration) / count(*),2) AS MOY_TOUR')
					  ->order_by('YEAR','DESC')
					  ->order_by('SUM_TOUR','DESC')
					  ->order_by('user','DESC')
				      ->group_by('user,YEAR(billing_date)')
					  ->join('users','inputs.user=users.id','LEFT')
					  ->get($this->table)					  
					  ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;	
	}
	
	function get_minutes_year($year = null, $user = null){
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);
		if ($user)
			$this->db->where('user',$user);			
		$this->db->where('duration > 0 ', null);
		$datas = $this->db->select('YEAR(billing_date) AS YEAR,SUM(duration) AS SUM_TOUR,SUM(duration)/60 AS HOUR_TOUR')
					  ->order_by('YEAR','DESC')
					  ->order_by('SUM_TOUR','DESC')
				      ->group_by('YEAR(billing_date)')
					  ->get($this->table)					  
					  ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;			
	}



}
?>

