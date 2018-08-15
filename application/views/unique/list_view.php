<div class="container-fluid">
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col">&nbsp;</th>
			<?php
			foreach($this->{$_model_name}->_get('defs') AS $field=>$defs){
				if ($defs->list === true){
					echo '<th scope="col">'.$this->render_object->render_link($field).'</a></th>';
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
	?>
	</tbody>
	</table>
</div>
<!- modal tools for delete ->
<div id="confirmModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo Lang('DELETE_CONFIRMATION');?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?php echo Lang('TXT_DELETE_CONFIRMATION');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo Lang('CANCEL');?></button>
        <button type="button" class="btn btn-danger" id="confirmModalYes"><?php echo Lang('YES');?></button>
      </div>
    </div>
  </div>
</div>

