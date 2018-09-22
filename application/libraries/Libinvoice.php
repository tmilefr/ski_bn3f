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
	
	public function reset(){
		if (isset($this->CI->dompdf))
			unset($this->CI->dompdf);
		$this->_init();
	}
	
	function DoRecap($data_view){
		$html = $this->CI->load->view('unique/Invoices_view_pdf.php', $data_view, true);
		$filename ='RECAP_'.$data_view['month'].'_'.$data_view['year'].'.pdf';
		$this->makePdf($filename, $html);
	}
	
	
	//not sure that's good place for this ... need to do invoice lib
	function DoInvoice($invoice){
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
	
	function SendByMail(){
		$this->CI->load->library('email');
		$this->CI->email->from('ski@bn3f.fr', 'Your Name');
		$this->CI->email->to('nicolas.laresser@gamail.com');
		//$this->CI->email->cc('another@another-example.com');
		$this->CI->email->subject('Email Test');
		$this->CI->email->message('Testing the email class.');
		$this->CI->email->attach($this->CI->dompdf->output(), 'attachment', $this->filename , 'application/pdf');
		$this->CI->email->send();
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
