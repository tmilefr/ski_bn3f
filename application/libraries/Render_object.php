<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Render_object{

	protected $CI 		= NULL; //Controller instance 
	protected $datamodel= NULL; //Name of datamodel
	protected $id 		= NULL; //id of active element
	protected $dba_data = NULL; //Data from DATABASE from id element
	protected $_debug 	= FALSE;//Debug 
	protected $_model 	= FALSE;
	protected $_ui_rules= FALSE;
	protected $form_mod = FALSE;
	protected $notime	= TRUE;
	protected $_reset   = [];
	
	public function __construct(){
		$this->CI =& get_instance();
	}
	
	public function _set($field,$value){
		$this->$field = $value;
	}

	public function _get($field){
		return $this->$field;
	}
	
	public function _reset_value($field){
		$this->_reset[$field] = true;
	}	
	
	public function label($name){
		return $this->CI->bootstrap_tools->label($name);
	}	
	
	public function render_element_menu($data = null, $blocked = false ){
		$element_menu = '';
		if ($data){	
			$key_value = $data->{$this->_model->_get('key')};
		} else {
			if (isset($this->dba_data)){ // try to check database
				$key_value = $this->dba_data->{$this->_model->_get('key')};
			}
		}		
		if ($this->CI->_get('_rules')['delete']->autorize AND !$blocked)
			$element_menu .= $this->CI->bootstrap_tools->render_icon_link($this->CI->_get('_rules')['delete']->url 	, $key_value , 'oi-circle-x', 'btn-danger confirmModalLink');		
		if ($this->CI->_get('_rules')['edit']->autorize AND !$blocked)
			$element_menu .= $this->CI->bootstrap_tools->render_icon_link($this->CI->_get('_rules')['edit']->url 	, $key_value , 'oi-pencil'	, 'btn-warning');	
		if ($this->CI->_get('_rules')['view']->autorize AND !$blocked)
			$element_menu .= $this->CI->bootstrap_tools->render_icon_link($this->CI->_get('_rules')['view']->url	, $key_value , 'oi-zoom-in'	, 'btn-success');	
		return $element_menu;
	}
	
	public function render_link($field, $mode = 'list'){
		$filter 	= $this->CI->session->userdata($this->CI->set_ref_field('filter'));
		$direction 	= $this->CI->session->userdata($this->CI->set_ref_field('direction'));
		if ( $this->_model->_get('defs')[$field]->dbforge->type == 'INT'){
			$null_value = 0;
		} else {
			$null_value = '';
		}
		$add_string =  '';
		if (isset($filter[$field])){
			$add_string = '<span class="badge badge-success">'.((isset($this->_model->_get('defs')[$field]->values[$filter[$field]])) ? $this->_model->_get('defs')[$field]->values[$filter[$field]]:$filter[$field]).'</span>';
		}
		$string_render_link = '<div class="btn-group">';
		
		$string_render_link .= $this->CI->bootstrap_tools->render_head_link($field, $direction, $this->CI->_get('_rules')[$mode]->url, $add_string);
		if (isset($this->_model->_get('defs')[$field]->values)){
			$string_render_link .= $this->CI->bootstrap_tools->render_dropdown($field, $this->_model->_get('defs')[$field]->values, $this->CI->_get('_rules')[$mode]->url, $null_value );
		}
		$string_render_link .= '</div>';
		return $string_render_link;
	}
	
	public function Set_Rules_elements(){
		$this->_model = $this->CI->{$this->datamodel};
		
		$hidden_form = array('form_mod'=>(($this->id) ? 'edit':'add'));
		foreach($this->_model->_get('defs') AS $field=>$defs){
			if (isset($defs->rules) AND $defs->rules){
				$this->CI->form_validation->set_rules($field, $this->CI->lang->line($field) , $defs->rules);
			}	
		}	
	}
	//need to make a real element object.
	function RenderFormElement($field){
		$value = null;
		if (isset($this->_reset[$field]) AND  $this->_reset[$field]){
			
		} else {
			if ($value = set_value($field)){ //in first, POST data

			} else {
				if (isset($this->dba_data)){ // try to check database
					$value = $this->dba_data->{$field};
				}
			}
		}
		$this->_model->_get('defs')[$field]->element->_set('form_mod', $this->form_mod);
		$this->_model->_get('defs')[$field]->element->_set('value', $value);
		return $this->_model->_get('defs')[$field]->element->RenderFormElement();
	}
	
	function RenderElement($field,$value = null){
		if (!$value) {
			if (isset($this->dba_data)){ // try to check database
				$value = $this->dba_data->{$field};
			}
		}	
		$this->_model->_get('defs')[$field]->element->_set('form_mod', $this->form_mod);	
		$this->_model->_get('defs')[$field]->element->_set('value', $value);
		return $this->_model->_get('defs')[$field]->element->Render();
	}
	
	public function __destruct(){
		if ($this->_debug == TRUE){
			unset($this->CI);
			unset($this->_model);
			echo '<pre><code>'.print_r($this , 1).'</code></pre>';
		}
	}
	
}
