<div class="container-fluid">
<?php 
foreach($consos->input AS $user => $datas){ ?>

	<div class="card">
		<div class="card-header">
			<?php echo $user;?>
		</div>
		<div class="card-body">
			<h5 class="card-title">

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
						echo '<td>'.$rate.'</td><td>'.$duration.'</td>';
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
		<div class="card-footer text-muted">
			<table class="table table-sm">
			<?php 	
			foreach($datas['conso'] AS $rate=>$duration){
				echo '<tr><td>'.$rate.'</td><td>'.$duration.'</td><td></td></tr>';
			}
			?>
			</table>
		</div>
	</div>	
	<?php
}
?>
</div>



