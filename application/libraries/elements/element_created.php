<?php
/* * element_created.php * created Date Object in page *  */require_once(APPPATH.'libraries/elements/element.php');

class element_created extends element
{	
	protected $form_mod;
	public function RenderFormElement(){
		if ($this->form_mod == 'edit'){
			
		} else {
			echo form_hidden($this->name , date('Y-m-d h:i:s'));
		}
	}
	
	public function Render(){
		return '';//GetFormatDate($this->value);
	}
}

