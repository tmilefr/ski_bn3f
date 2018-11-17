<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<h5 class="card-title"><?php echo Lang('invoices_period');?></h5>
	  </div>
	  <div class="card-body">	
		<table class="table table-striped table-sm">
		  <thead>
			<tr>							
				<th scope="col"><?php echo LANG('month');?></th>		
				<th scope="col"><?php echo LANG('year');?></th>
				<th scope="col" class="text-right"><?php echo LANG('sum');?></th>
				<th scope="col">&nbsp;</th>
				<th scope="col">&nbsp;</th>
			  </tr>
		  </thead>
		  <tbody>
		<?php 
		$year = 0;
		foreach($datas AS $key => $data){
			if ($year != $data->year){
				$year = $data->year;
				echo '<tr><td colspan="5"><h3>'.$year.' - '.$stats[$year].'</h3></td></tr>';
			}			
			
			echo '<tr>';
			echo '<td>'.$this->render_object->RenderElement('month',$data->month).'</td><td>'.$data->year.'</td><td class="text-right">'.$data->SUM.'</td><td><a href="'.base_url('Invoice_controller/recap/').str_replace(',','_',$data->month).'/'.$data->year.'/"><span class="oi oi-zoom-in"></span>'.LANG('details').'</a></td>';	
			echo '<td>'.$data->url_pdf.'</td>';
			echo '</tr>';
		}
		?>
		</tbody>
		</table>
	</div>
</div>
</div>

