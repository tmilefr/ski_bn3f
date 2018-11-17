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
					<th scope="col"><?php echo Lang('E-mail');?></th>
					<th scope="col"><?php echo Lang('family');?></th>
					<th scope="col" class="text-right"><?php echo Lang('sum');?></th>
				  </tr>
			  </thead>
			  <tbody>
			<?php 
			$sum = 0;
			foreach($datas AS $key=>$invoice){
				echo '<tr><td><input type="checkbox" name="invoices[]" value="'.$invoice->id.'" /></td><td>'.$invoice->header.'</td><td class="text-right">'.$invoice->sum.'</td></tr>';
				$sum += $invoice->sum;
			}
			echo '<tr><td>'.Lang('total').'</td><td class="text-right">'.$sum.'</td></tr>';
			?>
			</tbody>
			</table>

			<div class="form-group col-md-2">
				<button type="submit" class="btn btn-primary"><?php echo Lang('sendmail');?></button>
			</div>	
		</div>
	</div>
</div>


<?php
echo form_close();
?>	


