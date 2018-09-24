<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * MY_Controller
 *
 * @package     WebApp
 * @subpackage  Core
 * @category    Factory
 * @author      Tmile
 * @link        http://www.24bis.com
 */
class MY_Controller extends CI_Controller {
	
	protected $_autorised_get_key 	= array('order','direction','filter','page','repertoire','search','id'); //autorised key in url
	protected $_model_name			= false;
	protected $_debug_array  		= array();
	protected $_debug 				= FALSE;
	protected $_controller_name 	= null;
	protected $_rules				= null;
	protected $_autorize			= array();
	
	protected $view_inprogress 		= null;
	protected $data_view 			= array();
	protected $title 				= '';
	protected $json = null;
	protected $json_path = APPPATH.'models/json/';
	protected $per_page	= 20;
	protected $next_view = 'list';
					
	/**
	 * @brief Generic Constructor
	 * @returns  void()
	 * 
	 * 
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('tools');
		$this->load->library('Render_object');
		$this->load->library('bootstrap_tools');
		
		$this->lang->load('traduction');
		$this->config->load('app');
	}
	
	
	
	public function Jsondata($field){
		$users = $this->{$this->_model_name}->_get('defs')[$field];
		$tmp = '[';
		foreach($users->values AS $key => $value){
			$tmp .= '{ "id":'.$key.', "label":"'.$value.'"},';
		}
		echo substr($tmp,0,-1).']';
	}	
	
	/**
	 * @brief Load Json 
	 * @param $json 
	 * @param $model 
	 * @param $path 
	 * @returns 
	 * 
	 * 
	 */
	public function LoadJsonData($json,$model,$path){
		$this->load->model($model);
		$json = file_get_contents($this->json_path.$json);
		$json = json_decode($json);
		foreach($json->{$path} AS $family){
			$this->{$model}->post($family);
		}
	}	
	
	/**
	 * @brief Controller initialisation
	 * @returns 
	 * 
	 * 
	 */
	function init(){
		$this->process_url();
		
		$this->data_view['app_name'] 	= $this->config->item('app_name'); 
		$this->data_view['slogan'] 		= $this->config->item('slogan'); 
		$this->data_view['title'] 		= $this->title;
		
		$this->data_view['footer_line'] = '';	
		switch($this->config->item('debug_app')){
			case 'debug':
				$this->_set('_debug', TRUE);
			break;
			case 'profiler':
				$this->output->enable_profiler(TRUE);
			break;
		}
		if ($this->_model_name){
			$this->load->model($this->_model_name);
			$this->data_view['_model_name'] = $this->_model_name;// Need ?
			$this->render_object->_set('datamodel',	$this->_model_name); 
			$this->render_object->Set_Rules_elements();
			$this->{$this->_model_name}->_set('_debug', $this->_debug);
		}
		//Create CRUD URL		
		foreach($this->_autorize AS $key=>$value){
			$this->_set_ui_rules($key , $value);
		}
		//to permit use it in view.
		$this->render_object->_set('_ui_rules' , $this->_rules);
		
		$search_object 					= new StdClass();
		$search_object->url 			= $this->router->class.'/'.$this->router->method;
		$search_object->global_search 	= $this->session->userdata($this->set_ref_field('global_search'));
		$search_object->autorize 		= FALSE;
		$this->data_view['search_object'] = $search_object;
	}
	
	
	
	/**
	 * @brief Set Rules for CRUD URL
	 * @param $key 
	 * @param $value 
	 * @returns 
	 * 
	 * 
	 */
	function _set_ui_rules($key,$value){
		$rules = new StdClass();
		$rules->url 	=  base_url($this->_controller_name.'/'.$key);
		$rules->name 	= $this->lang->line(strtoupper($key).'_'.$this->_controller_name);
		$rules->autorize= $value;
		$this->_rules[$key] = $rules;
	}

	/**
	 * @brief 		Destructor
	 * @param       $this->_debug boolean
	 * @return      void()
	 * 
	 * 
	 */
	function __destruct(){
		if ($this->_debug){
			$this->bootstrap_tools->render_debug($this->_debug_array);
		}
	}	
	
	/**
	 * @brief 		Render View in Template
	 * @param       $this->view_inprogress
	 * @param		$this->data_view
	 * @return      void()
	 * 
	 * 
	 */
	function render_view(){
		if ($this->input->is_ajax_request()){
			$this->load->view($this->view_inprogress,	$this->data_view);
		} else {
			$this->load->view('template/head',			$this->data_view);
			$this->load->view($this->view_inprogress,	$this->data_view);
			$this->load->view('template/footer',		$this->data_view);	
		}
	}

	/**
	 * @brief _debug : Set Debug Array
	 * @param       $this->_debug_array
	 * @param		$msg (string)
	 * @return      void()
	 * 
	 * 
	 */
	function _debug($msg){
		$this->_debug_array[] = $msg;
	}
 
	/**
	 * @brief Processing variable on url
	 * @returns $this->session
	 * 
	 * 
	 */
	public function process_url(){
		if ($this->input->post('global_search')){
			$this->session->set_userdata( $this->set_ref_field('global_search') ,$this->input->post('global_search'));
		}
		$array = $this->uri->uri_to_assoc(3);
		foreach($array AS $field=>$value){
			if (in_array($field,$this->_autorised_get_key)){
				switch($field){
					case 'search':
						$this->session->set_userdata( $this->set_ref_field('global_search') ,'');
					break;
					case 'filter':
						$filtered = $this->session->userdata( $this->set_ref_field('filter') );
						if ($array['filter_value'] == 'all'){
							unset($filtered[$value]);
						} else {
							$filtered[$value] = $array['filter_value'];
						}
						$this->session->set_userdata( $this->set_ref_field('filter') , $filtered );
						
					break;
					default:
						$this->session->set_userdata( $this->set_ref_field($field) , $value );
					break;
				}
			}
		}
	} 
	
	/**
	 * @brief Attach variable to controller name
	 * @param $name 
	 * @returns 
	 * 
	 * 
	 */
	public function set_ref_field($name){
		return $name.'_'.$this->_controller_name;
	}
	
	/**
	 * @brief Generic list view ( Need PHP 7)
	 * @returns 
	 * 
	 * 
	 */
	public function list()
	{
		$this->data_view['search_object']->autorize = true;
		
		$this->{$this->_model_name}->_set('global_search'	, $this->session->userdata($this->set_ref_field('global_search')));
		$this->{$this->_model_name}->_set('order'			, $this->session->userdata($this->set_ref_field('order')));
		$this->{$this->_model_name}->_set('filter'			, $this->session->userdata($this->set_ref_field('filter')));
		$this->{$this->_model_name}->_set('direction'		, $this->session->userdata($this->set_ref_field('direction')));
		$this->{$this->_model_name}->_set('per_page'		, $this->per_page);
		$this->{$this->_model_name}->_set('page'			, $this->session->userdata($this->set_ref_field('page')));
		
		//GET DATAS
		$this->data_view['fields'] 	= $this->{$this->_model_name}->_get('autorized_fields');
		$this->data_view['datas'] 	= $this->{$this->_model_name}->get();
		
		$config = array();
		$config['per_page'] 	= $this->per_page;
		$config['base_url'] 	= $this->config->item('base_url').$this->_controller_name.'/list/page/';
		$config['total_rows'] 	= $this->{$this->_model_name}->get_pagination();
		$this->pagination->initialize($config);	

		
		$this->_set('view_inprogress','unique/list_view');
		$this->render_view();
	}	
	
	/**
	 * @brief Genric View Method
	 * @param $id 
	 * @returns 
	 * 
	 * 
	 */
	public function view($id){
		if ($id){
			$this->render_object->_set('id',		$id);
			$this->{$this->_model_name}->_set('key_value',$id);
			$dba_data = $this->{$this->_model_name}->get_one();
			$this->render_object->_set('dba_data',$dba_data);
		}	
		$this->_set('view_inprogress',$this->_list_view);
		$this->render_view();		
		
	}	
	
	/**
	 * @brief DELETE Method 
	 * @param $id 
	 * @returns 
	 * 
	 * 
	 */
	public function delete($id = 0){
		if ($id){
			$this->{$this->_model_name}->_set('key_value',$id);
			$this->{$this->_model_name}->delete();
		}
		redirect($this->_get('_rules')[$this->next_view]->url);
	}
	
	/**
	 * @brief ADD Method
	 * @returns 
	 * 
	 * 
	 */
	public function add(){
		$this->render_object->_set('form_mod', 'add');
		$this->edit();
	}
	
	/**
	 * @brief Edition Method
	 * @param $id 
	 * @returns 
	 * 
	 * 
	 */
	public function edit($id = 0)
	{		
		$this->data_view['id'] = '';
		if (!$id){
			if ($this->input->post('id') ){
				$id = $this->input->post('id');
			}
		}
		if ($id){
			$this->render_object->_set('id',		$id);
			$this->{$this->_model_name}->_set('key_value',$id);
			$dba_data = $this->{$this->_model_name}->get_one();
			$this->render_object->_set('dba_data',$dba_data);
			$this->render_object->_set('form_mod', 'edit');
			$this->data_view['id'] = $id;
		}		
		//$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
		if ($this->form_validation->run() === FALSE){


		} else {
			$datas = array();
			foreach($this->{$this->_model_name}->_get('autorized_fields') AS $field){
				$datas[$field] 	= $this->input->post($field);
			}
			if ($this->input->post('form_mod') == 'edit'){
				if (isset($datas['id']) AND $id = $datas['id']){
					$this->{$this->_model_name}->_set('key_value', $id);	
					$this->{$this->_model_name}->_set('datas', $datas);
					$this->{$this->_model_name}->put();
				} 
			} else if ($this->input->post('form_mod') == 'add'){
				$datas['id'] = $this->{$this->_model_name}->post($datas);
			}
			redirect($this->_get('_rules')[$this->next_view]->url);
		}
		$this->_set('view_inprogress',$this->_edit_view);
		$this->render_view();
	}

	/**
	 * @brief Router Default 
	 * @returns 
	 * 
	 * 
	 */
	public function index(){
		redirect($this->_get('_rules')['list']->url);
	}
	
	/**
	 * @brief Generic SETTER
	 * @param $field 
	 * @param $value 
	 * @returns 
	 * 
	 * 
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}

	/**
	 * @brief Generic GETTER
	 * @param $field 
	 * @returns 
	 * 
	 * 
	 */
	public function _get($field){
		return $this->$field;
	} 

}

?>
