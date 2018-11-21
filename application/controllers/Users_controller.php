<?php
defined('BASEPATH') || exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */
class Users_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Users_controller';  //controller name for routing
		$this->_model_name 		= 'Users_model';	   //DataModel
		$this->_edit_view 		= 'edition/Users_form';//template for editing
		$this->_list_view		= 'unique/Users_view.php';
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true);
		
		
		$this->title .= $this->lang->line($this->_controller_name);
		$this->init();

		$this->_set('_debug', FALSE);
		$this->Users_model->_set('_debug', FALSE);
		$this->load->library('calendar');

	}
	
	function view($id){
		$this->bootstrap_tools->_SetHead('assets/vendor/chart.js/Chart.js','js');
		$this->load->model('Input_model');
		
		$this->Input_model->_set('group_by', ['user','YEAR(billing_date)','MONTH(billing_date)']);
		$this->Input_model->_set('order'   , ['YEAR(billing_date)'=>'DESC','MONTH(billing_date)'=>'DESC','user'=>'DESC']);		
		
		$datas = $this->Input_model->get_stats_user(null,null,$id);
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
					$stats['line'][$year][$month] = $tmp[$year][$month]->SUM_TOUR;
					@$stats['global'][$year] += $tmp[$year][$month]->SUM_TOUR;
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
		parent::view($id);
	}

}
