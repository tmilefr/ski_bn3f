<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<nav class="navbar navbar-expand-lg"> 
				<ul class="navbar-nav mr-auto"> 
					<li class="nav-item"> Facturation Minutes SKI BN3F : 
					<?php
					echo  $invoice->content->header;
					?>
					</li> 
					<li>
					&nbsp;
					</li>
					<li>
						<?php echo $url_pdf;?>
					</li>
				</ul> 	
				<?php echo $this->render_object->RenderElement('month', $invoice->month).' / '.$invoice->year.' : '. $invoice->sum.' €';?>
				
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
				<?php
				foreach($part->days AS $month=>$days){
					echo '<h3>'.$this->render_object->RenderElement('month',$month).'</h3>';
					echo '<table class="table table-sm table-striped">';
					foreach($days AS $day){	
						echo '<tr><td style="width: 40%">'.GetFormatDate($day->date).'</td><td style="width: 30%">'.$day->rate.'</td><td style="width: 30%" class="text-right">'.$day->duration.' '.Lang('min').'</td></tr>';
					}
					echo '</table>';
				}
				?>
			</div>
			<div class="card-footer">
				<table class="table table-sm table-striped">
				<?php 	
				$total = 0;
				foreach($part->footer AS $footer){
					echo '<tr><td style="width: 25(%">&nbsp;</td><td style="width: 25%">'.$footer->rate.'</td><td style="width: 25%" class="text-right">'.$footer->duration.' '.Lang('min').'</td><td style="width: 25%" class="text-right">'.$footer->cost.' &euro;</td></tr>';
					$total += $footer->cost;
				}
				echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td class="text-right">'.$total.' &euro;</td></tr>';
				?>	
				</table>
			</div>
<?php } ?>
	</div>
</div>
