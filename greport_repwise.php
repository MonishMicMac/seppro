<?php
	include("include/connect.php");
	session_start();
	error_reporting(E_ALL);
	ini_set('memory_limit', '-1');
	ini_set('upload_max_filesize', '512M');
	ini_set('post_max_size', '512M');
	ini_set('max_input_time', 3000);
	ini_set('max_execution_time', 15000);
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{
	
	
	if(@$_REQUEST["state"]==""){ $_REQUEST["state"] = 1;}
	if(@$_REQUEST["state"]!=""){ $_REQUEST["state"] = $_REQUEST["state"];}
	$cur_date=date("2015-02-02");
	
	
?>
<script language="JavaScript">
function state(state){
		document.location = "home.php?state="+state;
}

</script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="micandmac.in, micandmac, micandmacsolutions, micandmac solutions pvt ltd, micandmac" />
<meta name="keywords" content="micandmacsolutionspvtltd" />
<meta name="author" content="micandmacsolutionspvtltd" /> 
<meta name="keywords" content="micandmacsolutions" />
<meta name="author" content="micandmacsolutions" /> 
<meta name="keywords" content="micandmac.in" />
<meta name="author" content="micandmac.in" /> 

        <!-- The styles -->
        <link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
        <style type="text/css">
        body 
        {
        padding-bottom: 40px;
        }
        .sidebar-nav 
        {
        padding: 9px 0;
        }
        </style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon.ico">
        <!-- The styles Ends-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="chart/js/highcharts.js"></script>
    <script src="chart/js/highcharts-3d.js"></script>	
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="chart/js/jspdf.js"></script>
    <script src="chart/js/rgbcolor.js"></script>
    <script src="chart/js/canvg.js"></script>
</head>

<body>
        <!-- top bar starts -->
	<?php include("include/header.php"); ?>
	<!-- top bar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			   <?php include("include/menu.php"); ?><!--/span-->
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="#" target="_blank">Java Script</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10" style="clear:0 both;float:right;">
            <div class="control-group">			    
                <div class="controls" style="clear:0 both;float:right;">
                <select name="state_id" id="state_id"  onChange="state(this.value);" data-rel="chosen">
                    <option value="">-- Select State --</option>
                <?php $SQL = mysql_query("SELECT * FROM master_state"); while($STATE=mysql_fetch_object($SQL)){ ?>            	
                    <option value="<?php echo $STATE->state_id; ?>"><?php echo $STATE->state_name; ?></option>
                    <?php } ?>
                </select>
                <script>document.getElementById("state_id").value="<?php echo $_REQUEST["state"]; ?>";</script>
                </div>
            </div>
            <div>&nbsp;</div>
			<!-- content starts -->
			<div class="sortable row-fluid">
		<a data-rel="tooltip" title="Total Products" class="well span3 top-block" href="#">
		<?php
		$z=mysql_query("select *  from product where mark_id='$m_id16' AND state_id=".$_REQUEST["state"]."");
		$count_z=mysql_num_rows($z);
		?>
		<div>Total Products</div>
		<div style="color:#FF0000;"><?php echo $count_z; ?></div>
		</a>
<?php
		$z1=mysql_query("select *  from distributor where m_id16='$m_id16' AND state_id=".$_REQUEST["state"]."");
		$count_z1=mysql_num_rows($z1);
		?>

				<a data-rel="tooltip" title="Total Distributors" class="well span3 top-block" href="#">
				<div>Total Distributors</div>
				<div style="color:#FF0000;"><?php echo $count_z1; ?></div>
				</a>

				<a data-rel="tooltip" title="Total Sales of Last  month" class="well span3 top-block" href="#">					
					<div>Total Sales of Last  month</div>
						<div style="color:#FF0000;">
                        	<?php $Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '2015/07/01' AND '2015/07/31') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.state_id=".$_REQUEST["state"]." ");  $Rs_Sales=mysql_fetch_array($Sales); echo "<strong><span style='color:#FF6600'>PTR :</span> <span style='color:#0000FF'>".round($Rs_Sales["TOTPTR"],2)."</span> <span style='color:#FF6600'>PTS :</span> ".round($Rs_Sales["TOTPTS"],2)."</strong>"; ?>
                        </div>
                </a>
<a data-rel="tooltip" title="12 new messages." class="well span3 top-block" href="#"><div>No of Customers</div>
<div style="color:#FF0000;"><?php $cust = mysql_query("SELECT COUNT(shop_name) CSHOPNAME FROM tbl_customer_master where state_id='".$_REQUEST["state"]."'"); $RS_CUST = mysql_fetch_object($cust); $CUSTOMER = mysql_query("SELECT COUNT(DISTINCT(areawise_temp.our_cust_id)) PTRCUST FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '2015/07/01' AND '2015/07/31') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.state_id=".$_REQUEST["state"].""); $PTRCUSTOMER=mysql_fetch_object($CUSTOMER);  echo $PTRCUSTOMER->PTRCUST." / ".$RS_CUST->CSHOPNAME; ?></div></a>
</div>
            
<div id="ref"><?php echo @$page; ?></div>
<div class="box">
<div class="box-content">
	
	
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
	(function(H) {
            H.Chart.prototype.createCanvas = function(divId) {
                var svg = this.getSVG(),
                    width = parseInt(svg.match(/width="([0-9]+)"/)[1]),
                    height = parseInt(svg.match(/height="([0-9]+)"/)[1]),
                    canvas = document.createElement('canvas');

                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);

                if (canvas.getContext && canvas.getContext('2d')) {

                    canvg(canvas, svg);

                    return canvas.toDataURL("image/jpeg");

                } 
                else {
                    alert("Your browser doesn't support this feature, please use a modern browser");
                    return false;
                }

            }
        }(Highcharts));

        $('#export_all').click(function() {
            var doc = new jsPDF();

            // chart height defined here so each chart can be palced
            // in a different position
            var chartHeight = 80;

            // All units are in the set measurement for the document
            // This can be changed to "pt" (points), "mm" (Default), "cm", "in"
            doc.setFontSize(40);
            doc.text(35, 25, "My Exported Charts");
			
			/*var imageData = $('#container_subcat').highcharts().createCanvas();
			doc.addImage(imageData, 'JPEG', 45, (index * chartHeight) + 40, 120, chartHeight);*/
			

            //loop through each chart
           $('.myChart').each(function(index) {
                var imageData = $(this).highcharts().createCanvas();
                doc.addImage(imageData, 'JPEG', 45, (index * chartHeight) + 40, 120, chartHeight);
            });
			

            //save with name
            doc.save('demo.pdf');
        });
    $('#container').highcharts({
        chart: {
            type: 'column',
        },
        title: {
            text: 'Month Wise Sales comparison Chart'
        },
        
        xAxis: {
            categories: [
			<?php
				
				$SQL = mysql_query("SELECT rep_name FROM representative");				
				while($RS=mysql_fetch_object($SQL)){ echo "'"; echo $RS->rep_name; echo "',";}
			?>
		    ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Sale Value'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
			series: {
              cursor: 'pointer',
              point: {
                events: {
                 click: function() {//alert ('Category: '+ this.category +', value: '+ this.y);	
					 draw_cat_chart(this.category);
					 yuvi(this.category);					 
					 $("#REP").load("sample_chart.php");					 				 			 
                 }
				 
                }
              }
           }
        },
		
        series: [{
            name: 'PTR',
            data: [
				<?php					
					
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
						$RS=mysql_fetch_object($SQL);
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id GROUP BY areawise_temp.rep_id ORDER BY areawise_temp.rep_id ");  while($Rs_Sales=mysql_fetch_array($Sales)){ echo round($Rs_Sales["TOTPTR"],2).","; }	
					
				?>			
			]

        }, {
            name: 'PTS',
            data: [
				<?php					
					
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
						$RS=mysql_fetch_object($SQL);
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id GROUP BY areawise_temp.rep_id ORDER BY areawise_temp.rep_id ");  while($Rs_Sales=mysql_fetch_array($Sales)){ echo round($Rs_Sales["TOTPTS"],2).","; }	
					
				?>	
			]

        }]
    });
});
function yuvi(Catagory)
{	
	$.post("pass_value.php?Catagory="+Catagory+"", {Catagory: Catagory}, function(data){});		
}
<?php if(isset($_SESSION["_REP"])){echo $page=$_SESSION["_REP"];} ?>
// Dynamic Function - HIGHCHART - START
function draw_cat_chart(catagory)
{   
      var cats = [
	  	<?php
			for($i=12;$i>=1;$i--){	
			$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
			while($RS=mysql_fetch_object($SQL)){ echo "'"; echo date("M y",strtotime($RS->FirstDay)); echo "',";} }
			?>
	  ];
      var plseries = [
	  	<?php					
					for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id ");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTR"],2).",";
						}	
					}
				?>
	  ];
      var acseries = [
	  	<?php
					for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTS"],2).",";
						}	
					}
				
				?>
	  ];
    
    
 
 
    //exit;
 $('#container_subcat').highcharts({
        chart: {
            type: 'column',
        },
        title: {
            text: 'REPRESENTATIVE INDIVIDUAL REPORT'
        },
        xAxis: {
            categories: cats
        },
        yAxis: { 
            min: 0,
            title: {
                text: '',
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:8px">{point.key}</span><table>',
            pointFormat: '<tr style="border:none;"><td style="color:{series.color};padding:0;border:none;">{series.name}: </td>' +
                '<td style="padding:0;border:none;"><b>{point.y:1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: false,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0,
                borderWidth: 0
            },
        },
        series: [{
                name: 'PTR',
                data: plseries
            }, {
                name: 'PTS',
                data: acseries
            }]
    });
}
function baba(yu){
	window.location.href="greport_repwise.php?rep_id="+yu;
}
function baba1(yu,pri){
	window.location.href="greport_repwise.php?rep_id="+yu+"&rep_sdate="+pri;
}
		</script>


<div id="container" style="width: 980px; height: 300px; margin: 0 auto"></div>
<div>&nbsp;</div><div>&nbsp;</div>
<form name="thisForm" method="post" action="">
<fieldset>
<div class="box-content" style="float:right">
<div class="control-group">
<div class="controls">REPRESENTATIVE REPORT : <span style="color:#FF0000;">*</span>
<select  id="rep_id" name="rep_id" onChange="baba(this.value);" data-rel="chosen">
<option value="">--Select--</option>
<?php
$REP = mysql_query("SELECT id, rep_name FROM representative ORDER BY rep_name");
while($row_res=mysql_fetch_object($REP))
{
?>
<option value="<?php echo $row_res->id; ?>"><?php echo $row_res->rep_name; ?></option>
<?php } ?> 
</select><script>document.thisForm.rep_id.value="<?php echo @$_REQUEST["rep_id"]; ?>";</script></div></div>
</div>
</fieldset>

<?php if(@$_REQUEST["rep_id"]!=""){ $kamal=mysql_fetch_object($REP); ?>
<div id="export_all" style="float:right">EXPORT ALL</div>
<script type="text/javascript">
$(function () {
    $('#container_subcat').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'INDIVIDUAL REPRESENTATIVE REPORT'
        },
        
        xAxis: {
            categories: [
			<?php
			for($i=11;$i>=0;$i--){	
			$SQL = mysql_query("select date_add(LAST_DAY(date_add('2015/07/31',interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add('2015/07/31',interval -$i month)) LastDay");				
			while($RS=mysql_fetch_object($SQL)){ echo "'"; echo date("M y",strtotime($RS->FirstDay)); echo "',";} }
			?>
		    ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Sale Value'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'PTR',
            data: [
				<?php					
					for($i=11;$i>=0;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add('2015/07/31',interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add('2015/07/31',interval -$i month)) LastDay");	
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.rep_id=".$_REQUEST["rep_id"]."");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTR"],2).",";
						}	
					}
				?>			
			]

        }, {
            name: 'PTS',
            data: [
				<?php
					for($i=11;$i>=0;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add('2015/07/31',interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add('2015/07/31',interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.rep_id=".$_REQUEST["rep_id"]."");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTS"],2).",";
						}	
					}
				
				?>
			]

        }]
    });
});
		</script>
<div id="container_subcat" class="myChart" style="min-width: 310px; height: 400px; margin: 0 auto; margin-top:100px;"></div> 


</div></div>

<div class="control-group">
<div class="controls"  style="float:right">REPRESENTATIVE DATE : <span style="color:#FF0000;">*</span>
<select  id="rep_sdate" name="rep_sdate" data-rel="chosen" onChange="baba1(document.thisForm.rep_id.value,this.value);">
<option value="">--Select--</option>            
 <?php					
	for($i=11;$i>=0;$i--){	
		$SQL = mysql_query("select date_add(LAST_DAY(date_add('2015/07/31',interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add('2015/07/31',interval -$i month)) LastDay");
		while($RS=mysql_fetch_object($SQL)){  
			 		
?>
<option value="<?php echo date("Y/m/d",strtotime($RS->FirstDay))."&rep_edate=".date("Y/m/d",strtotime($RS->LastDay)); ?>"><?php echo  date("M y",strtotime($RS->FirstDay)); ?></option>
<?php }} ?> 
</select><?php echo "&nbsp;&nbsp;&nbsp;".date("M y",strtotime($_REQUEST["rep_sdate"])); ?><script>document.thisForm.rep_sdate.value="<?php echo @$_REQUEST["rep_sdate"]; ?>";</script></div></div>	
		
</form>		
<div>&nbsp;</div><div>&nbsp;</div>	
<!--/row-->		
<div class="row-fluid sortable">
<!--/span-->

<div class="box span4">

<div class="box-content">
<div class="box-content">
<ul class="dashboard-list">
	
    <style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#areaa').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
         title: {
            text: 'REP - TOP 10 PRODUCT'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				width:280,
				height:255,
				dataLabels: { style:{ fontSize: '8px', fontWeight: 'normal' }}
			
			}          
				
        },
        series: [{
            name: 'PTS',
            data: [
				<?php				
					$y = mysql_query("SELECT  product.pro_name AS PNAME,SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["rep_sdate"]."' AND '".$_REQUEST["rep_edate"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.rep_id=".$_REQUEST["rep_id"]."  GROUP BY areawise_temp.our_product_id ORDER BY TOTPTR DESC LIMIT 0, 10"); echo mysql_error(); while($r =mysql_fetch_object($y)){ ?>				
				['<?php echo $r->PNAME."-".$r->QTY; ?>', <?php echo round($r->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="areaa" class="myChart" style="width:280px;height: 255px;"></div>
    
</ul>
</div>
</div>
</div>
<!--/span-->





<div class="box span4">

<div class="box-content">
<div class="box-content">
<ul class="dashboard-list">

<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#Area1').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
         title: {
            text: 'REP - TOP 10 AREA'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				dataLabels: { style:{ fontSize: '8px' }}
			
			}          
				
        },
        series: [{
            name: 'PTS',
            data: [
				<?php				
					$product_top = mysql_query("SELECT  areawise_temp.pincode AS PIN, SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["rep_sdate"]."' AND '".$_REQUEST["rep_edate"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id  AND  areawise_temp.rep_id=".$_REQUEST["rep_id"]."  GROUP BY areawise_temp.pincode  ORDER BY TOTPTS DESC LIMIT 0, 10"); $CNT = mysql_num_rows($product_top); while($top_product =mysql_fetch_object($product_top)){ ?>				
				['<?php echo $top_product->PIN."-".$top_product->QTY;  ?>', <?php echo round($top_product->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="Area1" style="width:280px;height: 255px;"></div>
			
</ul>
</div>
</div>
</div><div class="box span4">

<div class="box-content">
<div class="box-content">
<ul class="dashboard-list">

<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#CUSTOMER').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'REP - TOP 10 CUSTOMERS'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				dataLabels: { style:{ fontSize: '8px' }}
			
			}          
				
        },
		
        series: [{
            name: 'PTS',
            data: [
				<?php				
					$product_top = mysql_query("SELECT  tbl_customer_master.shop_name AS CNAME, SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, tbl_customer_master, product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["rep_sdate"]."' AND '".$_REQUEST["rep_edate"]."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.our_cust_id=tbl_customer_master.id  AND  areawise_temp.rep_id=".$_REQUEST["rep_id"]." GROUP BY areawise_temp.our_cust_id  ORDER BY TOTPTS DESC LIMIT 0, 10"); $CNT = mysql_num_rows($product_top); while($top_product =mysql_fetch_object($product_top)){ ?>				
				['<?php echo $top_product->CNAME."-".$top_product->QTY;  ?>', <?php echo round($top_product->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="CUSTOMER" style="width:280px;height:255px;"></div>

			
</ul>
</div>
</div>
</div>




</div>
<?php } ?>
<div class="row-fluid sortable">
<!--/span-->

<div class="box span4">

<div class="box-content">
<div class="box-content">
<ul class="dashboard-list">
	
    <style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#areaaREP').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
         title: {
            text: 'TOP 10 PRODUCT'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				dataLabels: { style:{ fontSize: '8px' }}
			
			}          
				
        },
        series: [{
            name: 'PTS',
            data: [
				<?php				
					$y = mysql_query("SELECT  product.pro_name AS PNAME,SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '2015/07/01' AND '2015/07/31') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.state_id=".$_REQUEST["state"]."  GROUP BY areawise_temp.our_product_id ORDER BY TOTPTR DESC LIMIT 0, 10"); echo mysql_error(); while($r =mysql_fetch_object($y)){ ?>				
				['<?php echo $r->PNAME."-".$r->QTY; ?>', <?php echo round($r->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="areaaREP" style="width:280px;height: 255px;"></div>
    
</ul>
</div>
</div>
</div>
<!--/span-->





<div class="box span4">

<div class="box-content">
<div class="box-content">
<ul class="dashboard-list">

<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#Area1REP').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
         title: {
            text: 'TOP 10 AREA'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				dataLabels: { style:{ fontSize: '8px' }}
			
			}          
				
        },
        series: [{
            name: 'PTS',
            data: [
				<?php				
					$product_top = mysql_query("SELECT  areawise_temp.pincode AS PIN, SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '2015/07/01' AND '2015/07/31') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id  AND areawise_temp.state_id=".$_REQUEST["state"]."  GROUP BY areawise_temp.pincode  ORDER BY TOTPTS DESC LIMIT 0, 10"); $CNT = mysql_num_rows($product_top); while($top_product =mysql_fetch_object($product_top)){ ?>				
				['<?php echo $top_product->PIN."-".$top_product->QTY;  ?>', <?php echo round($top_product->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="Area1REP" style="width:280px;height: 255px;"></div>
			
</ul>
</div>
</div>
</div><div class="box span4">

<div class="box-content">
<div class="box-content">
<ul class="dashboard-list">

<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#CUSTOMERREP').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'TOP 10 CUSTOMERS'
        },        
        plotOptions: {
            pie: {
                innerSize: 45,
                depth: 25,
				dataLabels: { style:{ fontSize: '8px' }}
			
			}          
				
        },
		
        series: [{
            name: 'PTS',
            data: [
				<?php				
					$product_top = mysql_query("SELECT  tbl_customer_master.shop_name AS CNAME, SUM(areawise_temp.our_product_id) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, tbl_customer_master, product WHERE (areawise_temp.bill_date BETWEEN '2015/07/01' AND '2015/07/31') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.our_cust_id=tbl_customer_master.id  AND areawise_temp.state_id=".$_REQUEST["state"]." GROUP BY areawise_temp.our_cust_id  ORDER BY TOTPTS DESC LIMIT 0, 10"); $CNT = mysql_num_rows($product_top); while($top_product =mysql_fetch_object($product_top)){ ?>				
				['<?php echo $top_product->CNAME."-".$top_product->QTY;  ?>', <?php echo round($top_product->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="CUSTOMERREP" style="width:280px;height:255px;"></div>

			
</ul>
</div>
</div>
</div>




</div>
<!--/row-->
				  
		  
       
					<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		<?php include("include/footer.php"); ?>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
    
		
</body>
</html>
<?php
}
?>