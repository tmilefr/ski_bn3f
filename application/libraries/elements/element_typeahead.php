<?php
/* * element_checkbox.php * CHECKBOX Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_typeahead extends element
{	
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_typeahead($this->name, $this->value);	
	}
	
	public function Render(){
		return (($this->value) ? LANG($this->name.'_'.$this->value):$this->name.'_NO');
	}
}

