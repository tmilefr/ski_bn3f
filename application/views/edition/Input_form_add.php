	
<div class="card" >
  <div class="card-body">

	
<?php

echo form_open('Inputs_controller/'.$this->render_object->_get('form_mod'), array('class' => '', 'id' => 'edit') , array('form_mod'=>$this->render_object->_get('form_mod'),'id'=>$id) );
echo form_error('billing_date', 	'<div class="alert alert-danger">', '</div>');
echo form_error('user', 	'<div class="alert alert-danger">', '</div>');
echo form_error('rates', 	'<div class="alert alert-danger">', '</div>');
echo form_error('duration', '<div class="alert alert-danger">', '</div>');
echo form_error('close', 	'<div class="alert alert-danger">', '</div>');

echo $this->render_object->RenderFormElement('created'); 
echo $this->render_object->RenderFormElement('updated'); 

?>
<div class="form-row">
	<div class="form-group col-md-2">
		<?php 
			echo $this->bootstrap_tools->label('billing_date');
			echo $this->render_object->RenderFormElement('billing_date'); 
		?>
	</div>
	<div class="form-group col-md-2">
		<?php 
			echo $this->bootstrap_tools->label('user');
			echo $this->render_object->RenderFormElement('user');
		?>
	</div>

	<div class="form-group col-md-2">
		<?php 
			echo $this->bootstrap_tools->label('rates');
			echo $this->render_object->RenderFormElement('rates');
		?>
	</div>
	<div class="form-group col-md-2">
		<?php 
			echo $this->bootstrap_tools->label('duration');
			echo $this->render_object->RenderFormElement('duration'); 
		?>
	</div>
	<div class="form-group col-md-2">
		<div class="form-group form-check">
			<?php 
				echo $this->render_object->RenderFormElement('close'); 
			?>
			<label class="form-check-label" for="inputclose"><?php echo Lang('close');?></label>
		 </div>
		
		
	</div>
	<div class="form-group col-md-2">
		<button type="submit" class="btn btn-primary"><?php echo $this->render_object->_get('_ui_rules')[$this->render_object->_get('form_mod')]->name;?></button>
	</div>
</div>

<?php
echo form_close();
?>
  </div>
</div>
<?php if (isset($datas)){ ?>
	<h3><?php echo Lang('LAST_INPUTS');?></h3>
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col">&nbsp;</th>
			<?php
			foreach($this->{$_model_name}->_get('defs') AS $field=>$defs){
				if ($defs->list === true){
					echo '<th scope="col">'.Lang($field).'</th>';
				}
			}
			?>

		  </tr>
	  </thead>
	  <tbody>
	<?php 
	foreach($datas AS $key => $data){
		echo '<tr>';
		echo '<td>';
			echo $this->render_object->render_element_menu($data);
		echo '</td>';	

		foreach($this->{$_model_name}->_get('defs') AS $field=>$defs){
			if ($defs->list === true){
				echo '<td>'.$this->render_object->RenderElement($field, $data->{$field}).'</td>';
			}
		}
		echo '</tr>';
	}
}
?>
</tbody>
</table>
