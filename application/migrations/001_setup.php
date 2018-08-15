<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_setup extends CI_Migration {

		/* Need to have
		
		CREATE TABLE IF NOT EXISTS `ci_sessions` (
			`id` varchar(128) NOT NULL,
			`ip_address` varchar(45) NOT NULL,
			`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
			`data` blob NOT NULL,
			KEY `ci_sessions_timestamp` (`timestamp`)
		);

		ALTER TABLE ci_sessions ADD PRIMARY KEY (id, ip_address);
		*/
        
		protected $json = null;
		protected $json_path = APPPATH.'models/json/';

		public function __construct(){
			parent::__construct();
		}

		public function _get_json($json){
			$json = file_get_contents($this->json_path.$json);
			$json = json_decode($json);
			$fields = array();
			foreach($json AS $field => $define){
				$def = array();
				foreach($define->dbforge AS $key=>$value){
					$def[$key] = $value;
				}
				$fields[$field] = $def;
			}
			return $fields;
		}

		public function LoadData($json,$model,$path){
			$this->load->model($model);
			$json = file_get_contents($this->json_path.$json);
			$json = json_decode($json);
			foreach($json->{$path} AS $family){
				$this->{$model}->post($family);
			}
		}	      
		
		function index(){
			$this->migration->version(1);
		}
		  
        
        public function up()
        {		
			//always init DBA
			$this->down();
			
			/* ex : Family table */
			$this->dbforge->add_field( $this->_get_json('Family.json') );
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('family');    
			/* Feeders  */
			$this->LoadData('Family_data.json','Family_model','Family');		

			$this->dbforge->add_field( $this->_get_json('Users.json') );
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('users');  
			/* Feeders  */
			$this->LoadData('Users_data.json','Users_model','Users');
			
			$this->dbforge->add_field( $this->_get_json('Rates.json') );
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('rates');  
			/* Feeders  */
			$this->LoadData('Rates_data.json','Rates_model','Rates');			
			
			
			$this->dbforge->add_field( $this->_get_json('input.json') );
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('inputs');  	
			
        }

        public function down()
        {
			$this->dbforge->drop_table('users'  , TRUE);
			$this->dbforge->drop_table('family' , TRUE);
			$this->dbforge->drop_table('rates' , TRUE);
        }
}

?>
