<?php
defined('BASEPATH') || exit('No direct script access allowed');
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
	
	/**
	 * @brief Get input for periode
	 * @param $month 
	 * @param $year 
	 * @returns Array();
	 * 
	 * 
	 */
	function get_inputs($month,$year){
		if (is_array($this->filter) AND count($this->filter)){
			foreach($this->filter AS $key => $value){
				$this->db->where($key , $value);
			}
		} 	
		$datas = $this->db->select('*')
					   ->order_by('user', 'DESC' )
					   ->order_by('billing_date', 'ASC' )
					   ->where('MONTH(billing_date)',$month)
					   ->where('YEAR(billing_date)',$year)
					   ->get($this->table)
					   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}
	
	/**
	 * @brief Update Input for periode 
	 * @param $month 
	 * @param $year 
	 * @returns void()
	 * 
	 * 
	 */
	function update_inputs($month,$year){
		$this->datas = new StdClass();
		$this->datas->billed = TRUE;
		$this->datas->updated = date('Y-m-d H:i:s');
		$this->db->where('MONTH(billing_date)',$month);
		$this->db->where('YEAR(billing_date)',$year);
		$this->db->update($this->table, $this->datas);	
	}
	
	/**
	 * @brief 
	 * @param $nb 
	 * @param $order 
	 * @param $direction 
	 * @returns 
	 * 
	 * 
	 */
	function get_last($nb, $order, $direction ){
		$this->db->limit( $nb , 0);
		
		$datas = $this->db->select( ($this->autorized_fields ? implode(',',$this->autorized_fields) : '*' ) )
						   ->order_by($order, $direction )
						   ->get($this->table)
						   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}

	/**
	 * @brief 
	 * @param $month 
	 * @param $year 
	 * @returns 
	 * 
	 * 
	 */
	public function get_from($month = null, $year = null){
		$this->_set_filter();
		$this->_set_search();		
		if ($month)
			$this->db->where('MONTH(billing_date)',$month);
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);

		$datas = $this->db->select(($this->autorized_fields ? implode(',',$this->autorized_fields) : '*' ))
					   ->order_by($this->order, $this->direction )
					   ->get($this->table)
					   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}

	/**
	 * @brief 
	 * @param $month 
	 * @param $year 
	 * @returns 
	 * 
	 * 
	 */
	public function get_group_by($month = null ,$year = null){		
		if ($month)
			$this->db->where('MONTH(billing_date)',$month);
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);

		$datas = $this->db->select('MONTH(billing_date) AS MONTH,YEAR(billing_date) AS YEAR,SUM(duration) AS SUM, count(*) AS NB, billed')
					   ->order_by($this->order, $this->direction )
					   ->group_by(implode(',',$this->group_by))
					   ->get($this->table)
					   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}

	/**
	 * @brief Get Stats for user
	 * @param $month 
	 * @param $year 
	 * @param $user 
	 * @returns array();
	 * 
	 * 
	 */
	function get_stats_user($month = null ,$year = null, $user = null){
		if ($month)
			$this->filter['MONTH(billing_date)'] = $month;
		if ($year)
			$this->filter['YEAR(billing_date)'] = $year;
		if ($user)
			$this->filter['user'] = $user;
			
		$this->_set_filter();
		$this->_set_group_by();
		$this->_set_order_by();
			
		$this->db->where('duration > 0 ', null);
		$datas = $this->db->select('YEAR(billing_date) AS YEAR,MONTH(billing_date) AS MONTH,SUM(duration) AS SUM_TOUR, count(*) AS NB_TOUR, CONCAT(users.name," ",users.surname) AS UserName, ROUND(SUM(duration) / count(*),2) AS MOY_TOUR')
					  ->join('users','inputs.user=users.id','LEFT')
					  ->get($this->table)					  
					  ->result();  
		$this->_debug_array[] = $this->db->last_query();
		return $datas;	
	}

	/**
	 * @brief 
	 * @param $year 
	 * @param $user 
	 * @returns 
	 * 
	 * 
	 */
	function get_minutes_year($year = null, $user = null){
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);
		if ($user)
			$this->db->where('user',$user);			
		$this->db->where('duration > 0 ', null);
		$datas = $this->db->select('YEAR(billing_date) AS YEAR,SUM(duration) AS SUM_TOUR,ROUND(SUM(duration)/60,0) AS HOUR_TOUR')
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
