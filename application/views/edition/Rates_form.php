<div class="card" >
  <div class="card-body">
	  <?php
echo form_open('Rates_controller/'.$this->render_object->_get('form_mod') , array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );

echo form_error('name', 	'<div class="alert alert-danger">', '</div>');
echo form_error('amount', 	'<div class="alert alert-danger">', '</div>');
?>
<div class="form-row">
	<div class="form-group col-md-6">
		<?php 
			echo $this->render_object->label('name');
			echo $this->render_object->RenderFormElement('name'); 
		?>
	</div>
	<div class="form-group col-md-6">
		<?php 
			echo $this->render_object->label('amount');
			echo $this->render_object->RenderFormElement('amount');
		?>
	</div>
</div>
<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
<?php
echo form_close();
?>
</div>
</div>
