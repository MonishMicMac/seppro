<?php
include("include/connect.php");
session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
   echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
include("encrypt.php");
include("include/select.php");
$fun = new select1;
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
	<link rel="shortcut icon" href="img/favicon1.ico">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
		$(function() {		
		$("<?php $a=mysql_query("SELECT * FROM product ORDER BY id")or die(mysql_error()); while($row_a=mysql_fetch_array($a)){echo $our_id = "#Y".$row_a['id'].",";} echo substr($our_id,0,-1);?>").autocomplete({
		
		source: "autosearch-y/product_mapping.php",
		minLength: 2,
		select: function(event, ui) {
		var getUrl = ui.item.id; // OUR CUSTOMER ID
	    var id = $(this).attr('id'); // AREAWISE TEMP - DISTRIBUTOER CUSTOMER ID
		$.post("autosearch-y/yuvaraj_product.php?our_cust_id="+getUrl+"&dist_cust_id="+id+"", {our_cust_id: getUrl}, function(data){
		//alert(data);
		});
		//location.href = "autosearch-y/yuvaraj_great.php?our_cust_id="+getUrl+"&dist_cust_id="+id;	
		},
		
		html: true, 
		
		open: function(event, ui) {
		$(".ui-autocomplete").css("z-index", 1000);
		}
		});
		
		});
	</script>
</head>

<body>
<!-- topbar starts -->
<?php include("include/header.php"); ?>
<!-- topbar ends -->
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>

<noscript>
<div class="alert alert-block span10">
</div>
</noscript>

<div id="content" class="span10">

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i>Distributor Product Mapping with Division Product</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
    <th width="50%">CUSTOMER WISE</th>
    <th width="50%" align="center">PRODUCT WISE</th>
</tr>
</thead>   
<tbody>
	
    <tr>
    	<td>
    		<table class="table table-striped table-bordered bootstrap-datatable datatable">
            <thead><tr><th colspan="2">UNMAPPED CUSTOMER DISTRIBUTOR WISE</th></tr></thead>
            <tbody>
            	<tr>
                <?php
				$split2=0;
				$distributor2 = mysql_query("SELECT dis_name,dis_id FROM distributor WHERE m_id16 = $m_id16"); 
				while($distributor_3=mysql_fetch_object($distributor2)){
				
				
				 ?>
                <td><a href="salesreport_customer_mapping.php?our_cust_id=<?=$distributor_3->dis_id; ?>&c=0"><?=$distributor_3->dis_name; ?></a></td><td><a href="salesreport_customer_mapping.php?our_cust_id=<?=$distributor_3->dis_id; ?>&c=0" style="color:#FF0000"><?php echo $fun->cnt("distributor_customer","our_cust_id= '' AND distributor_id = $distributor_3->dis_id"); ?></a></td><?php $split2++;if ($split2%2==0){echo '</tr><tr>';}} ?></tr>
            </tbody>
            </table>
    	</td>
        <td>
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead><tr><th colspan="2">UNMAPPED PRODUCT DISTRIBUTOR WISE</th></tr></thead>
        <tbody>
            <tr>
            <?php
				$split3=0;
				$distributor3 = mysql_query("SELECT dis_name,dis_id FROM distributor WHERE m_id16 = $m_id16"); 
				while($distributor_4=mysql_fetch_object($distributor3)){
				
			?>
            <td><a href="salesreport_product_mapping.php?our_id=<?=$distributor_4->dis_id; ?>&c=0"><?=$distributor_4->dis_name; ?></a></td><td><a href="salesreport_product_mapping.php?our_id=<?=$distributor_4->dis_id; ?>&c=0" style="color:#FF0000"><?php echo $fun->cnt("dist_prod","our_id= '' AND dist_id = $distributor_4->dis_id"); ?></a></td><?php $split3++;if ($split3%2==0){echo '</tr><tr>';}} ?></tr>
        </tbody>
        </table>
        </td>
	</tr>
    
    
	<tr>
    	<td>
        	<table class="table table-striped table-bordered bootstrap-datatable datatable">
            <thead><tr><th colspan="2">MAPPED CUSTOMER DISTRIBUTOR WISE</th></tr></thead>
            <tbody>
            	<tr>
                <?php
					$split=0;
					$distributor = mysql_query("SELECT dis_name,dis_id FROM distributor WHERE m_id16 = $m_id16");
					while($distributor_1=mysql_fetch_object($distributor)){					
				?>
                <td><a href="salesreport_customer_mapping.php?our_cust_id=<?=$distributor_1->dis_id; ?>&c=1"><?=$distributor_1->dis_name; ?></a></td><td><a href="salesreport_customer_mapping.php?our_cust_id=<?=$distributor_1->dis_id; ?>&c=1" style="color:#FF6600"><?php echo $fun->cnt("distributor_customer","our_cust_id!= '' AND distributor_id = $distributor_1->dis_id"); ?></a></td><?php $split++;if ($split%2==0){echo '</tr><tr>';}} ?></tr>
            </tbody>
            </table>
        </td>
        <td>
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead><tr><th colspan="2">MAPPED PRODUCT DISTRIBUTOR WISE</th></tr></thead>
        <tbody>
            <tr>
            <?php
				$split1=0;
				$distributor1 = mysql_query("SELECT dis_name,dis_id FROM distributor WHERE m_id16 = $m_id16"); 
				while($distributor_2=mysql_fetch_object($distributor1)){ ?>
            <td><a href="salesreport_product_mapping.php?our_id=<?=$distributor_2->dis_id; ?>&c=1"><?=$distributor_2->dis_name; ?></a></td><td><a href="salesreport_product_mapping.php?our_id=<?=$distributor_2->dis_id; ?>&c=1"  style="color:#FF6600"><?php echo $fun->cnt("dist_prod","our_id != '' AND dist_id = $distributor_2->dis_id"); ?></a></td><?php $split1++;if ($split1%2==0){echo '</tr><tr>';}} ?>
            
            </tr>
        </tbody>
        </table>
        
        </td>
    </tr>
    
</tbody>
</table>            
</div>
</div>
</div>
</div>
</div>
<hr>

<?php include("include/footer.php"); ?>

</div>
<script src="js/jquery-1.7.2.min.js"></script>
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
<script src="js/jquery.uniform.min.js"></script>
<script src="js/jquery.colorbox.min.js"></script>
<script src="js/jquery.cleditor.min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/jquery.elfinder.min.js"></script>
<script src="js/jquery.raty.min.js"></script>
<script src="js/jquery.iphone.toggle.js"></script>
<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/jquery.uploadify-3.1.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/charisma.js"></script>		
</body>
</html>
<?php
}
?>
