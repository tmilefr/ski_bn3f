<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/pdf.css">
</head>
<body>
<div id="header">
		<table >
			<tr><td><h2>
				Facturation Minutes SKI BN3F : 
				<?php
					echo  $invoice->content->header;
				?></h2>
			</td><td class=" text-right">
				<h3>
				<?php echo $invoice->month.' / '.$invoice->year.' : '. $invoice->sum.' €';?>
				</h3>
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
<?php
foreach($invoice->content->part as $part){	?>

		<h3>
			<?php 
			echo $part->name;
			?>
		</h3>
		<table>
		<?php
		foreach($part->days AS $key=>$day){
			echo '<tr class="'.((is_float($key/2)) ? 'pair':'').'"><td style="width: 25%">'.$day->date.'</td><td style="width: 25%">'.$day->rate.'</td><td style="width: 50%" class="text-right">'.$day->duration.' '.Lang('min').'</td></tr>';
		}
		?>
		</table>
		<br/><br/>
		<table>
		<?php 	
		$total = 0;
		foreach($part->footer AS $footer){
			echo '<tr><td style="width: 25 %">&nbsp;</td><td style="width: 25%">'.$footer->rate.'</td><td style="width: 25%" class="text-right">'.$footer->duration.' '.Lang('min').'</td><td style="width: 25%" class="text-right">'.$footer->cost.'</td></tr>';
			$total += $footer->cost;
		}
		echo '<tr><td class="sep_dashed" colspan="3">&nbsp;</td><td class="sep_dashed text-right">'.$total.'</td></tr>';
		?>	
		</table>
<?php } ?>
</div>
</body>
</html>

