<?php
include("include/connect.php");
session_start();
//error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{

require_once("include/select.php");
$ad=new select1();
$res2=mysql_query("SELECT DISTINCT(dist_id) FROM pincode_list")or die(mysql_error());
$abc=mysql_query("SELECT * FROM tbl_customer_master order by id desc limit 1")or die(mysql_error());
$row_abc=mysql_fetch_array($abc);
$co_abc=mysql_num_rows($abc);
if($co_abc > 0)
{
    $cust_id=$row_abc['id']+1;
}
else 
{
    $cust_id="10001";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php include("include/title.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="mic and mac Solutions">
<meta name="author" content="mic and mac Solutions">
<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">

<style type="text/css">
body {
padding-bottom: 40px;
}
 .sidebar-nav {
padding: 9px 0;
}

.kv-file-upload{

display:none;

}

.kv-file-remove{

display:none;

}

.kv-upload-progress
{

display:none;

}

.active{"background-color":#F28C02; color:#FFFFFF; }

     </style>  
	<link type="text/css" href="fileinput.css" rel="stylesheet" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link rel="shortcut icon" href="img/favicon1.ico">  
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
    $(function() {
    $( "#from_date" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: "2015:2025",
    dateFormat:"yy/mm/dd"
    });
    $( "#to_date" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange: "2015:2025",
    dateFormat:"yy/mm/dd"
    });
    //ajax Starts
    $("#search_box").keypress(function(){
        var from_date =$("#from_date").val();
        var to_date    =$("#to_date").val();
        var content =$("#search_box").val();
        var url="sort_shops.php?from_date="+from_date+"&to_date="+to_date+"&cont="+content;
        $.get(url,function(data,status){
            $("#search").html(data);
        });
    });
    //ajax Ends
    });
    </script>

   
    
    </head>

<body onLoad="initialize();">
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
			
			
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>REPRESENTATIVE CONSOLIDATED REPORT</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content" style="background:#F28C02; padding:14px 8px 10px 8px;color:#FFFFFF;box-shadow: 4px 4px 5px #888888;">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<table style="width:70%; vertical-align:middle" align="center">
    <tr>
        <td><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>" required/></td>
        <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>" required/> &nbsp;&nbsp;</td>
        <td><input type="submit" name="submit" value="REPORT" class="btn" style="font-family:Bookman Old Style;color:#FFFFFF;background:#666666" ></td>
    </tr>    
</table>
</div>
<div class="box-content">
<div>&nbsp;</div>
<?php
if(@$_REQUEST["submit"]=="REPORT"){

		$SQL=mysql_query("SELECT rep_id, COUNT(DISTINCT(`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (`bill_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') GROUP BY rep_id ORDER BY PTS DESC");
?>

<?php 
// echo "SELECT rep_id, COUNT(DISTINCT(`pin_id`)) AS PIN, COUNT(DISTINCT(`our_cust_id`)) AS CUST, COUNT(DISTINCT(`our_product_id`)) AS PROD,ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (`bill_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') GROUP BY rep_id ORDER BY PTS DESC"; ?>
<style>.REPC tr:nth-child(odd){background-color:#CCCCCC;}</style>
<table class="table table-bordered yuvi" id="representative">
<thead><tr><th style="background:#00B300;color:#FFFFFF">REPRESENTAIVE</th><th style="background:#00B300;color:#FFFFFF">PINCODES</th><th style="background:#00B300;color:#FFFFFF">CUSTOMERS</th><th style="background:#00B300;color:#FFFFFF">PRODUCTS</th><th style="background:#00B300;color:#FFFFFF">PTR</th><th style="background:#00B300;color:#FFFFFF">PTS</th></tr></thead>
<tbody>
<?php
	
		while($R=mysql_fetch_object($SQL)){
		if($R->rep_id>0){
			$REP=mysql_query("SELECT rep_name FROM representative WHERE id=".$R->rep_id.""); $RE=mysql_fetch_object($REP);
			echo "<tr class='REPC' id='$R->rep_id'><td class='rep' hidden>".$R->rep_id."</td><td>".$RE->rep_name."".$R->rep_id."</td><td>".$R->PIN."</td><td>".$R->CUST."</td><td>".$R->PROD."</td><td>".$R->PTR."</td><td>".$R->PTS."</td></tr>";
		}
		if($R->rep_id==0){echo "<tr class='REPC' id='$R->rep_id'><td class='rep' hidden>".$R->rep_id."</td><td>Vacant / Unassigned</td><td>".$R->PIN."</td><td>".$R->CUST."</td><td>".$R->PROD."</td><td>".$R->PTR."</td><td>".$R->PTS."</td></tr>";}
		}	
		$TOT=mysql_query("SELECT ROUND(SUM(`quantity`*ptr),2) AS PTR, ROUND(SUM(`quantity`*pts),2) AS PTS FROM `areawise_temp` WHERE `our_cust_id`!='' AND `our_product_id`!='' AND (`bill_date` BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."')");
		$T=mysql_fetch_object($TOT);
		echo "<tr><td colspan='4' style='text-align:right;font-weight:bold;'>TOTAL</td><td>".$T->PTR."</td><td>".$T->PTS."</td></tr>";
	}
?>
</tbody>
</table>
<div>&nbsp;</div>
<div id="pincode"></div>
<div>&nbsp;</div>
<div id="pincoded"></div>
</form>
</div>
</div>
</div>

</div>
</div>

<hr>
      
    </div>

    <?php include("include/footer.php"); ?>
		
	</div>
	<script src="js/jquery-1.7.2.min.js"></script>
  
        <script src="fileinput.js"></script>
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<script src="js/bootstrap-transition.js"></script>
	<script src="js/bootstrap-alert.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/bootstrap-scrollspy.js"></script>
	<script src="js/bootstrap-tab.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
	<script src="js/bootstrap-popover.js"></script>
	<script src="js/bootstrap-button.js"></script>
	<script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-carousel.js"></script>
	<script src="js/bootstrap-typeahead.js"></script>
	<script src="js/bootstrap-tour.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src='js/fullcalendar.min.js'></script>
	<script src='js/jquery.dataTables.min.js'></script>
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<script src="js/jquery.chosen.min.js"></script>
	<script src="js/jquery.colorbox.min.js"></script>
	<script src="js/jquery.cleditor.min.js"></script>
	<script src="js/jquery.elfinder.min.js"></script>
	<script src="js/jquery.raty.min.js"></script>
	<script src="js/jquery.iphone.toggle.js"></script>
	<script src="js/jquery.autogrow-textarea.js"></script>
	
	<script src="js/jquery.history.js"></script>
	<script src="js/charisma.js"></script>
    <style>
		.highlight { background-color: #F28C02; }		
    </style>
    <script>
	
    $(".REPC").click(function(){				
		var selected = $(this).hasClass("highlight");
		$(".REPC").removeClass("highlight");
		if(!selected)
				$(this).addClass("highlight");
	$.get("autosearch-y/representative.php?repc=add&rep_id="+$(this).closest('tr').find('.rep').text()+"&from_date="+$("#from_date").val()+"&to_date="+$("#to_date").val()+"",function(data){ $("#pincode").html(data); });
	});
	
	function yuvaraj(P,R,F,T){		
		$.get("autosearch-y/representative.php?repcd=add&rep_id="+R+"&from_date="+F+"&to_date="+T+"&pin_id="+P+"",function(data){$("#pincoded").html(data);});
	}	
    </script> 
      
</body>
</html>
<?php
}
?>
