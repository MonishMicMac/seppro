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
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
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
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/customer_search.php",
	minLength: 2,
	select: function(event, ui) {
	var getUrl = ui.item.id;
	if(getUrl != '#') {
	location.href = getUrl;
	}
	},
	
	html: true, 
	
	open: function(event, ui) {
	$(".ui-autocomplete").css("z-index", 1000);
	}
	});
	
	});
	</script>	
    
   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#from_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
dateFormat:"yy/mm/dd"
});
$( "#to_date" ).datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1990:2020",
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

<div id="content" class="span10" >

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h3><i class="fa fa-slideshare" aria-hidden="true"></i> Pincodewise Customer Product Sharing </h3>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
        	<tr>
            	<td>Customer Name</td>
                <td>:</td>
                <td>
                	<input id="dd_user_input" type="text" name="cust_name" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["cust_name"]!=""){ ?>value="<?php echo @$_REQUEST["cust_name"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
                </td>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="CUSTOMER SHARING" class="btn btn-primary" style="margin-top:-12px" ></td>
            </tr>                       
        </table>
        <?php if(@$_REQUEST["submit"]=="CUSTOMER SHARING"){ $PIN = explode("-",@$_REQUEST["cust_name"]); ?>
    <hr>
   <div class="control-group">
    <label class="control-label" for="typeahead"><span class="btn btn-info"><?=@$PIN[0]; ?> ASSIGNED REPRESENTATIVE</span></label>
    <div class="controls">
    <table>
    <?php
			$SQL = mysql_query("SELECT representative.rep_name,representative.id rid FROM rep_area,representative WHERE rep_area.pin_id IN (SELECT pin_id FROM master_pincode WHERE pincode='".$PIN[0]."') AND rep_area.rep_id=representative.id");
			while($RS = mysql_fetch_object($SQL)){
    ?> 
       <tr class="repId"><td><label class="radio"><input type="radio" class="form-control" id="rep" name="rep" value="<?php echo $RS->rid; ?>"></label>&nbsp;&nbsp;<span class="typeahead"><em><?php echo strtoupper($RS->rep_name); ?></em></span></td><td hidden class="rep"><?php echo $RS->rid; ?></td></tr>
       
    <?php } ?>       
</table></div></div>
<div>&nbsp;</div>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
	<thead><tr><th>Sl.No</th><th>Select</th><th>Product</th><th>PTS</th><th>REP</th></tr></thead>
    <tbody>
	<?php $Y = 1; $Product = mysql_query("SELECT id,pro_name,pts FROM product LIMIT 3");while($P = mysql_fetch_object($Product)){ ?>
    <tr>
    	<td><?=$Y; ?></td>
        <td>
        	<input type="checkbox" class="form-control" id="p<?php echo strtoupper($P->id); ?>" name="product[]" value="<?php echo strtoupper($P->id); ?>">
        </td>
        <td><?=strtoupper($P->pro_name); ?></td>
        <td><?=$P->pts; ?></td>
        <?php
			$Y++;			
			$EXISTING = mysql_query("SELECT IFNULL(representative.rep_name,'VACANT') REP FROM tbl_customer_product_sharing,representative WHERE tbl_customer_product_sharing.sharing_productid=".$P->id." AND tbl_customer_product_sharing.sharing_pinid IN (SELECT master_pincode.pin_id FROM master_pincode WHERE master_pincode.pincode='".$_REQUEST["pincode"]."') AND tbl_customer_product_sharing.sharing_repid=representative.id");
			while($Y1 = mysql_fetch_object($EXISTING)){
		?>
        <td><?php echo $Y1->REP; ?></td>
    </tr>
    <?php  }} ?>
</tbody>
</table>
<div><input type="button" id="assign" name="submit" value="ASSIGN" class="btn btn-primary" style="margin-top:-12px" ></div>


 <?php } ?>       
    </form>
</div>
        
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
<script type="text/javascript">
$("#assign").click(function(){	
	var favorite = [];$.each($("input[name='product[]']:checked"), function(){favorite.push($(this).val());});var prod =favorite;
	$.post("autosearch-y/pincodewise_product_sharing.php?sharing=customer&customer="+$("#dd_user_input").val()+"&rep="+$(".repId").find(".checked").closest("tr").find(".rep").text()+"&product="+prod+"",function(data,status){
		alert("Customer Product Sharing Assigned....");
		window.location.href="pincodewise_customer_sharing.php";
	}); 
});
</script>
</body>
</html>
<?php
}
?>
