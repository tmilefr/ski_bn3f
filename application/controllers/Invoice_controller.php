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
		$this->load->model('Users_model');
		$this->load->library('Libinvoice');
	}
	
	function recap($month = null,$year = null, $pdf = null){
		$month = str_replace('_',',',$month);
		$datas =  $this->{$this->_model_name}->get_recap($month,$year);
		$this->data_view['month'] = $month;
		$this->data_view['year'] = $year;
		$pdf = NameToFilename('RECAP_'.$this->data_view['month'].'_'.$this->data_view['year']).'.pdf';

		if (isset($month) AND isset($year)){
			foreach($datas AS $key=>$data){
				if ($data->user){
					$data->info = $this->Users_model->get_user($data->user, true);
				} else {
					$data->info = $this->Users_model->get_user($data->family, false);
				}
			}			
			$this->data_view['datas'] 	= $datas;
			$this->data_view['url_pdf'] = '<a target="_new" href="'.$this->libinvoice->_get('pdf_url_path').'/'.$pdf.'"><span class="oi oi-file"></span> '.Lang('invoices_list').'</a>';			
			$forced = true;
			if (!is_file($this->libinvoice->_get('pdf_path').$pdf) OR $forced == true){
				$this->libinvoice->DoRecap($this->data_view);
			}
			$this->_set('view_inprogress','unique/recap_view_users');
		} else {
			
			foreach($datas AS $key=>$data){
				$pdf = NameToFilename('RECAP_'.$data->month.'_'.$data->year).'.pdf';
				if (is_file($this->libinvoice->_get('pdf_path').$pdf)){
					$datas[$key]->url_pdf = '<a target="_new" href="'.$this->libinvoice->_get('pdf_url_path').'/'.$pdf.'"><span class="oi oi-file"></span> '.Lang('invoices_list').'</a>';
				} else {
					$datas[$key]->url_pdf = '';
				}
				if (isset($sum[$data->year])){
					$sum[$data->year]+= $data->SUM;
				} else {
					$sum[$data->year] = $data->SUM;
				}
			}
			$this->data_view['datas'] 	= $datas;
			$this->data_view['stats'] = $sum;
			$this->_set('view_inprogress','unique/recap_view');
		}
		$this->render_view();
	}
	
	function SendByMail(){
		$this->load->library('email');
		$this->email->from('ski@bn3f.fr', 'BN3F SKI');
		foreach($_POST['invoices'] AS $id){
			$this->{$this->_model_name}->_set('key_value',$id);
			$invoice = $this->{$this->_model_name}->get_one();
			if ($invoice->user){
				$invoice->info = $this->Users_model->get_user($invoice->user, true);
			} else {
				$invoice->info = $this->Users_model->get_user($invoice->family, false);
			}
			$pdf = NameToFilename($invoice->header.'_'.$invoice->month.'_'.$invoice->year).'.pdf';
			if (is_file($this->libinvoice->_get('pdf_path').$pdf)){
				$this->email->to($invoice->info->email);
				$this->email->subject('Minutes BN3F '.$invoice->month.' '.$invoice->year);
				$this->email->message('Testing the email class.');
				$this->email->attach( $this->libinvoice->_get('pdf_path').'/'.$pdf , 'attachment', $pdf , 'application/pdf');
				$this->data_view['sendmail'][] = $this->email->send();
			} else {
				$this->data_view['sendmail'][] = $this->libinvoice->_get('pdf_path').$pdf. ' not exist';
			}
		}
		$this->_set('view_inprogress','unique/sendmail');
		$this->render_view();
	}
	
	public function view($id){
		$this->data_view['url_pdf'] = '';
		if ($id){
			$this->{$this->_model_name}->_set('key_value',$id);
			$invoice = $this->{$this->_model_name}->get_one();
			$pdf = NameToFilename($invoice->header.'_'.$invoice->month.'_'.$invoice->year).'.pdf';
			if (!is_file($this->libinvoice->_get('pdf_path').$pdf)){
				$this->libinvoice->DoPDF($invoice);
			} else {
				$invoice->content = json_decode($invoice->content);
			}
			$this->data_view['url_pdf'] = '<a target="_new" href="'.$this->libinvoice->_get('pdf_url_path').'/'.$pdf.'"><span class="oi oi-file"></span> '.Lang('invoice').'</a>';
		}	
		$this->data_view['invoice'] = $invoice;
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();
		
	}		

}
