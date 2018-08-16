<div class="card" >
  <div class="card-body">
<?php
echo form_open('Users_controller/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

echo form_error('name', 	'<div class="alert alert-danger">', '</div>');
echo form_error('surname', 	'<div class="alert alert-danger">', '</div>');
echo form_error('section', 	'<div class="alert alert-danger">', '</div>');
echo form_error('family', 	'<div class="alert alert-danger">', '</div>');
?>
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

	</div>
</div>
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo $this->render_object->label('family');
			echo $this->render_object->RenderFormElement('family');
		?>
	</div>
	<div class="form-group col-md-6">
		<?php 
			echo $this->render_object->label('section');
			echo $this->render_object->RenderFormElement('section'); 
		?>
	</div>	
</div>
<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
<?php
echo form_close();
?>
</div>
</div>
