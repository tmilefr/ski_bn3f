<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
			<?php echo Lang('Family').' '.$this->render_object->RenderElement('name');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php echo $this->render_object->RenderElement('email');?>
		</h5>
		<p class="card-text">
			<?php 
				echo $this->render_object->RenderElement('adress').'<br/>';
				echo $this->render_object->RenderElement('postalcode').' '.$this->render_object->RenderElement('town').' '.$this->render_object->RenderElement('country') ; 
			?>
		</p>
		<?php
			echo $this->render_object->render_element_menu();
		?>	
	  </div>
	</div>	
</div>
