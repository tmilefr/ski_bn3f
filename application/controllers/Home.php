<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * @brief 
 * 
 * 
 */
class Home extends MY_Controller {

	
	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_model_name 		= 'Input_model';	   //DataModel
		$this->_controller_name = 'Home';  //controller name for routing
		$this->title = '';
		$this->data_view['content'] = '';
		$this->init();
		$this->bootstrap_tools->_SetHead('assets/vendor/chart.js/Chart.js','js');
	}

	/**
	 * @brief 
	 * @returns 
	 * 
	 * 
	 */
	public function index()
	{
		
		for($year = date('Y');$year >= 2016 ; $year--){
			$this->data_view['years'][$year] = $year;
		}		
		$this->{$this->_model_name}->_set('group_by',['MONTH(billing_date)','YEAR(billing_date)']);
		$datas = $this->{$this->_model_name}->get_group_by();

		$tmp   = array();
		$stats = array();
		foreach($datas AS $key=>$obj){
			$stats['month'][$obj->MONTH] = $obj->MONTH;
			$stats['year'][$obj->YEAR] = $obj->YEAR;
			@$tmp[$obj->YEAR][$obj->MONTH] = $obj;
		}
		ksort($stats['month']);
		ksort($stats['year']);	
		
		foreach($stats['year'] AS $year){
			foreach($stats['month'] AS $month){
				if (isset($tmp[$year][$month])){
					$stats['line'][$year][$month] = $tmp[$year][$month]->SUM;
					if (isset($stats['global'][$year])){
						$stats['global'][$year] += $tmp[$year][$month]->SUM;
					} else {
						$stats['global'][$year] = $tmp[$year][$month]->SUM;
					}
				} else {
					$stats['line'][$year][$month] = 0;
				}
			}
		}
		$stats['color']['2020'] = '#ff9933';		
		$stats['color']['2019'] = '#ff9933';	
		$stats['color']['2018'] = '#ff9933';
		$stats['color']['2017'] = '#0099ff';
		$stats['color']['2016'] = '#009933';
		$this->data_view['stats'] = $stats;
		
		$this->Input_model->_set('group_by', ['user','YEAR(billing_date)']);
		$this->Input_model->_set('order'   , ['SUM_TOUR'=>'DESC','YEAR(billing_date)'=>'DESC','MONTH(billing_date)'=>'DESC','user'=>'DESC']);
		
		$this->data_view['TOP'][2018] = $this->Input_model->get_stats_user(null,2018,null);
		$this->data_view['TOP'][2017] = $this->Input_model->get_stats_user(null,2017,null);
		$this->data_view['TOP'][2016] = $this->Input_model->get_stats_user(null,2016,null);
			
		$datas = $this->Input_model->get_minutes_year();
		
		$tmp = array();
		foreach($datas AS $data){
			$tmp['years'][$data->YEAR] = $data->YEAR;
			$tmp['datas'][$data->YEAR] = $data->HOUR_TOUR;
		}
		ksort($tmp['years']);
		ksort($tmp['datas']);
		$this->data_view['BOAT'] = $tmp;
	
		$this->_set('view_inprogress','unique/home_page');
		$this->render_view();
	}
}
