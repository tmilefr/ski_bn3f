<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */

class Invoice_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Invoice_controller';  //controller name for routing
		$this->_model_name 		= 'Invoice_model';	   //DataModel
		$this->_edit_view 		= '';//template for editing
		$this->_list_view		= 'unique/Invoice_view.php';
		$this->_autorize 		= array('add'=>false,'edit'=>false,'list'=>true,'delete'=>false,'view'=>true);
		
		
		$this->title .= $this->lang->line($this->_controller_name);
		
		$this->_set('_debug', FALSE);
		
		$this->init();
		
		$this->load->library('Dom_pdf');
	}
	
	
	
	
	public function view($id){
		$this->data_view['search_object']->autorize = false;
		if ($id){
			$this->{$this->_model_name}->_set('key_value',$id);
			$invoice = $this->{$this->_model_name}->get_one();
			$invoice->content = json_decode($invoice->content);
		}	
		$this->data_view['invoice'] = $invoice;
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();
		
	}		

}
