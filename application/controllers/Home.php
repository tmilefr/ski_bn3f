<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	
	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Home';  //controller name for routing
		$this->title = '';
		$this->data_view['content'] = '<h1> Stats </h1>
		<div class="row">
    <div class="col-sm">
    
		<div class="card" style="width: 18rem;">
		  <div class="card-body">
			<h5 class="card-title"> Nombre d\'heure de bateau </h5>
			<p class="card-text">
				Juin : 15h </br>
				Juillet : 11h </br>
				Aout : 15h </br>
			</p>
		  </div>
		</div>
		
			</div>
		<div class="col-sm">
		<div class="card" style="width: 18rem;">
		  <div class="card-body">
			<h5 class="card-title">Top Ten membre Juin</h5>
			<p class="card-text">
				Membre 2 : 15h </br>
				Membre 3 : 11h </br>
				Membre 12 : 15h </br>
			</p>
		  </div>
		</div>
	</div>
		<div class="col-sm">
		<div class="card" style="width: 18rem;">
		  <div class="card-body">
			<h5 class="card-title">Top Ten membre Juillet</h5>
			<p class="card-text">
				Membre 2 : 15h </br>
				Membre 3 : 11h </br>
				Membre 12 : 15h </br>
			</p>
		  </div>
		</div>
		
  </div>
</div>		
		';
		$this->init();
	}

	public function index()
	{
		$this->_set('view_inprogress','home_page');
		$this->render_view();
	}
}
