<?php
//echo '<pre><code>'.print_r($datas , 1).'</code></pre>';
?>

<div class="container-fluid">
	
	<?php //echo $this->bootstrap_tools->input_select('year', $years , date('Y')); ?>

	<div class="row">
	  <div class="col-md-10"><canvas id="canvas"></canvas></div>
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

	window.onload = function() {
		var ctx = document.getElementById('canvas').getContext('2d');
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
					text: 'Consomation Minutes par Année'
				}
			}
		});

	};	

	
</script>


