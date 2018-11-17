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
			<tr><td>
				<h2>Facturation Minutes SKI BN3F : </h2>
			</td><td class=" text-right">
				<h3><?php echo Lang('RECAP').' '.$this->render_object->RenderElement('month', $month).' / '.$year;?></h3>
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
	<table class="table table-striped table-sm">
	  <thead>
		<tr>			
			<th scope="col"><?php echo Lang('family');?></th>
			<th scope="col" class="text-right"><?php echo Lang('sum');?></th>
		  </tr>
	  </thead>
	  <tbody>
	<?php 
	$sum = 0;
	foreach($datas AS $key=>$invoice){
		echo '<tr><td>'.$invoice->header.'</td><td class="text-right">'.$invoice->sum.'</td></tr>';
		$sum += $invoice->sum;
	}
	echo '<tr><td>'.Lang('total').'</td><td class="text-right">'.$sum.'</td></tr>';
	?>
	</tbody>
	</table>
</div>
