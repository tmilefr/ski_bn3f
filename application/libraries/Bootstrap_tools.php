<?php
defined('BASEPATH') || exit('No direct script access allowed');
Class Bootstrap_tools{

	protected $CI = null; //base controller 

	protected $_head = array();

	public function __construct(){
		$this->CI =& get_instance();
		$this->_SetHead('assets/js/jquery-3.3.1.min.js','js');
		$this->_SetHead('assets/vendor/bootstrap/js/bootstrap.bundle.js','js');

		$this->_SetHead('assets/vendor/bootstrap/css/bootstrap.min.css','css');
		$this->_SetHead('assets/vendor/open-iconic/css/open-iconic-bootstrap.css','css');
		$this->_SetHead('assets/css/app.css','css');

		/* UI TOOLS */
		$this->_SetHead('assets/js/toggle_menu.js','js');
		$this->_SetHead('assets/js/confirm.js','js');
		
	}
	
	function _SetHead($file,$type){
		$this->_head[$type][$file] = $file;
	}
	
	
	function RenderAttachFiles($opt = 'js'){
		foreach($this->_head[$opt] AS $file){
			switch($opt){
				case 'js':
					echo  '<script src="'.base_url().$file.'"></script>'."\n";
				break;
				case 'css':
					echo '<link rel="stylesheet" href="'.base_url().$file.'">'."\n";
				break;
			}
		}
	}
	
	public function render_table($head = [],$datas , $table_style = '', $limit = 0){
		$table = '<table class="table '.$table_style.'">';
		if (count($head)){
			$table .= '<head><tr>';
			foreach($head AS $scope=>$name){
				$table .= '<th scope="'.$scope.'">'.$this->CI->lang->line($name).'</th>';
			}
			$table .= '</tr></head>';
		}
		if (count($datas)){
			foreach($datas AS $lign=>$data){
				if (($limit AND $lign < $limit) OR !$limit){
					$table .= '<tr>';
					foreach($head AS $scope=>$name){
						$table .= '<td>'.$data->$name.'</td>';
					}
					$table .= '</tr>';
				}
			}
		}
		$table .= '</table>';
		return $table;
	}
	
	public function _set($field,$value){
		$this->$field = $value;
	}

	public function _get($field){
		return $this->$field;
	}	
	
	public function render_icon_link($url,$id,$icon, $color){
		return '<a class="btn btn-sm '.$color.'"  href="'.$url.'/'.$id.'"><span class="oi '.$icon.'"></span></a>&nbsp;';
	}
	
	
	public function render_dropdown($field,$values, $url, $null_value = ''){
		$string_render_dropdown = '';
		if (is_array($values) AND count($values)){
			$string_render_dropdown .= '<ul class="navbar-nav mr-auto">
			<a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" id="navbarDropdownFrom" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
				foreach($values AS $key => $value){
					$string_render_dropdown .= '<a class="dropdown-item" href="'.$url.'/filter/'.$field.'/filter_value/'.$key.'">'.$this->CI->lang->line($value).'</a>';
				}
				$string_render_dropdown .= '<a class="dropdown-item" href="'.$url.'/filter/'.$field.'/filter_value/all">'.$this->CI->lang->line('All').'</a>';
				$string_render_dropdown .= '<a class="dropdown-item" href="'.$url.'/filter/'.$field.'/filter_value/'.$null_value.'">'.$this->CI->lang->line('N/A').'</a>';
			$string_render_dropdown .= '</div></ul>';
		}
		return $string_render_dropdown;
	}	
	
	function render_debug($messages){
		if (is_array($messages) AND count($messages)){
			echo '<a class="btn btn-warning btn-sm" data-toggle="collapse" href="#collapseDEBUG" role="button" aria-expanded="false" aria-controls="collapseExample">DEBUG</a>';
			echo '<div class="collapse" id="collapseDEBUG">';
			echo '<table class="table table-sm">';
			foreach($messages AS $message){
				echo '<tr><th scope="row">'.$message->from.'</th><td>'.$message->type.'</td><td>'.$message->file.'</td><td>'.$message->line.'</td><td>'.$message->message.'</td></tr>';
			}
			echo '</table></div>';
		}
	}
	
	public function render_head_link($field, $direction, $url, $add_string ){
		return '<a class="nav-link " href="'.$url.'/order/'.$field.'/direction/'.(($direction == 'desc') ? 'asc':'desc').'">'.$this->CI->lang->line($field).' '.$add_string.'</a>';
	}

	public function label($name){
		return '<label for="input'.$name.'">'.$this->CI->lang->line($name).'</label>';
	}
	
	public function input_checkbox($field, $value){
		return form_checkbox($field, 1 , $value , ' class="form-check-input" id="input'.$field.'" ');
	}
	
	public function input_date($name,$value){
		$this->_SetHead('assets/js/datepicker_start.js','js');
		
		if (!$value OR $value == '0000-00-00'){
			$value = date('Y-m-d');
		}
		
		return '<div class="input-group">
				  <input autocomplete="off" class="form-control datepicker" name="'.$name.'" id="input'.$name.'" value="'.$value.'" type="text">
				  <div class="input-group-append">
					 <span class="input-group-text"><span class="oi oi-calendar"></span></span>
				  </div>
			  </div>';
	}
	

	
	
	public function input_text($name,$placeholder = '',$value = ''){
		return '<input type="text" class="form-control" name="'.$name.'" id="input'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'">';
	}
	public function password_text($name,$placeholder = '',$value = ''){
		return '<input type="password" class="form-control" name="'.$name.'" id="input'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'">';
	}

	
	public function input_select($name, $values, $selected = ''){
		$input_select = '<select id="input'.$name.'" name="'.$name.'" class="form-control">';
		$input_select .= '<option '.(($selected == '') ? 'selected="selected"':'').'>...</option>';
		foreach($values AS $key=>$value){
			$input_select .= '<option value="'.$key.'" '.(($key == $selected AND $selected) ? 'selected="selected"':'').'>'.$value.'</option>';
		}
		$input_select .= '</select>';
		return $input_select;
	}
	
	function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	function random_color() {
		return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}
	
	
}
