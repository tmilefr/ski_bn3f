<div class="container-fluid">
<?php 
foreach($consos->input AS $family => $users){ 
	?>
	<div class="card">
	<div class="card-header">
			<nav class="navbar navbar-expand-lg"> 
				<ul class="navbar-nav mr-auto"> 
					<li class="nav-item"> 
						<?php
							echo  Lang('Family_bill').' '.$consos->family[$family]->name;
						?>
					</li> 
				</ul> 	
				<?php echo $consos->month.' / '.$consos->year;?>
			</nav> 	
	</div>
	<?php
	foreach($users as $user => $datas){	?>
		<div class="card-body">
			<h5 class="card-title">
				<?php 
					echo $consos->user[$user]->details->name.' '.$consos->user[$user]->details->surname;
				?>
			</h5>
			<p class="card-text">
				<table class="table table-sm table-striped">
				<?php
				foreach($datas['dates'] AS $key=>$values){
					echo '<tr><td rowspan="'.count($values).'">'.$key.'</td>';
					$i = 0;
					foreach($values AS $rate=>$duration){
						if ($i > 0){
							echo '<tr>';
						}
						echo '<td>'.$consos->rates[$rate]->name.'</td><td>'.$duration.' '.Lang('min').'</td>'; //amount
						if ($i == 0){
							echo '</tr>';
						}
						$i++;
					}
				}
				?>
				</table>
			</p>
		</div>
		<div class="card-footer">
			<table class="table table-sm table-striped">
			<?php 	
			$total = 0;
			foreach($datas['conso'] AS $rate=>$duration){
				echo '<tr><td>&nbsp;</td><td>'.$consos->rates[$rate]->name.'</td><td>'.$duration.' '.Lang('min').'</td><td>'.round($duration * $consos->rates[$rate]->amount, 2).'</td></tr>';
				$total += round($duration * $consos->rates[$rate]->amount, 2);
			}
			echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>'.$total.'</td></tr>';
			?>	
			
			</table>
		</div>
	<?php
	}?>
	</div><br/>
<?php
}

?>
</div>



