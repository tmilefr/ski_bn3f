<?php
echo form_open('Invoice_controller/SendByMail', array('class' => '', 'id' => 'senmail') , array() );
?>
<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<h5 class="card-title"><?php echo Lang('invoice_list_in').' '.$this->render_object->RenderElement('month', $month).' / '.$year;?> <?php echo $url_pdf;?></h5>
		</div>
		<div class="card-body">	
			<table class="table table-striped table-sm">
			  <thead>
				<tr>			
					<th scope="col"><?php echo Lang('family');?></th>
					<th scope="col" class="text-right"><?php echo Lang('sum');?></th>
					<th scope="col"><?php echo Lang('E-mail');?></th>
					<th scope="col"><?php echo Lang('invoice');?></th>	
					<th scope="col">&nbsp;</th>					
				  </tr>
			  </thead>
			  <tbody>

			<?php 
			$sum = 0;
			foreach($datas AS $key=>$invoice){
				echo '<tr>';
				echo '<td>'.$invoice->header.'</td>';
				echo '<td class="text-right">'.$invoice->sum.'</td>';
				echo '<td>'.(($invoice->info->email) ? $invoice->info->email:'').'</td>';
				echo '<td>'.(($invoice->pdf) ? $invoice->pdf:'').'</td>';
				echo '<td><div class="form-check">'.(($invoice->info->email && $invoice->pdf) ? '<input class="form-check-input" type="checkbox" id="check'.$invoice->id.'" name="invoices[]" value="'.$invoice->id.'" />':'').'</div></td>';
				echo '</tr>';
				$sum += $invoice->sum;
			}
			echo '<tr><td class="text-right">'.Lang('total').'</td><td class="text-right">'.$sum.'</td><td colspan="3">&nbsp;</td></tr>';
			?>
			</tbody>
			</table>

			<div class="form-group text-right">
				<button type="submit" class="btn btn-primary"><?php echo Lang('sendmail');?></button>
			</div>	
		</div>
	</div>
</div>


<?php
echo form_close();
?>	


