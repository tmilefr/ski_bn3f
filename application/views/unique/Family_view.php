<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
			<?php echo Lang('Family').' '.$this->render_object->RenderElement('name');?>
	  </div>
	  <div class="card-body">
		<h3><?php echo Lang('REF_EMAIL');?></h3>
		<h5 class="card-title">
			<?php echo $this->render_object->RenderElement('email');?>
		</h5>
		<h3><?php echo Lang('REF_ADRESS');?></h3>
		<p class="card-text">
			<?php 
				echo $this->render_object->RenderElement('country') ; 
			?>
		</p>
		<h3><?php echo Lang('MEMBERS');?></h3>
		<?php
			echo '<table class="table table-md">';
			foreach($users AS $user){
				echo '<tr><td>'.$user->surname.'</td><td>'.$user->name.'</td></tr>';
			}
			echo '</table>';
			echo $this->render_object->render_element_menu();
		?>	
		
	  </div>
	</div>	
</div>
