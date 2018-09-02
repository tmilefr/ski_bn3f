<div class="container-fluid">	
	<table class="table table-sm table-striped">
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
				echo '<td><a href="'.base_url('Inputs_controller/make_bill').'/rebill/on/month/'.$data->MONTH.'/year/'.$data->YEAR.'">'.Lang('ReBill').'</a></td>';
			} else {
				echo '<td><a href="'.base_url('Inputs_controller/make_bill').'/rebill/off/month/'.$data->MONTH.'/year/'.$data->YEAR.'">'.Lang('Bill').'</a></td>';
			}
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</div>


