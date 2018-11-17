<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/dompdf/autoload.inc.php';
		
use Dompdf\Dompdf;
use Dompdf\Options;

class Libinvoice {
	
	var $CI;
	var $pdf_path = '';
	var $filename = '';
	
	/**
	 * Constructor of class element.
	 * @return void
	 */	
	public function __construct() {
		$this->CI = & get_instance();
		$this->_init();
		$this->pdf_path = str_replace('application','data/invoices',APPPATH);
		$this->pdf_url_path = base_url().'data/invoices';
	}
	
	public function _init(){
		$options = new Options();
		$options->set('enable_html5_parser', true);
		$pdf = new Dompdf($options);	
		$this->CI->dompdf = $pdf;
	}
	
	function MakeInvoice($users){
		$invoice = new StdClass();
		$invoice->month = $this->defs->month;
		$invoice->year =  $this->defs->year;
		$invoice->header = $this->defs->family[$this->family]->name;
		$invoice->family =  $this->family;
		$invoice->sum = 0;
		foreach($users as $user => $datas){
			$part = new StdClass();
			$part->name = $this->defs->user[$user]->details->name.' '.$this->defs->user[$user]->details->surname;
			foreach($datas['dates'] AS $month=>$dates){
				foreach($dates AS $key=>$values){
					$i = 0;
					foreach($values AS $rate=>$duration){
						$day = new StdClass();
						$day->date = $key;
						$day->rate = $this->defs->rates[$rate]->name;
						$day->duration = $duration;
						$part->days[$month][] = $day;
					}
				}
			}
			$total = 0;
			foreach($datas['conso'] AS $rate=>$duration){
				$footer = new StdClass();
				$footer->rate = $this->defs->rates[$rate]->name;
				$footer->duration = $duration;
				$footer->cost = round($duration * $this->defs->rates[$rate]->amount, 2);
				$total += round($duration * $this->defs->rates[$rate]->amount, 2);
				$part->footer[] = $footer;
			}
			$invoice->part[] = $part;
			$invoice->sum += $total;
		}
		$invoice->content = json_encode($invoice);
		//no family
		if ( substr($this->family,0,1) == 'u'){
			$invoice->user = substr($this->family,1);
			$invoice->family = '';
			$invoice->header = Lang('User_bill').' '.$invoice->header;
		} else {
			$invoice->user = '';
			$invoice->header = Lang('Family_bill').' '.$invoice->header;
		}
		return $invoice;
	}
	
	public function reset(){
		if (isset($this->CI->dompdf))
			unset($this->CI->dompdf);
		$this->_init();
	}
	
	function DoRecap($data_view){
		$this->CI->render_object->_set('datamodel',	'Invoice_model'); 
		$this->CI->render_object->Set_Rules_elements();		
		$html = $this->CI->load->view('unique/recap_view_users_pdf.php', $data_view, true);
		$this->filename = NameToFilename('RECAP_'.$data_view['month'].'_'.$data_view['year']).'.pdf';
		$this->makePdf($html);
	}
	
	
	//not sure that's good place for this ... need to do invoice lib
	function DoPdf($invoice){
		$this->CI->render_object->_set('datamodel',	'Invoice_model'); 
		$this->CI->render_object->Set_Rules_elements();
		$invoice->content = json_decode($invoice->content);
		$data_view['invoice'] = $invoice;
		$html = $this->CI->load->view('unique/Invoice_view_pdf.php', $data_view, true);
		$this->filename = NameToFilename($invoice->header).'_'.$invoice->month.'_'.$invoice->year.'.pdf';
		$this->makePdf($html);
	}
	
	function makePdf($html){
		try{
			$this->reset();
			$this->CI->dompdf->load_html($html);        
			$this->CI->dompdf->render();
			file_put_contents($this->pdf_path.$this->filename, $this->CI->dompdf->output()); 
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}	

	
	
	/**
	 * Generic set
	 * @return void
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}
	/**
	 * Generic get
	 * @return void
	 */
	public function _get($field){
		return $this->$field;
	}	
}
