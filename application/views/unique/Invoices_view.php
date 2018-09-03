<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			
		</div>
		<div class="card-text">
			<table class="table table-sm table-striped">
				<?php 
				$total = 0;
				foreach($invoices AS $invoice){  ?>
					<tr><td><?php echo $invoice->header;?></td><td><?php echo $invoice->month;?></td><td><?php echo $invoice->year;?></td><td class="text-right"><?php echo $invoice->sum;?></td></tr>
				<?php 
					$total += $invoice->sum;
				}
				?>
				<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class="text-right"><?php echo $total;?></td></tr>
			</table>
		</div>
	</div>
</div>
