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
		$("<?php $a=mysql_query("SELECT tbl_customer_master.id,tbl_customer_master.shop_name,tbl_customer_master.rep_id,tbl_customer_master.pin_id,master_pincode.pincode FROM tbl_customer_master,master_pincode WHERE tbl_customer_master.pin_id  = ".$_REQUEST["pin_id"]." AND master_pincode.pin_id=".$_REQUEST["pin_id"]." ORDER BY tbl_customer_master.shop_name ")or die(mysql_error()); while($row_a=mysql_fetch_array($a)){echo $our_id = "#Y".$row_a['id'].",";} echo substr($our_id,0,-1);?>").autocomplete({
		
		source: "autosearch-y/rep_customer.php?pin_id="+<?php echo $_REQUEST["pin_id"]; ?>+"",
		minLength: 2,
		select: function(event, ui) {
		var getUrl = ui.item.id; // OUR REP ID
	    var id = $(this).attr('id'); // AREAWISE TEMP - CUSTOMER CUSTOMER ID
		//alert(getUrl+""+id);
		$.post("autosearch-y/rep_customer_mapping.php?our_cust_id="+getUrl+"&cust_id="+id+"", {our_cust_id: getUrl}, function(data){
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
<h2><i class="icon-user"></i>Distributor Customer Mapping with Division Customer</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th width="6%">S.NO</th>
<th width="25%">Customer Name</th>
<th width="8%">Pincode</th>
<th width="25%">Action</th>
</tr>
</thead>   
<tbody>
	<?php $y=1;  $SQL=mysql_query("SELECT tbl_customer_master.id,tbl_customer_master.shop_name,tbl_customer_master.rep_id,tbl_customer_master.pin_id,master_pincode.pincode FROM tbl_customer_master,master_pincode WHERE tbl_customer_master.pin_id  = ".$_REQUEST["pin_id"]." AND master_pincode.pin_id=".$_REQUEST["pin_id"]." AND tbl_customer_master.rep_id = ".$_REQUEST["rep_id"]." ORDER BY tbl_customer_master.shop_name "); while($RS=mysql_fetch_assoc($SQL)){ ?>
	<tr><td><?=$y; ?></td><td><?=$RS['shop_name']; ?></td><td><?=$RS['pincode']; ?></td><td><input type="text" name="Y<?=$RS['id']; ?>" id="Y<?=$RS['id']; ?>" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if($RS['rep_id']!=0){ ?>value="<?php $query = mysql_query("SELECT rep_name,mobile FROM representative  WHERE id IN (SELECT rep_id FROM tbl_customer_master WHERE pin_id=".$_REQUEST["pin_id"]." AND id=".$RS['id']." )");echo mysql_error();$recResult = mysql_fetch_assoc($query);echo $recResult['rep_name']."-".$recResult['mobile']; ?>" <?php }else{ ?> value="Type your Input Here" <?php } ?> /></td></tr>
    <?php $y++;} ?>
</tbody>
</table> 
<script>
function baba(id,our_cust_id){ 
	$( document ).ready(function() {
		//alert(our_cust_id);
  		$.post("autosearch-y/unmap.php?our_cust_id="+our_cust_id+"&id="+id+"", {our_cust_id: our_cust_id}, function(data){
			//alert(data);
		});
	});	
}
</script>           
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
