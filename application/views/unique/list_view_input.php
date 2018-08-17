<?php
//echo '<pre><code>'.print_r($datas , 1).'</code></pre>';
?>

<div class="container-fluid">
	
	<?php echo $this->bootstrap_tools->input_select('year', $years , date('Y')); ?>
	
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col"><?php echo Lang('Year');?></th>
			<th scope="col" colspan="12"><?php echo Lang('Month');?></th>
		 </tr>
	  </thead>
	  <tbody>
	<?php 
	
	foreach($datas AS $year => $data){
		foreach($data AS $month => $obj){
			echo '<tr>';
			if ($month == 1)
			echo '<td rowspan="12">'.$year.'</td>';
			echo '<td>'.$month.'</td>';
			echo '<td>'.((is_object($obj)) ? $obj->NB:'').'</td>';
			echo '</tr>';
		}
	}
	?>
	</tbody>
	</table>
</div>


