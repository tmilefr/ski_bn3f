<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	
	<div class="row">
		<div class="col-sm">
			<canvas id="canvas_min"></canvas>
		</div>	
		<div class="col-sm">
			<div class="accordion" id="accordionTopUser">
			<?php foreach($TOP AS $year=>$tours){ ?>
				<div class="card">
					<div class="card-header" id="heading<?php echo $year;?>">
						<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $year;?>" aria-expanded="true" aria-controls="collapse<?php echo $year;?>">
							<?php echo LANG('DATAS_TOP_USERS_'.$year);?>
						</button>
						</h5>
					</div>
					<div id="collapse<?php echo $year;?>" class="collapse <?php echo (($year == date('Y')) ? 'show':'');?>" aria-labelledby="heading<?php echo $year;?>" data-parent="#accordionTopUser">
						<div class="card-body">
							<?php echo $this->bootstrap_tools->render_table(['UserName','NB_TOUR','SUM_TOUR','MOY_TOUR'] , $tours, 'table-striped table-sm', 10);?>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
	var barChartData = {
		labels : ["<?php echo implode('","', $stats['month']);?>"],
		datasets : [
		<?php
		foreach($stats['line'] AS $year=>$datas){
			echo '
			{
				label: \''.$year.'\',
				backgroundColor: "'.$stats['color'][$year].'",
				borderColor: "'.$stats['color'][$year].'",
				borderWidth: 1,
				data : ['.implode(',',$datas).']
			},';
		}
		?>
		],
		options: {
			legend: {
				display: true,
				labels: {
					fontColor: 'rgb(255, 99, 132)'
				}
			}
        }
	};


	/*var config = {
		type: 'line',
		data: {
			labels: [<?php echo implode(',',$BOAT['years']);?>],
			datasets: [{
				label: "<?php echo Lang('BOAT_MINUTES');?>",
				backgroundColor: "#FFFFFF",
				borderColor: "#ff9933",
				data: [
					<?php echo implode(',',$BOAT['datas']);?>
				],
				fill: false,
			}]
		},
		options: {
			responsive: true,
			title: {
				display: true,
				text: "<?php echo Lang('BOAT_MINUTES');?>"
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: "<?php echo Lang('Years');?>"
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: "<?php echo Lang('Hours');?>"
					}
				}]
			}
		}
	};*/

	window.onload = function() {
		var ctx = document.getElementById('canvas_min').getContext('2d');
		window.myBar = new Chart(ctx, {
			type: 'bar',
			data: barChartData,
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Consomation Minutes par Mois'
				}
			}
		});
		
		/*var ctx = document.getElementById('canvas_boat').getContext('2d');
		window.myLine = new Chart(ctx, config);*/

	};	

	
</script>
