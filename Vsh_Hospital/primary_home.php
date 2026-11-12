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
	if($_SESSION["STATUS"]==1){ header("location:fep_dashboard.php"); }
	if($_SESSION["STATUS"]==3){ header("location:rep_tracking_new.php"); }
	
	if(@$_REQUEST["state"]!=""){ 

		$state_select = "AND b.state_id=".$_REQUEST["state"];

	} else {
		$state_select = "";
	}
	// if(@$_REQUEST["state"]!=""){ $_REQUEST["state"] = $_REQUEST["state"];}
	$cur_date=date("2015-02-02");	
	
	
	
	$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);


	$Sales10 = mysql_query("SELECT a.bill_string from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.division_id <> '' AND c.our_id <> '' AND a.bill_string!='' AND c.our_id=d.id  GROUP BY bill_string ORDER BY a.id DESC limit 1");  
	$Rs_Sales10=mysql_fetch_array($Sales10);
	 $valuedate=$Rs_Sales10["bill_string"];

	
		
	
?>

<script language="JavaScript">
function state(state){
		document.location = "primary_home.php?state="+state;
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
                    <option value="">PAN India</option>
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
		<a data-rel="tooltip" title="Total Products" class="well span4 top-block" href="#">
		<?php
		$z=mysql_query("select *  from product");
		$count_z=mysql_num_rows($z);
		?>
		<div>Total Products</div>
		<div style="color:#FF0000;"><?php echo $count_z; ?></div>
		</a>
<?php
		$z1=mysql_query("select *  from distributor b where b.m_id16='$m_id16' ".$state_select);
		$count_z1=mysql_num_rows($z1);
		?>

				<a data-rel="tooltip" title="Total Distributors" class="well span4 top-block" href="#">
				<div>Total Distributors</div>
				<div style="color:#FF0000;"><?php echo $count_z1; ?></div>
				</a>

				<a data-rel="tooltip" title="Total Sales of Last  month" class="well span4 top-block" href="#">					
					<div>Total Sales of Last  month</div>
						<div style="color:#FF0000;">
                        	<?php $Sales = mysql_query("SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".$valuedate."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select);  $Rs_Sales=mysql_fetch_array($Sales);
                        	 echo "<strong><span style='color:#FF6600'>PTR :</span> <span style='color:#0000FF'>".round($Rs_Sales["TOTPTR"],2)."</span> <span style='color:#FF6600'>PTS :</span> ".round($Rs_Sales["TOTPTS"],2)."</strong>"; ?>
                        </div>
                </a>
<!-- <a data-rel="tooltip" title="12 new messages." class="well span3 top-block" href="#"><div>No of Customers</div>
<div style="color:#FF0000;"><?php// $cust = mysql_query("SELECT COUNT(b.shop_name) CSHOPNAME FROM tbl_customer_master b where 1 ".); $RS_CUST = mysql_fetch_object($cust); $CUSTOMER = mysql_query("SELECT COUNT(DISTINCT(areawise_temp.our_cust_id)) PTRCUST FROM areawise_temp b WHERE b.bill_string='".$valuedate."' AND b.our_cust_id <> '' AND b.our_product_id <> '' ".$state_select); $PTRCUSTOMER=mysql_fetch_object($CUSTOMER);  echo $PTRCUSTOMER->PTRCUST." / ".$RS_CUST->CSHOPNAME; ?></div></a> -->
</div>
<?php 


	// for($i=12;$i>=1;$i--){	
	// 			$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
	// 			while($RS=mysql_fetch_object($SQL)){ echo "'"; echo date("F y",strtotime($RS->FirstDay)); echo "',";} }
	// 			for($i=12;$i>=1;$i--){	
	// 					$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
	// 					while($RS=mysql_fetch_object($SQL)){
	// 					echo "SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id AND b.state_id=".$_REQUEST["state"]." ";						
	// 						// $Sales = mysql_query("SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id AND b.state_id=".$_REQUEST["state"]." ");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTR"],2).",";
	// 					}	
	// 				}


				?>
            
           
<div class="box">
<div class="box-content">
	
	
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Month Wise Sales comparison Chart'
        },
        
        xAxis: {
            categories: [
			<?php
				for($i=12;$i>=1;$i--){	
				$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
				while($RS=mysql_fetch_object($SQL)){ echo "'"; echo date("F y",strtotime($RS->FirstDay)); echo "',";} }
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
					for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){						
							$Sales = mysql_query("SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select);  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTR"],2).",";
						}	
					}
				?>			
			]

        }, {
            name: 'PTS',
            data: [
				<?php
					for($i=12;$i>=1;$i--){	
						$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
						while($RS=mysql_fetch_object($SQL)){
							$Sales = mysql_query("SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select);  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["TOTPTS"],2).",";
						}	
					}
				
				?>
			]

        }]
    });
});
		</script>

<div id="container" style="width: 950px; height: 300px; margin: 0 auto"></div>
   
</div></div>
            
            
			
			
<!--/row-->		
<div class="row-fluid sortable">
<!--/span-->
<center>
<div class="box span6">

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
					$y = mysql_query("SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".$valuedate."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select." GROUP BY c.our_id ORDER BY TOTPTR DESC LIMIT 0, 10"); echo mysql_error(); while($r =mysql_fetch_object($y)){ ?>				
				['<?php echo $r->PNAME; ?>', <?php echo round($r->TOTPTS,2); ?>],
				 <?php } ?>
				           				
            ]
        }]
    });
});
		</script>


<div id="areaa" style="width:280px;height: 255px;"></div>
    
</ul>
</div>
</div>
</div>
</center>
<!--/span-->





<div class="box span6">
<center>
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
            text: 'TOP 10 DISTRIBUTORS'
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
					$product_top = mysql_query("SELECT sum(d.pts) AS TOTPTS,sum(d.ptr) AS TOTPTR,b.dis_name AS DNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".$valuedate."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select." GROUP BY a.distributor_id ORDER BY TOTPTR DESC LIMIT 0, 10"); $CNT = mysql_num_rows($product_top); while($top_product =mysql_fetch_object($product_top)){ ?>				
				['<?php echo $top_product->DNAME;  ?>', <?php echo round($top_product->TOTPTS,2); ?>],
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
</center>
</div>





</div>
<!--/row-->
				  

	<?php
	// LAST 2 MONTHS
	$MDATE1 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE1=mysql_fetch_object($MDATE1);
	
	//LAST 1 MONTH
	$MDATE2 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -2 month)) LastDay");
	$R_MDATE2=mysql_fetch_object($MDATE2);
	
	 $date = $valuedate;
$newdate = strtotime ( '-1 month' , strtotime ( $date ) ) ;
 $newdate = date ( 'F Y' , $newdate );
	?>	  
<div class="box">
<div class="box-content">
	
	<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#product_pts').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'PRODUCT QTY COMPARSION REPORT'
        },
        xAxis: {
            categories: [
			<?php 
			 $PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.pts) as QTY,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  (a.bill_string BETWEEN '".date("M Y",strtotime($date))."' AND '".date("M Y",strtotime($newdate))."') AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select." GROUP BY c.our_id ORDER BY QTY ASC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo "'".$RS_PRODUCT->PNAME."',";} ?>
            ]
        },
        yAxis: [{
            min: 0,
            title: {
                text: 'PTS'
            }
        }, {
            title: {
                text: ''
            },
            opposite: false
        }],
        legend: {
            shadow: false
        },
        tooltip: {
            shared: true
        },
        plotOptions: {
            column: {
                grouping: false,
                shadow: false,
                borderWidth: 0
            }
        },
        series: [{
            name: '<?php echo $newdate ?>',
            color: 'rgba(165,170,217,1)',
            data: [<?php 
             $PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.pts) as QTY,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".$newdate."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select." GROUP BY c.our_id ORDER BY QTY ASC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo  $RS_PRODUCT->QTY.",";} ?>
			],
            pointPadding: 0.3,
            pointPlacement: -0.2
        }, {
            name: '<?php echo $date ?>',
            color: 'rgba(126,86,134,.9)',
            data: [<?php 
            $PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*d.pts) as QTY,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.bill_string='".$date."' AND a.division_id <> '' AND c.our_id <> '' AND c.our_id=d.id ".$state_select." GROUP BY c.our_id ORDER BY QTY ASC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo $RS_PRODUCT->QTY.",";} ?>],
            pointPadding: 0.4,
            pointPlacement: -0.2
        }]
    });
});
		</script>

<div id="product_pts" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
   
</div></div>       
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