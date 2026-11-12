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
	$cur_date=date("m-d-Y");	
	
	$MDATE = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);

		
	
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
        .side-chart {	
		font-size:14px;
		text-align: center;
		padding: 5px;
		margin-bottom:10px;
		font-weight:bold;
		position: relative;
		display: block;
		line-height: 22px;
		text-shadow: 0 0 1px #DDD;
		text-decoration:none;
		-webkit-box-shadow: inset 0 0 0 1px #FFFFFF;
		-moz-box-shadow: inset 0 0 0 1px #FFFFFF;
		box-shadow: inset 0 0 0 1px #FFFFFF;
		background: -moz-linear-gradient(top,  rgba(30,87,153,0.2) 0%, rgba(255, 255, 255, 255) 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255, 255, 255, 255)), color-stop(100%,rgba(255, 255, 255, 255)));
		background: -webkit-linear-gradient(top,  rgba(255, 255, 255, 255) 0%,rgba(255, 255, 255, 255) 100%);
		background: -o-linear-gradient(top,  rgba(255, 255, 255, 255) 0%,rgba(255, 255, 255, 255) 100%);
		background: -ms-linear-gradient(top,  rgba(255, 255, 255, 255) 0%,rgba(255, 255, 255, 255) 100%);
		background: linear-gradient(to bottom,  rgba(255, 255, 255, 255) 0%,rgba(255, 255, 255, 255) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#FFFFFF', endColorstr='#FFFFFF',GradientType=0 );
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
	<script type="text/javascript" src="js/jquery.min.js"></script>
    
    <script src="chart/js/highcharts-3d.js"></script>	
    <script src="chart/js/highcharts.js"></script>
<script src="chart/js/modules/data.js"></script>
<script src="chart/js/modules/drilldown.js"></script>


<script type="text/javascript" src="js/jssor.slider.mini.js"></script>
<style>
		.jssorb05 {
            position: absolute;
        }
        .jssora12l, .jssora12r {
            display: block;
            position: absolute;
            width: 30px;
            height: 46px;
            cursor: pointer;
            background: url('img/slider/a04.png') no-repeat;
            overflow: hidden;
        }
        .jssora12l { background-position: -256px -37px; }
        .jssora12r { background-position: -315px -37px; }
        .jssora12l:hover { background-position: -256px -37px; }
        .jssora12r:hover { background-position: -315px -37px; }
        .jssora12l.jssora12ldn { background-position: -256px -37px; }
        .jssora12r.jssora12rdn { background-position: -315px -37px; }
        a.products{ color: yellow; }
        a.products:hover{ color: white; }
        a.total_products_list{ color: yellow; }
        a.total_products_list:hover{ color: white; }
        a.customers{ color: yellow; }
        a.customers:hover{ color: white; }
        a.total_customers{ color: yellow; }
        a.total_customers:hover{ color: white; }
</style>
<script>
		jQuery(document).ready(function ($) {
            
            var jssor_html5_AdWords_SlideoTransitions = [
              [{b:-1,d:1,o:-1,rY:-120},{b:2600,d:500,o:1,rY:120,e:{rY:17}}],
              [{b:-1,d:1,o:-1},{b:1480,d:20,o:1},{b:1500,d:500,y:-20,e:{y:19}},{b:2300,d:300,x:-20,e:{x:19}},{b:3100,d:300,o:-1,sY:9}],
              [{b:-1,d:1,o:-1},{b:2300,d:300,x:20,o:1,e:{x:19}},{b:3100,d:300,o:-1,sY:9}],
              [{b:-1,d:1,sX:-1,sY:-1},{b:0,d:1000,sX:2,sY:2,e:{sX:7,sY:7}},{b:1000,d:500,sX:-1,sY:-1,e:{sX:16,sY:16}},{b:1500,d:500,y:20,e:{y:19}}],
              [{b:1000,d:1000,r:-30},{b:2000,d:500,r:30,e:{r:2}},{b:2500,d:500,r:-30,e:{r:3}},{b:3000,d:3000,x:70,y:40,rY:-20,tZ:-20}],
              [{b:-1,d:1,o:-1},{b:0,d:1000,o:1}],
              [{b:-1,d:1,o:-1,r:30},{b:1000,d:1000,o:1}],
              [{b:-1,d:1,o:-1},{b:2780,d:20,o:1},{b:2800,d:500,y:-70,e:{y:3}},{b:3300,d:1000,y:180},{b:4300,d:500,y:-40,e:{y:3}},{b:5300,d:500,y:-40,e:{y:3}},{b:6300,d:500,y:-40,e:{y:3}},{b:7300,d:500,y:-40,e:{y:3}},{b:8300,d:400,y:-30}],
              [{b:-1,d:1,c:{y:200}},{b:4300,d:4400,c:{y:-200},e:{c:{y:1}}}],
              [{b:-1,d:1,o:-1},{b:4300,d:20,o:1}],
              [{b:-1,d:1,o:-1},{b:5300,d:20,o:1}],
              [{b:-1,d:1,o:-1},{b:6300,d:20,o:1}],
              [{b:-1,d:1,o:-1},{b:7300,d:20,o:1}],
              [{b:-1,d:1,o:-1},{b:8300,d:20,o:1}],
              [{b:2000,d:1000,o:-0.5,r:180,sX:4,sY:4,e:{r:5,sX:5,sY:5}},{b:3000,d:1000,o:-0.5,r:180,sX:-4,sY:-4,e:{r:6,sX:6,sY:6}}],
              [{b:-1,d:1,o:-1,c:{m:-35.0}},{b:0,d:1500,x:150,o:1,e:{x:6}}],
              [{b:-1,d:1,o:-1,c:{y:35.0}},{b:0,d:1500,x:-150,o:1,e:{x:6}}],
              [{b:-1,d:1,o:-1},{b:6500,d:2000,o:1}],
              [{b:-1,d:1,o:-1},{b:2000,d:1000,o:0.5,r:180,sX:4,sY:4,e:{r:5,sX:5,sY:5}},{b:3000,d:1000,o:0.5,r:180,sX:-4,sY:-4,e:{r:6,sX:6,sY:6}},{b:4500,d:1500,x:-45,y:60,e:{x:12,y:3}}],
              [{b:-1,d:1,o:-1},{b:4500,d:1500,o:1,e:{o:5}},{b:6500,d:2000,o:-1,r:10,rX:30,rY:20,e:{rY:6}}]
            ];
            
            var jssor_html5_AdWords_options = {
              $AutoPlay: false,
              $Idle: 1600,
              $SlideDuration: 400,
              $SlideEasing: $Jease$.$InOutSine,
              $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_html5_AdWords_SlideoTransitions
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $ChanceToShow: 1
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $ActionMode: 2
              }
            };
            
            var jssor_html5_AdWords_slider = new $JssorSlider$("jssor_html5_AdWords", jssor_html5_AdWords_options);
        });
</script>

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
            
            <div>&nbsp;</div>
			<!-- content starts -->
			<div class="sortable row-fluid">
		<a data-rel="tooltip" title="Total Products" class="well span3 top-block" href="#">
		<?php
		$rep_name_sql=mysql_query("select rep_name from representative where id='".$_SESSION['id']."'");
    	$rep_name_row=mysql_fetch_array($rep_name_sql);
    	echo "select *  from product where mark_id='$m_id16'";
		$z=mysql_query("select *  from product where mark_id='$m_id16'");
		$count_z=mysql_num_rows($z);
		?>
		<div>Total Products</div>
		<div style="color:#FF0000;"><?php echo $count_z; ?></div>
		</a>
		<?php
		$z1=mysql_query("select *  from distributor where m_id16='$m_id16'");
		$count_z1=mysql_num_rows($z1);

		$total_cust=mysql_query("SELECT count(*) as TOTCUST from tbl_customer_master where rep_id in (SELECT repid FROM assigningreptomanager WHERE managerid='".$_SESSION['id']."')");
		$total_row=mysql_fetch_array($total_cust);
		$total_customer_cnt=$total_row['TOTCUST'];

		$cover_cust=mysql_query("SELECT (SELECT count(id) as cnt from tbl_customer_master where rep_id=representative.id and id in (select distinct(our_cust_id) as cust_id from areawise_temp where rep_id=representative.id and date(bill_date) between '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' and '".date("Y/m/d",strtotime($R_MDATE->LastDay))."')) AS COVERCUST FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' GROUP BY areawise_temp.rep_id");
		$cover_cust_cnt=0;
		while($cover_row=mysql_fetch_array($cover_cust)){
			$cover_cust_cnt+=$cover_row['COVERCUST'];
		}
		?>

				<a data-rel="tooltip" title="Total Distributors" class="well span3 top-block" href="#">
				<div>Total Distributors</div>
				<div style="color:#FF0000;"><?php echo $count_z1; ?></div>
				</a>

				<a data-rel="tooltip" title="Total Sales of Last  month" class="well span3 top-block" href="#">					
					<div>Total Sales of Last  month</div>
						<div style="color:#FF0000;">
                        	<?php $Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%'");  $Rs_Sales=mysql_fetch_array($Sales); echo "<strong><span style='color:#FF6600'>PTR :</span> <span style='color:#0000FF'>".round($Rs_Sales["TOTPTR"],2)."</span> <span style='color:#FF6600'>PTS :</span> ".round($Rs_Sales["TOTPTS"],2)."</strong>"; ?>
                        </div>
                </a>
<a data-rel="tooltip" title="12 new messages." class="well span3 top-block" href="#"><div>No of Customers</div>
<div style="color:#FF0000;">
<?php 
$cust = mysql_query("SELECT COUNT(distinct(areawise_temp.our_cust_id)) AS COVERCUST, (select count(*) from tbl_customer_master where rep_id in (SELECT repid FROM assigningreptomanager WHERE managerid='".$_SESSION['id']."')) as TOTCUST FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%'"); 
$RS_CUST = mysql_fetch_object($cust);
echo $cover_cust_cnt." / ".$total_customer_cnt; 
?>
</div></a>

</div>

<div class="box">
<div class="box-content">
<div style="float:right;width: 200px;height: 400px;">
<?php if($total_customer_cnt>0){ ?>
	<div class="sortable row-fluid">
	 	<div id="jssor_html5_AdWords" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 190px; height: 207px; overflow: hidden; visibility: hidden;">
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 190px; height: 207px; overflow: hidden;">
            <?php
			$REPTOTAL=mysql_query("SELECT representative.id as id,representative.rep_name AS rep_name, SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS, (SELECT count(id) as cnt from tbl_customer_master where rep_id=representative.id and id in (select distinct(our_cust_id) as cust_id from areawise_temp where rep_id=representative.id and date(bill_date) between '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' and '".date("Y/m/d",strtotime($R_MDATE->LastDay))."')) AS COVERCUST, (select count(*) from tbl_customer_master where rep_id=areawise_temp.rep_id) as TOTCUST, COUNT(distinct(areawise_temp.our_product_id)) AS TOTPROD FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' GROUP BY areawise_temp.rep_id ORDER BY TOTPTR DESC");
							$i=1;
							while($TOPREP=mysql_fetch_object($REPTOTAL)){
								echo "<div class='well span3 side-chart' href='#' style='width: 190px;height: 207px;margin-left: -1px;display:none;'><div style='background-color: white;'>RANK : ".$i."</div>";
								echo "<div data-rel='tooltip' title='REP NAME' style='border-style: solid;border-top-width: 3px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>REP : ".strtoupper($TOPREP->rep_name)."</div>";
								echo "<div data-rel='tooltip' title='PTR' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PTR : ".round($TOPREP->TOTPTR,2)."</div>";
								echo "<div data-rel='tooltip' title='PTS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PTS : ".round($TOPREP->TOTPTS,2)."</div>";
								echo "<div data-rel='tooltip' title='AVERAGE' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>AVG : ".round($TOPREP->TOTPTR/$TOPREP->COVERCUST,2)."</div>";
                				echo "<div data-rel='tooltip' title='PRODUCTS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'><a href='#' class='products'  data-toggle='modal' data-target='#myModal' id='".$TOPREP->id."' rep_name='".strtoupper($TOPREP->rep_name)."' from='".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' to='".date("Y/m/d",strtotime($R_MDATE->LastDay))."'>PROD: ".$TOPREP->TOTPROD."/".$count_z."</a></div>";
								echo "<div data-rel='tooltip' title='CUSTOMERS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'><a href='#' class='customers'  data-toggle='modal' data-target='#myModal' id='".$TOPREP->id."' from='".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' to='".date("Y/m/d",strtotime($R_MDATE->LastDay))."' rep_name='".strtoupper($TOPREP->rep_name)."'>CUST: ".$TOPREP->COVERCUST."/".$TOPREP->TOTCUST."</a></div>";
								echo "</div>";
								$i++;
							}

			$assign_rep=mysql_query("SELECT repid FROM assigningreptomanager WHERE managerid='".$_SESSION['id']."' and repid not in (SELECT rep_id from areawise_temp where mgr_id like '%,".$_SESSION['id'].",%' and date(bill_date) BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' and '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' group by rep_id)");
				while($assign_rep_sql=mysql_fetch_object($assign_rep)){
					$REPTOTAL_null=mysql_query("SELECT (select id from representative where id='".$assign_rep_sql->repid."') as id, (select rep_name from representative where id='".$assign_rep_sql->repid."') AS rep_name, IFNULL(SUM(areawise_temp.quantity*product.ptr),0) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS, COUNT(distinct(areawise_temp.our_cust_id)) AS COVERCUST, ifnull((select count(*) from tbl_customer_master where rep_id='".$assign_rep_sql->repid."'),0) as TOTCUST, COUNT(distinct(areawise_temp.our_product_id)) AS TOTPROD FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.rep_id='".$assign_rep_sql->repid."' ORDER BY product.ptr DESC");
							while($null_REP=mysql_fetch_object($REPTOTAL_null)){
								echo "<div class='well span3 side-chart' href='#' style='width: 190px;height: 207px;margin-left: -1px;display:none;'><div style='background-color: white;'>RANK : ".$i."</div>";
								echo "<div data-rel='tooltip' title='REP NAME' style='border-style: solid;border-top-width: 3px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>REP : ".strtoupper($null_REP->rep_name)."</div>";
								echo "<div data-rel='tooltip' title='PTR' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PTR : ".round($null_REP->TOTPTR,2)."</div>";
								echo "<div data-rel='tooltip' title='PTS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PTS : ".round($null_REP->TOTPTS,2)."</div>";
								echo "<div data-rel='tooltip' title='AVERAGE' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>AVG : 0</div>";
	                			echo "<div data-rel='tooltip' title='PRODUCTS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PROD: ".$null_REP->TOTPROD."/".$count_z."</div>";
								echo "<div data-rel='tooltip' title='CUSTOMERS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>CUST: ".$null_REP->COVERCUST."/".$null_REP->TOTCUST."</div>";
								echo "</div>";
								$i++;
							}
				}
			?>
        
        </div>
        <span data-u="arrowleft" class="jssora12l" style="top:0px;left:0px;width:30px;height:46px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora12r" style="top:0px;right:0px;width:30px;height:46px;" data-autocenter="2"></span>
    	</div>
	 </div>
   <div data-rel="tooltip" title="TOP REP" class="well span3 side-chart" href="#" style='width: 190px;'><div style='background-color: white;'><?php echo $rep_name_row['rep_name']; ?></div>
      <?php
      $REPTOTAL1=mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS,(SELECT count(*) FROM `product` WHERE `mark_id` LIKE '100001') as total_products,count(distinct(areawise_temp.our_product_id)) as covered, COUNT(distinct(areawise_temp.our_cust_id)) AS COVERCUST, (select count(*) from tbl_customer_master where rep_id in (SELECT repid FROM assigningreptomanager WHERE managerid='".$_SESSION['id']."')) as TOTCUST FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%'");
      $TOPREP1=mysql_fetch_object($REPTOTAL1);
		      echo "<div data-rel='tooltip' title='PTR' style='border-style: solid;border-top-width: 3px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PTR : ".round($TOPREP1->TOTPTR,2)."</div>";
		      echo "<div data-rel='tooltip' title='PTS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>PTS : ".round($TOPREP1->TOTPTS,2)."</div>";
		      if($TOPREP1->covered>0){
		      echo "<div data-rel='tooltip' title='AVERAGE' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>AVG: ". round($TOPREP1->TOTPTR/$TOPREP1->covered,2)."</div>";
		      } else { 
		      echo "<div data-rel='tooltip' title='AVERAGE' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'>AVG: 0</div>";
		      }
		      echo "<div data-rel='tooltip' title='PRODUCTS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'><a href='#' class='total_products_list'  data-toggle='modal' data-target='#myModal_pro' from='".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' to='".date("Y/m/d",strtotime($R_MDATE->LastDay))."'>PROD: ".$TOPREP1->covered."/".$TOPREP1->total_products."</a></div>";
			  echo "<div data-rel='tooltip' title='CUSTOMERS' style='border-style: solid;border-top-width: 0px;background-color: #2B908F;color: white;border-bottom-width: 1px;font-weight: normal;'><a href='#' class='total_customers'  data-toggle='modal' data-target='#myModal_pro' from='".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' to='".date("Y/m/d",strtotime($R_MDATE->LastDay))."'>CUST: ".$cover_cust_cnt."/".$TOPREP1->TOTCUST."</a></div>";
    ?>
        
    </div>
  <?php 
    } else {
      echo 'No Records Found!';
    } 
  ?>
 </div>
<?php
	$YearPeriod = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -13 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$YP=mysql_fetch_object($YearPeriod);				
?>
<script>
$(function () {
    // Create the chart
    $('#INDIA').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthwise PTR Values. <?=date("F Y",strtotime($YP->FirstDay)); ?> to <?=date("F Y",strtotime($YP->LastDay)); ?>'
        },
        subtitle: {
            text: 'Click the PTR, you can view the details.'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'PTR Values'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [{
            name: 'PTR',
            colorByPoint: true,
            data: [
			<?php
				for($i=12;$i>=1;$i--){	
				$SQL = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
				while($RS=mysql_fetch_object($SQL)){ //echo "'"; echo date("M y",strtotime($RS->FirstDay)); echo "',";
			?>
			{
                name: '<?=date("M y",strtotime($RS->FirstDay)); ?>',
			<?php
				$Sales = mysql_query("SELECT SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id  AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' ");  $Rs_Sales=mysql_fetch_array($Sales);
			?>	
                y: <?=round($Rs_Sales["TOTPTR"],2); ?>,
                drilldown: '<?=date("M y",strtotime($RS->FirstDay)); ?>'
            },
			<?php }} ?>
			]
        }],
        drilldown: {
            series: [
			<?php
				for($i=12;$i>=1;$i--){	
				$SQL1 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -$i-1 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -$i month)) LastDay");				
				while($RS=mysql_fetch_object($SQL1)){ //echo "'"; echo date("M y",strtotime($RS->FirstDay)); echo "',";
			?>
			{
                name: '<?=date("M y",strtotime($RS->FirstDay)); ?>',
                id: '<?=date("M y",strtotime($RS->FirstDay)); ?>',
                data: [
				<?php
				$STATE=mysql_query("SELECT representative.rep_name AS rep_name, SUM(areawise_temp.quantity*product.ptr) AS TOTPTR, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product,representative WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($RS->FirstDay))."' AND '".date("Y/m/d",strtotime($RS->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND representative.id=areawise_temp.rep_id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' GROUP BY areawise_temp.rep_id ");
				while($Rs_Sales=mysql_fetch_object($STATE)){
				?>
                    [
                        '<?=strtoupper($Rs_Sales->rep_name);?>',
                       <?=$Rs_Sales->TOTPTR;?>
                    ],
                <?php } ?>    
                ]
            },
			<?php }} ?>
			]
        }
    });
});
</script>

<div style="width:777px;height:400px;">
<div id="INDIA"></div>	
</div>	
   
</div></div>
            
            
			
			
<!--/row-->		

	<?php
	// LAST 2 MONTHS
		$MDATE1 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -1 month)) LastDay");
	$R_MDATE1=mysql_fetch_object($MDATE1);
	
	//LAST 1 MONTH
	$MDATE2 = mysql_query("select date_add(LAST_DAY(date_add(now(),interval -3 month)), interval 1 day) FirstDay, LAST_DAY(date_add(now(),interval -2 month)) LastDay");
	$R_MDATE2=mysql_fetch_object($MDATE2);
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
			<?php $PRODUCT = mysql_query("SELECT  product.pro_name AS PNAME, SUM(areawise_temp.quantity) AS QTY FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE1->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE1->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' GROUP BY our_product_id  ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo "'".$RS_PRODUCT->PNAME."',";} ?>
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
            name: '<?php echo date("M y",strtotime($R_MDATE2->LastDay)) ?>',
            color: 'rgba(165,170,217,1)',
            data: [
			<?php $PRODUCT = mysql_query("SELECT  SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE2->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE2->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' GROUP BY our_product_id  ORDER BY QTY DESC"); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo  $RS_PRODUCT->QTY.",";} ?>
			],
            pointPadding: 0.3,
            pointPlacement: -0.2
        }, {
            name: '<?php echo date("M y",strtotime($R_MDATE->LastDay)) ?>',
            color: 'rgba(126,86,134,.9)',
            data: [<?php $PRODUCT = mysql_query("SELECT SUM(areawise_temp.quantity) AS QTY, SUM(areawise_temp.quantity*product.pts) AS TOTPTS FROM areawise_temp, product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R_MDATE->FirstDay))."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.our_cust_id <> '' AND areawise_temp.our_product_id <> '' AND areawise_temp.our_product_id=product.id AND areawise_temp.mgr_id LIKE '%,".$_SESSION['id'].",%' GROUP BY our_product_id ORDER BY QTY DESC "); while($RS_PRODUCT=mysql_fetch_object($PRODUCT)){ echo $RS_PRODUCT->QTY.",";} ?>],
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
				<h3 class="modal-title" id="rep_title"></h3>
			</div>
			<div class="modal-body" id="pro_list">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>


    <div class="modal hide fade" id="myModal_pro">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3 class="modal-title"><?php echo $rep_name_row['rep_name']; ?></h3>
      </div>
      <div class="modal-body" id="total_pro_list">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>


		<?php include("include/footer.php"); ?>
		
	</div><!--/.fluid-container-->

<div id="stack2" class="modal fade" tabindex="-1" data-focus-on="input:first" style="display: none;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="product_title"></h4>
  </div>
  <div class="modal-body" id="customer_list">
    
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
  </div>
</div>

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
	
  <script>
      $('.customers').click(function(){
        var id=$(this).attr('id');
        var from=$(this).attr('from');
        var to=$(this).attr('to');
        $('#rep_title').html($(this).attr('rep_name'));
        $.ajax({
          url: "customer_list.php", 
          type:"post",
          data:"&id="+id+"&from="+from+"&to="+to,
          success: function(result){
          	$("#myModal").css("width","770px");
            $("#pro_list").html(result);
          }
        });
      });

      $('.total_customers').click(function(){
        var from=$(this).attr('from');
        var to=$(this).attr('to');
        $.ajax({
          url: "total_customer_list.php", 
          type:"post",
          data:"&from="+from+"&to="+to,
          success: function(result){
          	$("#myModal_pro").css("width","770px");
            $("#total_pro_list").html(result);
          }
        });
      });

      $('.products').click(function(){
        var id=$(this).attr('id');
        var from=$(this).attr('from');
        var to=$(this).attr('to');
        $('#rep_title').html($(this).attr('rep_name'));
        $.ajax({
          url: "product_list.php", 
          type:"post",
          data:"&id="+id+"&from="+from+"&to="+to,
          success: function(result){
          	$("#myModal").css("width","550px");
            $("#pro_list").html(result);
          }
        });
      });

      $('.total_products_list').click(function(){
        var from=$(this).attr('from');
        var to=$(this).attr('to');
        $.ajax({
          url: "total_product_list.php", 
          type:"post",
          data:"&from="+from+"&to="+to,
          success: function(result){
          	$("#myModal_pro").css("width","550px");
            $("#total_pro_list").html(result);
          }
        });
      });

      function show_customers(cust){
        var id=$(cust).attr('id');
        var rep_id=$(cust).attr('rep_id');
        var from=$(cust).attr('from');
        var to=$(cust).attr('to');
        var pop_up=$(cust).attr('pop_up');
        $('#product_title').html($(cust).attr('prod_name')+' ('+$(cust).attr('qty')+')');
        $.ajax({
          url: "customer_product_list.php", 
          type:"post",
          data:"&id="+id+"&from="+from+"&to="+to+"&rep_id="+rep_id+"&pop_up="+pop_up,
          success: function(result){
            $("#customer_list").html(result);
          }
        });
      }
  </script>
		
</body>
</html>
<?php
}
?>