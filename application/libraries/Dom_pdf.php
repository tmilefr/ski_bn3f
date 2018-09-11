<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  DOMPDF
* 
* Author: Geordy James 
*         @geordyjames
*          
*Location : https://github.com/geordyjames/Codeigniter-Dompdf-v0.7.0-Library
* Origin API Class: https://github.com/dompdf/dompdf
*          
* Created:  24.01.2017
* Created by Geordy James to give support to dompdf 0.7.0 and above 
* Mod by nL (init / reset function for multiple document)
* Description:  This is a Codeigniter library which allows you to convert HTML to PDF with the DOMPDF library
* 
*/
require_once APPPATH.'third_party/dompdf/autoload.inc.php';
		
use Dompdf\Dompdf;
use Dompdf\Options;

class Dom_pdf {
	
	var $CI;
	var $pdf_path = '';
	
	public function __construct() {
		$this->CI = & get_instance();
		$this->_init();
		$this->pdf_path = str_replace('application','data/invoices',APPPATH);
	}
	
	public function _init(){
		$options = new Options();
		$options->set('enable_html5_parser', true);
		$pdf = new Dompdf($options);	
		$this->CI->dompdf = $pdf;
	}
	
	public function reset(){
		unset($this->CI->dompdf);
		$this->_init();
	}
	
	//not sure that's good place for this ... need to do invoice lib
	function DoInvoice($invoice){
		$invoice->content = json_decode($invoice->content);
		$data_view['invoice'] = $invoice;
		$html = $this->CI->load->view('unique/Invoice_view_pdf.php', $data_view, true);
		$filename = str_replace(['\\',' ','/'],['_','_','_'] ,$invoice->header).'_'.$invoice->month.'_'.$invoice->year.'.pdf';
		$this->makePdf($filename, $html);
	}
	
	function makePdf($filename, $html){
		try{
			$this->reset();
			$this->CI->dompdf->load_html($html);        
			$this->CI->dompdf->render();
			file_put_contents($this->pdf_path.$filename, $this->CI->dompdf->output()); 
		} catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}	
}
