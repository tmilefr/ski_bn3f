<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_controller extends MY_Controller {

	protected $data_path = '';
	
	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Import_controller';  //controller name for routing
		$this->title = '';
		$this->init();
		$this->load->model('GenericSql_model');
		$this->data_path = str_replace('application/','data/',APPPATH);
		
	}
	
	function MsSql2Mysql($string){
		$pattern = '@(.*)VALUES(.*)@i';
		if (strpos($string,'SET IDENTITY_INSERT') === false){				
			$sql = str_replace([', N\'','[',']','\'dbo\'.'],[',\'','\'','\'',''],$string);
			preg_match($pattern, $sql, $matches);
			$new_sql = str_replace('\'','',$matches[1]).'VALUES'.$matches[2];
			return $new_sql;
		}
	}

	public function list()
	{
		
		$this->data_view['content'] = $this->Mapper();
		
		$this->_set('view_inprogress','unique/import_view');
		$this->render_view();
	}
	
	function Mapper(){
		$sql = 'INSERT INTO users (name, surname, oldid)
				SELECT Nom, Prenom, ID
				FROM Membres';
		return $this->GenericSql_model->exec($sql);
	}
	
	function SyncMembers(){
		$file = file($this->data_path.'dbo.Membres.data.sql');
		$this->GenericSql_model->exec('TRUNCATE Membres');
		$str = '';
		foreach($file AS $lign){
			if ($sql = $this->MsSql2Mysql($lign)){
				$str .= '<p>'.$sql.'  '.$this->GenericSql_model->exec($sql).'</p>';
			}
		}
		return $str;
	}
	
	function SyncTours(){
		$file = file($this->data_path.'dbo.Tours.data.sql');
		$this->GenericSql_model->exec('TRUNCATE Tours');
		$str = '';
		foreach($file AS $lign){
			if ($sql = $this->MsSql2Mysql($lign)){
				$str .= '<p>'.$sql.'  '.$this->GenericSql_model->exec($sql).'</p>';
			}
		}
		return $str;
	}	

}
