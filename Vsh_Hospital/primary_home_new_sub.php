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
	
	if(@$_REQUEST["state"]==""){ $_REQUEST["state"] = 1;}
	if(@$_REQUEST["state"]!=""){ $_REQUEST["state"] = $_REQUEST["state"];}
	$cur_date=date("2015-02-02");	
	
	if(@$_REQUEST["state"]) {
		
		$state_check = "and b.state_id='".(@$_REQUEST["state"])."'";
		$state_check5 = "and state_id='".(@$_REQUEST["state"])."'";
		$state_url = "&state_id=".(@$_REQUEST["state"]);
	} else {
		
		if($_SESSION["state_id"]!="ALL") {
			$state_check = " and b.state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
			$state_check5 = " and state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')";
		} else {
			$state_check = "";
			$state_check5 = "";
		}

		$state_url = "";
	}
	if(@$_REQUEST["division_id"]!=""){
		$division_default = "and a.division_id='".@$_REQUEST["division_id"]."'";
	} else {
		if($_SESSION["division_id"]!="ALL")
			$division_default = " and a.division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')";
		else 
			$division_default = "";
	}
	
	
	$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);


	$Sales10 = mysql_query("SELECT a.bill_string from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id where  a.division_id <> '' AND c.our_id <> '' AND a.bill_string!='' AND c.our_id=d.id ".$state_check." ".$division_default."	 GROUP BY bill_string ORDER BY a.id DESC limit 1");  
	$Rs_Sales10=mysql_fetch_array($Sales10);
	$valuedate=$Rs_Sales10["bill_string"];

	

	
	?>
	<script language="JavaScript">
		function state(state){
			var division=$("#division_id").val();
			if(state=="")
			{

				document.location = "primary_home_new.php?state="+state+"&division_id="+division;
			}
			else
			{
		// alert($("#division_id").val());
		document.location = "primary_home_new_sub.php?state="+state+"&division_id="+division;
	}
}
function division(division){
	var state=$("#state_id").val();
	if(division=="")
	{
		// alert($("#division_id").val());
		document.location = "primary_home_new_sub.php?division_id="+division+"&state="+state;
	}
	else
	{
		// alert($("#division_id").val());
		document.location = "primary_home_new_sub.php?division_id="+division+"&state="+state;
	}
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
	<script src="js/jssor.slider-25.2.0.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		jssor_1_slider_init = function() {

			var jssor_1_SlideshowTransitions = [
			{$Duration:1200,$Opacity:2}
			];

			var jssor_1_options = {
				$AutoPlay: 1,
				$SlideshowOptions: {
					$Class: $JssorSlideshowRunner$,
					$Transitions: jssor_1_SlideshowTransitions,
					$TransitionsOrder: 1
				},
				$ArrowNavigatorOptions: {
					$Class: $JssorArrowNavigator$
				},
				$BulletNavigatorOptions: {
					$Class: $JssorBulletNavigator$
				}
			};

			var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
			var jssor_1_slider = new $JssorSlider$("jssor_2", jssor_1_options);
			/*#region responsive code begin*/
			/*remove responsive code if you don't want the slider scales while window resizing*/
			function ScaleSlider() {
				var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
				if (refSize) {
					refSize = Math.min(refSize, 980);
					jssor_1_slider.$ScaleWidth(refSize);
				}
				else {
					window.setTimeout(ScaleSlider, 30);
				}
			}
			ScaleSlider();
			$Jssor$.$AddEvent(window, "load", ScaleSlider);
			$Jssor$.$AddEvent(window, "resize", ScaleSlider);
			$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
			/*#endregion responsive code end*/
		};
	</script>
	<style>
		/* jssor slider loading skin double-tail-spin css */

		.jssorl-004-double-tail-spin img {
			animation-name: jssorl-004-double-tail-spin;
			animation-duration: 1.2s;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
		}

		@keyframes jssorl-004-double-tail-spin {
			from {
				transform: rotate(0deg);
			}

			to {
				transform: rotate(360deg);
			}
		}


		.jssorb051 .i {position:absolute;cursor:pointer;}
		.jssorb051 .i .b {fill:#555555;fill-opacity:0.5;stroke:#000;stroke-width:400;stroke-miterlimit:10;stroke-opacity:0.5;}
		.jssorb051 .i:hover .b {fill-opacity:.7;}
		.jssorb051 .iav .b {fill-opacity: 1;}
		.jssorb051 .i.idn {opacity:.3;}

		.jssora051 {display:block;position:absolute;cursor:pointer;}
		.jssora051 .a {fill:none;stroke:#555555;stroke-width:360;stroke-miterlimit:10;}
		.jssora051:hover {opacity:.8;}
		.jssora051.jssora051dn {opacity:.5;}
		.jssora051.jssora051ds {opacity:.3;pointer-events:none;}
	</style>	
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
					<!-- <div class="control-group">
						<div class="controls"><input type="text" name="from_date" id="from_date" readonly required/>
						</div>
					</div> -->
					<div class="controls" style="clear:0 both;float:right;">
						<select name="state_id" id="state_id"  onChange="state(this.value);" data-rel="chosen">
							<option value=""><?php echo (($_SESSION["state_id"]=="ALL")?"PAN India":"All") ?></option>
							<?php $SQL = mysql_query("SELECT * FROM master_state".(($_SESSION["state_id"]!="ALL")?(" where state_id in ('".implode("','", explode(",", $_SESSION["state_id"]))."')"):"")." order by state_name"); while($STATE=mysql_fetch_object($SQL)){ ?>              
							<option value="<?php echo $STATE->state_id; ?>"><?php echo $STATE->state_name; ?></option>
							<?php } ?>
						</select>
						<script>document.getElementById("state_id").value="<?php echo $_REQUEST["state"]; ?>";</script>
					</div>
					<div class="controls" style="clear:0 both;float:right;">
						<select name="division_id" id="division_id" onChange="division(this.value);" data-rel="chosen" >
							<option value="">---Select---</option>
							<?php $P=mysql_query("SELECT * FROM mst_division".(($_SESSION["division_id"]!="ALL")?(" where division_id in ('".implode("','", explode(",", $_SESSION["division_id"]))."')"):"")." ORDER BY division_id"); while($I=mysql_fetch_object($P)){ ?>
							<option value="<?=$I->division_id; ?>"><?=$I->division_name; ?></option>
							<?php } ?>
						</select><script>document.getElementById("division_id").value="<?=@$_REQUEST["division_id"] ?>";</script>
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
					$z1=mysql_query("select *  from distributor where m_id16='$m_id16' ".$state_check5."");
					$count_z1=mysql_num_rows($z1);
					?>

					<a data-rel="tooltip" title="Total Distributors" class="well span4 top-block" href="#">
						<div>Total Distributors</div>
						<div style="color:#FF0000;"><?php echo $count_z1; ?></div>
					</a>

					<a data-rel="tooltip" title="Closing Value for Last Month" class="well span4 top-block" href="#">					
						<div>Closing Value for Last Month</div>
						<div style="color:#FF0000;">
							<?php


                    if(@$_REQUEST["from_date"]!=""){
                        $bill_default = "and a.bill_string='".$_REQUEST["from_date"]."'";
                        $bill_url = "&from_date=".$_REQUEST["from_date"];
                         echo ":";

                    } else {
                        $SQL = mysql_query("SELECT bill_string FROM `primary_sales` order by str_to_date(concat(\"01\",LEFT(SUBSTRING_INDEX( SUBSTRING_INDEX( bill_string,  ' ', 1 ) ,  ' ', -1 ),3),TRIM( SUBSTR(  bill_string, LOCATE(  ' ',  bill_string ) ) )),\"%d%b%Y\") desc limit 1");
                        while ($customer21=mysql_fetch_array($SQL)) {
                            $bill_default1=$customer21["bill_string"];
                            $bill_default="and a.bill_string='".$customer21["bill_string"]."'";
                            $bill_url="&from_date=".$customer21["bill_string"];
                        }
                        echo " for ".$bill_default1." :";
                    }


                        $a=mysql_query("select FORMAT(sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts),2) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where 1 ".$bill_default." ".$state_check." ".$division_default."  AND c.our_id!=''" )or die(mysql_error());



							 
                        if(mysql_num_rows($a)){
                          while($csvalue=mysql_fetch_array($a)) {
                            echo (@($csvalue["closing_stock"])?$csvalue["closing_stock"]:'0');

                          }
                        } else {
                          echo '0';
                        }
							?>
						</div>
					</a>
<!-- <a data-rel="tooltip" title="12 new messages." class="well span3 top-block" href="#"><div>No of Customers</div>
	<div style="color:#FF0000;"><?php $cust = mysql_query("SELECT COUNT(shop_name) CSHOPNAME FROM tbl_customer_master where state_id='".$_REQUEST["state"]."'"); $RS_CUST = mysql_fetch_object($cust); $CUSTOMER = mysql_query("SELECT COUNT(DISTINCT(areawise_temp.our_cust_id)) PTRCUST FROM areawise_temp WHERE areawise_temp.bill_string='".$valuedate."' AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.state_id=".$_REQUEST["state"].""); $PTRCUSTOMER=mysql_fetch_object($CUSTOMER);  echo $PTRCUSTOMER->PTRCUST." / ".$RS_CUST->CSHOPNAME; ?></div></a> -->
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
							name: 'OP',
							data: [
							<?php					
							for($i=12;$i>=1;$i--){	
								$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
								while($RS=mysql_fetch_object($SQL)){						
									$Sales = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free)*f.pts) as opening_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." ");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["opening_stock"],2).",";
								}	
							}
							?>			
							]

						}, {
							name: 'PVR',
							data: [
							<?php
							for($i=12;$i>=1;$i--){	
								$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
								while($RS=mysql_fetch_object($SQL)){
									$Sales = mysql_query("SELECT sum((a.purchase+a.purchase_free-a.purchase_return)*f.pts) as purchase from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." ");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["purchase"],2).",";
								}	
							}

							?>
							]

						},{
							name: 'SLS',
							data: [
							<?php
							for($i=12;$i>=1;$i--){	
								$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
								while($RS=mysql_fetch_object($SQL)){
									$Sales = mysql_query("SELECT sum((a.sale+a.sale_free-a.sale_return-(a.sale_replacement)-(a.damage)-(a.adjustment))*f.pts) as sale from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." ");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["sale"],2).",";
								}	
							}

							?>
							]

						},{
							name: 'CL',
							data: [
							<?php
							for($i=12;$i>=1;$i--){	
								$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");
								while($RS=mysql_fetch_object($SQL)){
									$Sales = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".date("F Y",strtotime($RS->FirstDay))."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." ");  $Rs_Sales=mysql_fetch_array($Sales); echo round($Rs_Sales["closing_stock"],2).",";
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






<div class="box-content">
	<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
		<div data-u="loading" class="jssorl-004-double-tail-spin" style="position:absolute;top:0px;left:0px;text-align:center;background-color:rgba(0,0,0,0.7);">
			<img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/double-tail-spin.svg" />
		</div>
		<div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">	
			<?php 
			$i=1;
			$SQL = mysql_query("SELECT g.state_name,g.state_id FROM  primary_sales a left join distributor b on a.distributor_id=b.dis_id  left join master_state g on b.state_id=g.state_id WHERE 1 ".$state_check." ".$division_default." GROUP BY b.state_id");				
			while($RS=mysql_fetch_object($SQL)){ 
				$stst=$RS->state_id;

				if ($i==1) { 
					echo '<div class="row-fluid sortable">';
					echo '<center>';
				}
				?>
				<div class="box span6">
					<div class="box-content">
						<ul class="dashboard-list">
							<div id="areaa<?php echo $i; ?>" name="areaa[]" class="areaa" style="width:280px;height: 255px;"></div>
						</ul>
					</div>
				</div>
				<?php 
				if($i%2==0){
					echo "</center>";
					echo "</div>";

					echo '<div class="row-fluid sortable">';
					echo '<center>';
				}
				?>
				<?php
				$i++;
			}

			
			echo "</center>";
			echo "</div>";
			
			?>
		</div>
		<!-- Bullet Navigator -->
		<!-- <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
			<div data-u="prototype" class="i" style="width:16px;height:16px;">
				<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
					<circle class="b" cx="8000" cy="8000" r="5800"></circle>
				</svg>
			</div>
		</div> -->
		<!-- Arrow Navigator -->
		<div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
			<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
			</svg>
		</div>
		<div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
			<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
			</svg>
		</div>
	</div>
</div>
<!--/row-->










<?php 
$i=1;
$SQL = mysql_query("SELECT g.state_name,g.state_id FROM  primary_sales a left join distributor b on a.distributor_id=b.dis_id  left join master_state g on b.state_id=g.state_id WHERE 1 ".$state_check." ".$division_default." GROUP BY b.state_id");				
while($RS=mysql_fetch_object($SQL)){ 
	$stst=$RS->state_id;
	?>
	<script type="text/javascript">
		$(function () {
			$('#areaa<?php echo $i; ?>').highcharts({
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45
					}
				},
				title: {
					text: '<?php echo $RS->state_name; ?> TOP 10 DISTRIBOTORS'
				},        
				plotOptions: {
					pie: {
						innerSize: 45,
						depth: 25,
						dataLabels: { style:{ fontSize: '8px' }}

					}          
				},
				series: [{
					name: 'CL',
					data: [
					<?php	
					$y = mysql_query("select  g.state_name,b.dis_name,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id left join master_state g on f.state_id=g.state_id where   a.division_id <> '' AND c.our_id <> '' AND b.state_id=".$stst." ".$division_default." GROUP BY a.distributor_id ORDER BY closing_stock DESC LIMIT 0, 10"); echo mysql_error(); while($r =mysql_fetch_object($y))
					{
						?>				
						['<?php echo $r->dis_name; ?>', <?php echo round($r->closing_stock,2); ?>],
						<?php 
					}
					?>
					]
				}]
			});
		});
	</script>

	<?php
	$i++;
}
?>



<div class="box-content">
	<div id="jssor_2" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
		<div data-u="loading" class="jssorl-004-double-tail-spin" style="position:absolute;top:0px;left:0px;text-align:center;background-color:rgba(0,0,0,0.7);">
			<img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/double-tail-spin.svg" />
		</div>
		<div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">	
			<?php 
			$i=1;
			$SQL = mysql_query("SELECT d.id,d.pro_name FROM  primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id WHERE 1 ".$state_check." ".$division_default." AND c.our_id!='' GROUP BY c.our_id");				
			while($RS=mysql_fetch_object($SQL)){ 
				$stst=$RS->pro_name;

				if ($i==1) { 
					echo '<div class="row-fluid sortable">';
					echo '<center>';
				}
				?>
				<div class="box span6">
					<div class="box-content">
						<ul class="dashboard-list">
							<div id="areaapro<?php echo $i; ?>" name="areaa[]" class="areaa" style="width:280px;height: 255px;"></div>
						</ul>
					</div>
				</div>
				<?php 
				if($i%2==0){
					echo "</center>";
					echo "</div>";

					echo '<div class="row-fluid sortable">';
					echo '<center>';
				}
				?>
				<?php
				$i++;
			}

			echo "</center>";
			echo "</div>";

			?>
		</div>
		<!-- Bullet Navigator -->
		<!-- <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
			<div data-u="prototype" class="i" style="width:16px;height:16px;">
				<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
					<circle class="b" cx="8000" cy="8000" r="5800"></circle>
				</svg>
			</div>
		</div> -->
		<!-- Arrow Navigator -->
		<div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
			<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
			</svg>
		</div>
		<div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
			<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
				<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
			</svg>
		</div>
	</div>
</div>
<!--/row-->










<?php 
$i=1;
$SQL5 = mysql_query("SELECT d.id,d.pro_name FROM  primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id WHERE 1 ".$state_check." ".$division_default." AND c.our_id!='' GROUP BY c.our_id")or die(mysql_error());				
while($RS5=mysql_fetch_array($SQL5)){ 
	$stst5=$RS5["pro_name"];
	?>
	<script type="text/javascript">
		$(function () {
			$('#areaapro<?php echo $i; ?>').highcharts({
				chart: {
					type: 'pie',
					options3d: {
						enabled: true,
						alpha: 45
					}
				},
				title: {
					text: '<?php echo $RS5["pro_name"]; ?> TOP 10 PRODUCTS'
				},        
				plotOptions: {
					pie: {
						innerSize: 45,
						depth: 25,
						dataLabels: { style:{ fontSize: '8px' }}

					}          
				},
				series: [{
					name: 'CL',
					data: [
					<?php	

					$y5 = mysql_query("select  g.state_name,b.dis_name,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as closing_stock from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id left join master_state g on f.state_id=g.state_id where   a.division_id <> '' AND c.our_id <> '' AND c.our_id=".$RS5["id"]." ".$division_default." GROUP BY b.state_id ORDER BY closing_stock DESC LIMIT 0, 10")or die(mysql_error()); while($r5 =mysql_fetch_array($y5))
					{
						?>				
						['<?php echo $r5["state_name"]; ?>', <?php echo round($r5["closing_stock"],2); ?>],
						<?php 
					}

					?>
					]
				}]
			});
		});
	</script>

	<?php
	$i++;
}
?>
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
						text: 'PRODUCT VALUE COMPARSION REPORT'
					},
					xAxis: {
						categories: [
						<?php 
						$PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as QTY,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string IN ('".date("F Y",strtotime($newdate))."','".date("F Y",strtotime($date))."') AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." GROUP BY c.our_id ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo "'".$RS_PRODUCT->PNAME."',";} ?>
						]
					},
					yAxis: [{
						min: 0,
						title: {
							text: 'CL'
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
						name: '<?php echo $newdate ?> V',
						color: 'rgba(165,170,217,1)',
						data: [<?php 
						$PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as QTY,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".$newdate."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." GROUP BY c.our_id ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo round($RS_PRODUCT->QTY,2).",";}
						?>
						],
						pointPadding: 0.4,
						pointPlacement: -0.4
					},{
						name: '<?php echo $newdate ?> Q',
						color: 'rgb(164, 247, 235)',
						data: [<?php 
						$PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as QTY,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".$newdate."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." GROUP BY c.our_id ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo $RS_PRODUCT->closeqty.",";}
						?>
						],
					}, {
						name: '<?php echo $date ?> V',
						color: 'rgba(234, 16, 97, 0.9)',
						data: [<?php 
						$PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as QTY,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".$date."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." GROUP BY c.our_id ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo round($RS_PRODUCT->QTY,2).",";} ?>], 
						pointPadding: 0.4,
						pointPlacement: -0.2
					},{
						name: '<?php echo $date ?> Q',
						color: 'rgba(234, 177, 16, 0.9)',
						data: [<?php 
						$PRODUCT = mysql_query("SELECT sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)*f.pts) as QTY,sum((a.opening_stock+a.opening_stock_free+a.purchase+a.purchase_free-a.purchase_return-a.sale-a.sale_free+a.sale_return+a.sale_replacement+a.damage+a.adjustment)) as closeqty,d.pro_name AS PNAME from primary_sales a left join distributor b on a.distributor_id=b.dis_id left join dist_prod c on a.distributor_product_id=c.id left join product d on d.id=c.our_id left join (select batch_id, batch, product_id from mst_batchdetails group by product_id order by batch_id desc) e on d.id=e.product_id left join tbl_statewise_product_price f on e.batch=f.batch_id and f.state_id=b.state_id where  a.bill_string='".$date."' AND a.division_id <> '' AND c.our_id <> ''  ".$state_check." ".$division_default." GROUP BY c.our_id ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo $RS_PRODUCT->closeqty.",";} ?>], 

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
	<script type="text/javascript">jssor_1_slider_init();</script>
	
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<script>
		$(function() {
			$('#from_date').datepicker({
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'MM yy',
				yearRange: '1980:' + new Date().getFullYear(),
				beforeShow: function(el, dp) { 
					$('#ui-datepicker-div').addClass('hide-calendar');
				},
				onClose: function(dateText, inst) { 
					$('#ui-datepicker-div').removeClass('hide-calendar');
					var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
					var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
					$(this).datepicker('setDate', new Date(year, month, 1));
				}
			});
		});
	</script>
	<style>
		.ui-datepicker-calendar {
			display: none;
		}
	</style>



</body>
</html>
<?php
}
?>