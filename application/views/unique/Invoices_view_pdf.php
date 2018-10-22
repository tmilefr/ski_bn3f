<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/pdf.css">
</head>
<body>
<div id="header">
	<table >
			<tr><td>
				<h2>Facturation Minutes SKI BN3F : </h2>
			</td><td class=" text-right">
				<h3><?php echo $month.' / '.$year;?></h3>
			</td>
			</tr>
		</table>
	</td></tr>
</div>
<div id="footer">
	<p class="footer">
		BN3F / SKI
	</p>
 </div>
<div id="content">
	<table class="table table-sm table-striped">
		<?php 
		$total = 0;
		$key = 0;
		foreach($invoices AS $invoice){  ?>
			<tr class="<?php echo ((is_float($key/2)) ? 'pair':'');?>"><td><?php echo $invoice->header;?></td><td><?php echo $invoice->month;?></td><td><?php echo $invoice->year;?></td><td class="text-right"><?php echo $invoice->sum;?></td></tr>
		<?php 
			$total += $invoice->sum;
			$key++;
		}
		?>
		<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class="text-right"><?php echo $total;?></td></tr>
	</table>
</div>
