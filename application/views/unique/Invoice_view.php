<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<nav class="navbar navbar-expand-lg"> 
				<ul class="navbar-nav mr-auto"> 
					<li class="nav-item"> 
					<?php
					echo  $invoice->content->header;
					?>
					</li> 
				</ul> 	
				<?php echo $invoice->month.' / '.$invoice->year.' : '. $invoice->sum.' €';?>
			</nav> 	
		</div>
		<?php
		foreach($invoice->content->part as $part){	?>
			<div class="card-body">
				<h5 class="card-title">
					<?php 
					echo $part->name;
					?>
				</h5>
			</div>
			<div class="card-text">
				<table class="table table-sm table-striped">
				<?php
				foreach($part->days AS $day){
					echo '<tr><td style="width: 40%">'.$day->date.'</td><td style="width: 30%">'.$day->rate.'</td><td style="width: 30%" class="text-right">'.$day->duration.' '.Lang('min').'</td></tr>';
				}
				?>
				</table>
			</div>
			<div class="card-footer">
				<table class="table table-sm table-striped">
				<?php 	
				$total = 0;
				foreach($part->footer AS $footer){
					echo '<tr><td style="width: 25(%">&nbsp;</td><td style="width: 25%">'.$footer->rate.'</td><td style="width: 25%" class="text-right">'.$footer->duration.' '.Lang('min').'</td><td style="width: 25%" class="text-right">'.$footer->cost.'</td></tr>';
					$total += $footer->cost;
				}
				echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class="text-right">'.$total.'</td></tr>';
				?>	
				</table>
			</div>
<?php } ?>
	</div>
</div>
