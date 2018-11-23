<div class="container-fluid">
	<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('name').' '.$this->render_object->RenderElement('surname');?> / <?php echo $this->render_object->RenderElement('family');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('email'); 
			?>
		</h5>
		<p class="card-text">
			<?php 
				echo $this->render_object->label('section').' : '.$this->render_object->RenderElement('section').'<br/>'; 
				echo $this->render_object->RenderElement('country') ; 		
			?>				
		</p>		
		<?php
			echo $this->render_object->render_element_menu();
		?>
			
		<div class="row">
			<div class="col-sm">
				<canvas id="canvas_min"></canvas>
			</div>	
			<div class="col-sm">
				
			</div>
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
	};	

	
</script>
