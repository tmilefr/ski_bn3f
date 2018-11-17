<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
body {
	margin: 0;
	padding: 0;
	font-family: Arial, Verdana, Geneva, Sans-serif;
	font-size: 14px;
	color: #4F5155;
}

@page { margin: 90px 10px 0px 20px; }

#header { position: fixed; left: 0px; top: -80px; right: 0px; height: 50px; text-align: center; }
#footer { position: fixed; left: 0px; bottom: 0px; right: 0px; height: 60px; text-align: center;  }
#footer .page:after { content: counter(page, upper-roman); }
#content {text-align:left; padding-bottom:40px; }


table{
	width:100%;
	background-color:#FFF;
	margin: auto;
}

table td{
	padding: 1px;
}

.souligne{
	border-top: 0.5px solid #000000;
}

.sep_dashed{
	border-top: 1px dotted #000000;
	padding-top:5px;
}

.text-right{
	text-align:	right;
}


table th {
	font-weight: bold;
	font-size: 10px;
	background-color: #666;
	color: #fff;
	padding: 0px 2px 0px 2px;
	white-space:nowrap;
	vertical-align: top;
}

h2{
	color: #444;
	font-size: 18px;
	margin:0;
	padding:0;
}


h3{
	color: #444;
	font-size: 14px;
	margin:0;
	padding:0;
}

h4{
	color: #444;
	font-size: 12px;
	margin:0;
	padding:0;
}

p{
	font-size: 11px;
	margin:0;
	padding:0;
}

#footer {

}

#footer p{
	font-size:10px;
}


.pair{
	background-color:#F4FAFF;
	color:#515252;
}

.red{
	color:#E0212F;
}
.blue{
	color:#72B1D7;
}
.violet{
	color:#AF5C91;
}

.underline{
	text-decoration:underline;
}

.nowrap{
	white-space:nowrap;
}
</style>
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
				<?php echo $this->render_object->RenderElement('month', $invoice->month).' / '.$invoice->year.' : '. $invoice->sum.' €';?>
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
		
		<?php
		foreach($part->days AS $month=>$days){
			echo '<h3>'.$this->render_object->RenderElement('month',$month).'</h3>';
			echo '<table>';
			foreach($days AS $key=>$day){
				echo '<tr class="'.((is_float($key/2)) ? 'pair':'').'"><td style="width: 25%">'.GetFormatDate($day->date).'</td><td style="width: 25%">'.$day->rate.'</td><td style="width: 50%" class="text-right">'.$day->duration.' '.Lang('min').'</td></tr>';
			}
			echo '</table>';
		}
		?>
		</table>
		<br/><br/>
		<table>
		<?php 	
		$total = 0;
		foreach($part->footer AS $footer){
			echo '<tr><td style="width: 25 %">&nbsp;</td><td style="width: 25%">'.$footer->rate.'</td><td style="width: 25%" class="text-right">'.$footer->duration.' '.Lang('min').'</td><td style="width: 25%" class="text-right">'.$footer->cost.' &euro;</td></tr>';
			$total += $footer->cost;
		}
		echo '<tr><td class="sep_dashed" colspan="3">&nbsp;</td><td class="sep_dashed text-right">'.$total.' &euro;</td></tr>';
		?>	
		</table>
<?php } ?>
</div>
</body>
</html>

