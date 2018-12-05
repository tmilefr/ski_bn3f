<?php
/*
 * element_checkbox.php
 * CHECKBOX Object in page
 * 
 */
require_once(APPPATH.'libraries/elements/element.php');

class element_typeahead extends element
{	
	public function __construct(){
		parent::__construct();
		if (isset($this->CI->bootstrap_tools))
		{
		$this->CI->bootstrap_tools->_SetHead('assets/plugins/js/bootstrap3-typeahead.js','js');
		$this->CI->bootstrap_tools->_SetHead('assets/js/ahead.js','js');
		}
	}
	
	public function RenderFormElement(){
		return '<input data-dst="input'.$this->name.'" name="ta'.$this->name.'" id="ta'.$this->name.'" data-source="'.base_url().$this->CI->_get('_controller_name').'/JsonData/'.$this->name.'"  autocomplete="off" class="typeahead form-control" value="'.((isset($this->values[$this->value])) ? $this->values[$this->value] : '').'"><input type="hidden" id="input'.$this->name.'" name="'.$this->name.'" value="'.$this->value.'">';
	}
	
	public function Render(){
		return ((isset($this->values[$this->value])) ? $this->values[$this->value] : $this->CI->lang->line('NOT_FOUND'));
	}
}

