<div class="container-fluid">	
	<table class="table table-sm table-striped">
		<thead>
		<?php
		echo '<tr>';
		echo '<th scope="col">&nbsp;</th>';
		foreach($datas[0] AS $field=>$data){
				echo '<th class="text-center">'.Lang($field).'</th>';
		}
		echo '<th>&nbsp;</th>';
		echo '<th>&nbsp;</th>';
		echo '</tr>';
		?>
		</thead>
		<tbody>
		<?php
		
		foreach($datas AS $key=>$data){
			echo '<tr>';
			echo '<th scope="col">&nbsp;</th>';
			foreach($data AS $field=>$value){
				switch($field){
					case 'NB':
						echo '<td class="text-right">'.$value.' tour(s)';
					break;
					case 'SUM':
						echo '<td class="text-right">'.$value.' min';
					break;
					case 'billed':
						echo '<td class="text-right">'.(($value) ? 'Oui' : 'non');
					break;
					case 'MONTH':
						echo '<td class="">'.$MONTHS[$value];
					break;
					case 'YEAR':
						echo '<td class="text-right">'.$value;
					break;
					default:
						echo '<td class="">'.$value;
				}
				
				echo '</td>';
			}
			echo '<td class="text-right">';
			if ($data->billed){
				echo '<span class="badge badge-warning"><a href="'.base_url('Inputs_controller/make_bill').'/rebill/on/month/'.$data->MONTH.'/year/'.$data->YEAR.'">'.Lang('ReBill').'</a></span>';
			} else {
				echo '<span class="badge badge-success"><a href="'.base_url('Inputs_controller/make_bill').'/rebill/off/month/'.$data->MONTH.'/year/'.$data->YEAR.'">'.Lang('Bill').'</a></span>';
			}
			echo '</td><td class="text-right">';
			$recap = 'RECAP_'.$data->MONTH.'_'.$data->YEAR.'.pdf';
			if (is_file($pdf_path.$recap)){
				echo '<a target="_new" href="'.$pdf_url_path.'/'.$recap.'"><span class="oi oi-file"></span> '.Lang('RECAP').'</a>';
			}
			echo '</td>';
			echo '</tr>';
		}
		?>
		</tbody>
	</table>
</div>


