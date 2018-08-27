<?php
	echo form_open(base_url('Inputs_controller/filter_set'), ['class' => '', 'id' => 'filter_set'] , ['id'=>$id,'from'=>$this->render_object->_get('form_mod')] );

	echo '<div class="form-row">
			<div class="form-group col-md-2">';
			echo $this->bootstrap_tools->input_select('month_in_progress', [4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre'], $month_in_progress);
	echo '	</div><div class="form-group col-md-2">
				<button type="submit" class="btn btn-primary">'.Lang('VALID').'</button>
		  </div>
	</div>';

	echo form_close();
	?>

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
			echo $this->render_object->label('billing_date');
			echo $this->render_object->RenderFormElement('billing_date'); 
		?>
	</div>
	<div class="form-group col-md-2">
		<?php 
			echo $this->render_object->label('user');
			echo $this->render_object->RenderFormElement('user');
		?>
	</div>

	<div class="form-group col-md-2">
		<?php 
			echo $this->render_object->label('rates');
			echo $this->render_object->RenderFormElement('rates');
		?>
	</div>
	<div class="form-group col-md-2">
		<?php 
			echo $this->render_object->label('duration');
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
	<h3><?php echo Lang('INPUTS_IN_MONTH');?></h3>
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col">&nbsp;</th>
			<?php
			foreach($this->{$_model_name}->_get('defs') AS $field=>$defs){
				if ($defs->list === true){
					echo '<th scope="col">'.$this->render_object->render_link($field,'add').'</a></th>';
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
			echo $this->render_object->render_element_menu($data, (($data->billed) ? true:false));
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
