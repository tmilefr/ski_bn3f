<?php
echo form_open('Users_controller/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

echo form_error('name', 	'<div class="alert alert-danger">', '</div>');
echo form_error('surname', 	'<div class="alert alert-danger">', '</div>');
echo form_error('section', 	'<div class="alert alert-danger">', '</div>');
echo form_error('family', 	'<div class="alert alert-danger">', '</div>');

echo form_error('adress', 	'<div class="alert alert-danger">', '</div>');
echo form_error('postalcode', 	'<div class="alert alert-danger">', '</div>');
echo form_error('town', 	'<div class="alert alert-danger">', '</div>');
echo form_error('country', 	'<div class="alert alert-danger">', '</div>');
echo form_error('email', 	'<div class="alert alert-danger">', '</div>');
?>

<div class="card" >
  <div class="card-body">
	<div class="form-row">
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('name');
				echo $this->render_object->RenderFormElement('name'); 
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('surname');
				echo $this->render_object->RenderFormElement('surname');
			?>
		</div>
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('section');
				echo $this->render_object->RenderFormElement('section'); 
			?>
		</div>	
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
			<?php 
				echo $this->render_object->label('family');
				echo $this->render_object->RenderFormElement('family');
			?>
		</div>
			<span class="align-bottom text-success"><br/><br/><?php echo Lang('OU');?></span>
	</div>
	
	
	<div class="border border-success mx-auto">
		<div class="form-row">
			<div class="form-group col-md-2">
				<?php 
					echo $this->render_object->label('adress');
					echo $this->render_object->RenderFormElement('adress');
				?>
			</div>	
			<div class="form-group col-md-2">
				<?php 
					echo $this->render_object->label('postalcode');
					echo $this->render_object->RenderFormElement('postalcode');
				?>
			</div>
			<div class="form-group col-md-2">
				<?php 
					echo $this->render_object->label('town');
					echo $this->render_object->RenderFormElement('town'); 
				?>
			</div>
			<div class="form-group col-md-2">
				<?php 
					echo $this->render_object->label('country');
					echo $this->render_object->RenderFormElement('country'); 
				?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4">
				<?php 
					echo $this->render_object->label('email');
					echo $this->render_object->RenderFormElement('email');
				?>
			</div>
		</div>
	</div>
  </div>
</div>
<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
<?php
echo form_close();
?>

