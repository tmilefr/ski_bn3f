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
		//echo '<pre>'.print_r($this->db->last_query(),1).'</pre>';
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}
	
	function update_inputs($month,$year){
		$this->datas = new StdClass();
		$this->datas->billed = TRUE;
		$this->datas->updated = date('Y-m-d H:i:s');
		$this->db->where('MONTH(billing_date)',$month);
		$this->db->where('YEAR(billing_date)',$year);
		$this->db->update($this->table, $this->datas);	
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

	function get_stats_user_month($month = null ,$year = null, $user = null){
		if ($month)
			$this->db->where('MONTH(billing_date)',$month);
		if ($year)
			$this->db->where('YEAR(billing_date)',$year);
		if ($user)
			$this->db->where('user',$user);
		$this->db->where('duration > 0 ', null);
		$datas = $this->db->select('YEAR(billing_date) AS YEAR,MONTH(billing_date) AS MONTH, DAY(billing_date) AS DAY, SUM(duration) AS SUM_TOUR')
					  ->order_by('YEAR','DESC')
					  ->order_by('MONTH','ASC')
					  ->order_by('DAY','ASC')
					  ->order_by('SUM_TOUR','DESC')
					  ->order_by('user','DESC')
				      ->group_by('user,DAY(billing_date),MONTH(billing_date),YEAR(billing_date)')
					  ->get($this->table)					  
					  ->result();
		$this->_debug_array[] = $this->db->last_query();
		$stats_user_month = array();
		foreach($datas AS $data){
			$stats_user_month[$data->YEAR][$data->MONTH][$data->DAY] = $data->SUM_TOUR;
		}
		foreach($stats_user_month AS $year=>$Months){
			foreach($Months AS $month=>$values){
				$nb = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				for($jr = 1;$jr <= $nb; $jr++){
					if (!isset($stats_user_month[$year][$month][$jr])){
						$stats_user_month[$year][$month][$jr] = 0;
					}
				}
				ksort($stats_user_month[$year][$month]);
			}
		}
		
		return $stats_user_month;	
	}

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

