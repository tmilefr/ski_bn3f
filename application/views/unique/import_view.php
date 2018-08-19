<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo Lang('Import_files');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			
		</h5>
		<p class="card-text">
			<?php 


foreach($files AS $key=>$file){
	echo '<div class="form-row"><div class="form-group col-md-4">';
	echo $this->bootstrap_tools->input_checkbox('file[]',$file);
	echo '</div><div class="form-group col-md-4">';
	echo $file;
	echo '</div><div class="form-group col-md-4">';
	echo $this->bootstrap_tools->input_select('process[]',$process);
	echo '</div></div>';
}
	
?>
		</p>
	  </div>
	</div>	
</div>






