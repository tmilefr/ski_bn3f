<?php
/* * element_updated.php * created Date Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_updated extends element
{	
	protected $form_mod;
	public function RenderFormElement(){
		if ($this->form_mod == 'edit'){
			echo form_hidden($this->name , date('Y-m-d h:i:s'));
		} else {
			
		}
	}
	
	public function Render(){
		return '';//GetFormatDate($this->value);
	}
}

