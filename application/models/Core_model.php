<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model {
	
	protected $table; 	//table used in model
	protected $key; 	//id used in model
	protected $key_value; 	
	protected $order; 	//sort used in model
	protected $direction;//direction used in model
	protected $autorized_fields = array();
	protected $autorized_fields_search = array();
	protected $datas = array(); // datas in model
	protected $filter = array();//filter for model
	protected $per_page = 20;
	protected $_debug = FALSE;
	protected $page = 1;
	protected $nb = null;
	protected $_debug_array = array();
	protected $like = array();
	protected $global_search = null;
	protected $defs = array();	
	protected $json = null;
	protected $json_path = APPPATH.'models/json/';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function distinct($table,$id,$value){
		try{
			$this->db->distinct();
			return $this->db->select("$id,$value")->get($table)->result();
		} catch (Exception $e) {
			//echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}	
	
	
	public function _init_def(){
		$this->defs = array();
		$json = file_get_contents($this->json_path.$this->json);
		$json = json_decode($json);
		foreach($json AS $field => $defs){
			$this->autorized_fields[]  = $field;
			if ($defs->search){
				$this->autorized_fields_search[] = $field;
			}
			switch($defs->type){
				case 'select':
					$data = array();
					if (isset($defs->values)){
						foreach($defs->values AS $key=>$value){
							$data[$key] = $value;
						}
					}
					$defs->values = $data;
				break;
				case 'select_database':
				  $datas_select = array();
				  preg_match('/(\w+)\((\w+)\,(\w+)\:(\w+)\)/', $defs->values, $param);
				  if (method_exists($this,$param[1])){
					  $datas = $this->{$param[1]}($param[2],$param[3],$param[4]);
				  } 
				  foreach($datas AS $data){
					$datas_select[$data->{$param[3]}] = $data->{$param[4]};
				  }
				  $defs->values = $datas_select;
				break;
			}
			
			$this->defs[$field] = $defs;
		}
	}
	
	public function truncate(){
		$this->db->truncate($this->table);	
	}	
	
	public function is_exist($field = 'id' ,$value){
		$query = $this->db->get_where($this->table , array($field => $value));
		$this->_debug_array[] = $this->db->last_query();
		
		if ($query->num_rows())
			return true;
		else
			return false;			
	}	

	public function get_all(){
		if (is_array($this->filter) AND count($this->filter)){
			foreach($this->filter AS $key => $value){
				$this->db->where($key , $value);
			}
		} 	
		if ($this->global_search){
			foreach($this->autorized_fields_search AS $key => $value){
				$this->db->or_like($value , $this->global_search);
			}
		} 			
		$datas = $this->db->select(implode(',',$this->autorized_fields))
					   ->order_by($this->order, $this->direction )
					   ->get($this->table)
					   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}
	
	public function get_pagination(){
		if (!$this->nb){
			if (is_array($this->filter) AND count($this->filter)){
				foreach($this->filter AS $key => $value){
					$this->db->where($key , $value);
				}
			} 	
			if ($this->global_search){
				foreach($this->autorized_fields_search AS $key => $value){
					if (!$key AND is_array($this->filter) AND count($this->filter)){
						$this->db->like($value , $this->global_search);
					} else {
						$this->db->or_like($value , $this->global_search);
					}
				}
			} 				
			$datas = $this->db->select($this->key)
                           ->order_by($this->order, $this->direction )
                           ->get($this->table);
			$this->nb = $datas->num_rows();
			$this->_debug_array[] = $this->db->last_query();
		}
		return $this->nb;
	}	
	
	
	public function get_distinct($field){
		$this->db->distinct();
		$datas = $this->db->select("$key,$field")->get($this->table)->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}		
	
	/* only one ? really ? */
	public function get_one()
	{
		$this->db->select('*')
				 ->from($this->table)
				 ->where($this->key, $this->key_value);
		$datas = $this->db->get()->row();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
	}

	public function post($datas)
	{
		/*foreach ($datas AS $key=>$fields){
			if (!in_array($field, $this->$this->autorized_fields)){
				unset($this->datas[$key]);
			}
		}*/
		$this->db->insert($this->table, $datas);
		return $this->db->insert_id();
		$this->_debug_array[] = $this->db->last_query();
	}

    public function get(){
		if (is_array($this->filter) AND count($this->filter)){
			$this->db->group_start();
			foreach($this->filter AS $key => $value){
				$this->db->where($key , $value);
			}
			$this->db->group_end();
		} 
		if ($this->global_search){
			$this->db->group_start();
			foreach($this->autorized_fields_search AS $key => $value){
				if (!$key AND is_array($this->filter) AND count($this->filter)){
					$this->db->like($value , $this->global_search);
				} else {
					$this->db->or_like($value , $this->global_search);
				}
			}
			$this->db->group_end();
		} 				
		if ($this->per_page){
			$this->db->limit( $this->per_page , $this->page);
		}

		
        $datas = $this->db->select( ($this->autorized_fields ? implode(',',$this->autorized_fields) : '*' ) )
                           ->order_by($this->order, $this->direction )
                           ->get($this->table)
						   ->result();
		$this->_debug_array[] = $this->db->last_query();
		return $datas;
    }

	public function put()
	{
		foreach ($this->datas AS $field=>$data){
			if (!in_array($field, $this->autorized_fields)){
				unset($this->datas[$key]);
			}
		}
		$this->db->where($this->key, $this->key_value);
		$this->db->update($this->table, $this->datas);		
		$this->_debug_array[] = $this->db->last_query();
	}

	public function delete()
	{
		$this->db->where_in($this->key, $this->key_value)
				 ->delete($this->table);
	}

	public function _set($field,$value){
		$this->$field = $value;
	}

	public function _get($field){
		return $this->$field;
	}
	
	public function __destruct(){
		if ($this->_debug){
			echo '<pre><code>'.print_r($this ,1).'</code></pre>';
		}
	}	

}

/* End of file Core_model.php */
/* Location: ./application/models/Core_model.php */
