<?php
/* * element_date.php * Date Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_date extends element
{	
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_date($this->name,$this->value);
	}
	
	public function Render(){
		return GetFormatDate($this->value);
	}
}

