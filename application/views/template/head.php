<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="fr">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php $this->bootstrap_tools->RenderAttachFiles('css');?>
		<title><?php echo $app_name;?></title>
	</head>
	<body>
	<div class="wrapper">
		<!-- top menu -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a href="#menu-toggle" id="menu-toggle"><span class="navbar-toggler-icon"></span></a>
			<a title="<?php echo $slogan;?>" class="navbar-brand" href="<?php echo base_url();?>Home"><?php echo $app_name;?> <small class="text-muted"></small></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		  
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="oi oi-cog"></span></a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?php echo base_url('Rates_controller/list');?>"><?php echo Lang('Rates');?></a>
						<a class="dropdown-item" href="<?php echo base_url('Import_controller/list');?>"><?php echo Lang('Import');?></a>
						<a class="dropdown-item" href="<?php echo base_url('Inputs_controller/list');?>"><?php echo Lang('Inputs');?></span></a>
						<a class="dropdown-item" href="#"><?php echo Lang('Parameter');?></a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#AboutModal"><?php echo Lang('About');?></a>
					</div>
				</li>
			</ul>
			<?php
			if ($search_object->autorize){
				$attributes = array('class' => 'form-inline', 'id' => 'myform');
				echo form_open($search_object->url, $attributes);?>
				<input class="form-control mr-sm-2" type="search" name='global_search' id='global_search' placeholder="Search" aria-label="Search" value="<?php echo $search_object->global_search;?>">
				<button class="btn btn-success btn-sm" type="submit"><span class="oi oi-magnifying-glass"></span></button>&nbsp;
				<?php if ($search_object->global_search){ ?>
					<a href='<?php echo base_url($search_object->url);?>/search/reset' class='btn btn-warning btn-sm'><span class="oi oi-circle-x"></span></a>
				<?php } ?>
				</form>
				<?php
			}
			?>
		  </div>
		</nav>	
		
		<!-- Sidebar  -->
		<div id="sidebar" class="bg-dark">
			<nav class="navbar navbar-dark bg-dark">
				<ul class="navbar-nav mr-auto flex-column">
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('Inputs_controller/billed');?>">
							<span class="oi oi-spreadsheet"></span> <?php echo Lang('Inputs');?></span>
						</a>
					</li>					
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('Invoice_controller/list');?>">
							<span class="oi oi-document"></span> <?php echo Lang('Invoice');?></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('Users_controller/list');?>">
							<span class="oi oi-person"></span> <?php echo Lang('User');?></span>
						</a>
					</li>	
					<li class="nav-item">
						<a class="nav-link" href="<?php echo base_url('Family_controller/list');?>">
							<span class="oi oi-people"></span> <?php echo Lang('Family');?></span>
						</a>
					</li>
				</ul>
			</nav>	
		</div>

		<!-- Page Content  -->
		<div id="content">	
			<nav class="navbar navbar-expand-lg navbar-light bg-light"> 
				<ul class="navbar-nav mr-auto"> 
					<li class="nav-item"> 
						<h2><?php echo $title;?></h2> 
					</li> 
				</ul> 
				<?php  
				if ($this->render_object->_get('_ui_rules') AND !$this->render_object->_get('form_mod')){  
					if ($this->render_object->_get('_ui_rules')['add']->autorize)
						echo '<a class="btn btn-success" href="'.$this->render_object->_get('_ui_rules')['add']->url.'"><span class="oi oi-plus"></span> '.$this->render_object->_get('_ui_rules')['add']->name.'</a>'; 
				} 
				?> 
			</nav> 	
		

