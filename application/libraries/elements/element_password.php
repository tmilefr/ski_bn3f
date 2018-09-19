<?php
/* * element_password.php * PASSWORD Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_password extends element
{
	public function RenderFormElement(){
		return $this->CI->bootstrap_tools->password_text($this->name, $this->CI->lang->line($this->name) , $this->value);
	}
	
	public function Render(){
		return '********';//$this->value;
	}
}

