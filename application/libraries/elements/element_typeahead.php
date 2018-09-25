<?php
/* * element_checkbox.php * CHECKBOX Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_typeahead extends element
{	
	public function RenderFormElement(){
		$this->CI->bootstrap_tools->_SetHead('assets/plugins/js/bootstrap3-typeahead.js','js');
		$this->CI->bootstrap_tools->_SetHead('assets/js/ahead.js','js');		
		

		
		return '<input data-dst="input'.$this->name.'" name="ta'.$this->name.'" id="ta'.$this->name.'" data-source="'.base_url().$this->CI->_get('_controller_name').'/JsonData/'.$this->name.'"  autocomplete="off" class="typeahead form-control" value="'.$this->value.'"><input type="hidden" id="input'.$this->name.'" name="'.$this->name.'" value="'.$this->value.'">';
	}
	
	public function Render(){
		return (($this->value) ? LANG($this->name.'_'.$this->value):$this->name.'_NO');
	}
}

