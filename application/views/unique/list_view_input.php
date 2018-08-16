<?php
//echo '<pre><code>'.print_r($datas , 1).'</code></pre>';
?>

<div class="container-fluid">
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col"><?php echo Lang('input');?></th>
			<th scope="col"><?php echo Lang('Month');?></th>
			<th scope="col"><?php echo Lang('Year');?></th>
			<th scope="col"><?php echo Lang('Number');?></th>
		 </tr>
	  </thead>
	  <tbody>
	<?php 
	foreach($datas AS $key => $data){
		echo '<tr>';
		echo '<td>';
			
		echo '</td>';	
		echo '<td>'.$data->MONTH.'</td>';
		echo '<td>'.$data->YEAR.'</td>';
		echo '<td>'.$data->NB.'</td>';
		echo '</tr>';
	}
	?>
	</tbody>
	</table>
</div>


