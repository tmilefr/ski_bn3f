<div class="container-fluid">	
	<table class="table table-sm">
		<thead>
		<?php
		echo '<tr>';
		foreach($datas[0] AS $field=>$data){
				echo '<th>'.Lang($field).'</th>';
		}
		echo '<th>&nbsp;</th>';
		echo '</tr>';
		?>
		</thead>
		<tbody>
		<?php
		foreach($datas AS $key=>$data){
			echo '<tr>';
			foreach($data AS $field=>$value){
				echo '<td>'.$value.'</td>';
			}
			if ($data->billed){
				echo '<td><a href="'.base_url('Inputs_controller/rebill').'">'.Lang('ReBill').'</a></td>';
			} else {
				echo '<td><a href="'.base_url('Inputs_controller/bill').'">'.Lang('Bill').'</a></td>';
			}
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</div>


