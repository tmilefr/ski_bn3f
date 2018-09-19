<?php
/* * element_select.php * SELECT Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_select extends element
{
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->input_select($this->name, $this->values, $this->value);
	}
	
	public function Render(){
		if (isset($this->values[$this->value]))
			return $this->values[$this->value];
		else
			return $this->value;		
	}
}

