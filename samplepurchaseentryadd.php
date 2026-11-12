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
			  if(isset($_REQUEST['productname']))
{	
  $sqty=mysql_query("SELECT * FROM product WHERE id = '".$_REQUEST["productname"]."'") or die(mysql_error());
  $sqty_R=mysql_fetch_array($sqty);
  echo $st=$sqty_R['ptr'];
  exit();
}
			  if(isset($_REQUEST['productnamebatch']))
{		
  $sqty1=mysql_query("SELECT * FROM mst_batchdetails WHERE product_id = '".$_REQUEST["productnamebatch"]."'") or die(mysql_error());
  $sqty1_R=mysql_fetch_array($sqty1);
  echo $st1=$sqty1_R['batch'];
  exit();
}
require_once("include/select.php");
$ad=new select1();
$res=$ad->view('customer','','order by id desc');
$res1=$ad->count1('customer','','order by id desc');
$res2=$ad->view('district','','');
$res3=$ad->view('pincode_list','','');
$res7=$ad->view('distributor','where m_id16='.$m_id16,'order by id desc');
if(@$_REQUEST["DID"]!=""){
	$SQL=mysql_query("SELECT * FROM doctors WHERE id=".$_REQUEST["DID"]."");
	$R=mysql_fetch_object($SQL);
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
        <link href="css/bootstrap-cerulean.min.css" id="bs-css" rel="stylesheet">
	<link rel="shortcut icon" href="img/favicon1.ico">
        
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>  
 <script type="text/javascript" src="google_dynamic_map.js"></script>   

<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
var xmlhttp=false;	
try{
	xmlhttp=new XMLHttpRequest();
	}
	catch(e)	
	{		
	try{			
	xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp=false;
	}
	}
	}
 	return xmlhttp;
	}
//Function for Displaying cities
function getcat(title)
{
 var strURL="getInfo1.php?title="+title;
 //alert(strURL);
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState === 4)
      {
  // only if "OK"
  if (req.status === 200)
         {
     document.getElementById('sub_category').innerHTML=req.responseText;
  } else {
       alert("There was a problem while using XMLHTTP:\n" + req.statusText);
  }
       }
      }
   req.open("GET", strURL, true);
   req.send(null);
   } 
  } 
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="autosearch-y/jquery-ui-1.8.2.custom.min.js"></script>
    <link href="autosearch-y/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"> 
	$(function() {
	
	$("#dd_user_input").autocomplete({
	source: "autosearch-y/patient_type.php",
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
	
	$(function() {
	
	$("#dd_user_input5").autocomplete({
	source: "autosearch-y/area.php?area_id="+<?=$_REQUEST["pin"]; ?>+"",
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
	$(document).ready(function(){
		$("#pt_add").click(function(){
			$.get("autosearch-y/rcpa.php?pat_type=add&pt_name="+$("#dd_user_input").val()+"",function(data,status){
					$("#show_pt").html(data);
				});	
		});
		$("#area_id").click(function(){			
			$.get("autosearch-y/rcpa.php?area_id=add&area_name="+$("#dd_user_input5").val()+"&pin_id="+$("#doc_pincode").val()+"",function(data,status){
					alert(data);
			});	
		});
	});
	function deleteMe(ID){		
		$(document).ready(function(){
			$.get("autosearch-y/rcpa.php?pat_type_del=del&pt_id="+ID+"",function(data,status){
					$("#show_pt").html(data);
				});	
		})
	}
	</script>
    </head>

<body onLoad="initialize();">
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
<h2><i class="icon-edit"></i>Add Sample Purchase Entry</h2>
<div class="box-icon">
</div>
</div>
<div style="float:right;margin-top:5px;margin-right:80px">
<div class="control-group">
<div class="controls">

</div></div>
<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_purchase" />
 <fieldset>

<div class="control-group"><label class="control-label" for="typeahead">Product Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<select name="productname" id="productname" data-rel="chosen" required >
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM product"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?php echo $I->id; ?>"><?php echo $I->pro_name; ?></option>
        <?php } ?>
    </select>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">Quantity<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="quantity" id="quantity" required="" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Sample Value<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="samplevalue" id="samplevalue" required="" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Total Value<span style="color:#FF0000;">*</span></label>
<div class="controls"><input class="input-xlarge disabled"  type="text"  name="totalvalue" id="totalvalue" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Company Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="companyname" id="companyname" required="" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Purchase Date<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="purchasedate" id="purchasedate" required="" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Batch<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="batch" id="batch" required="" />        
</div>
</div>



<div class="controls">
    <table style="width:100%;">
    <tr>
        <td><Label>MFR Date<span style="color:#FF0000;">*</span> </label></td>
        <td>:</td>
        <td><input type="text" name="mfrdate" id="mfrdate" readonly /></td>
        <td><Label>EXP Date<span style="color:#FF0000;">*</span> </label></td>
        <td>:</td>
        <td><input type="text" name="expdate" id="expdate" readonly /></td>        
        <td></td>
    </tr>
    </table>
</div></div>


<style>
.modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}
@media (min-width: 32em) {

.modal-box { width: 70%; }
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
</style>

<div class="control-group">
<div class="controls">
    
</div>
</div>



<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" /> 
    <input type="reset" class="btn" value="Cancel" />
</div>

</fieldset></form>


<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i> Sample Purchase Entry List</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">

<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
	<th>#</th>
<th>Product Name</th>
<th>Quantity</th>
<th>Sample Value</th>
<th>Total Value</th>
<th>Batch</th>
<th>MFR Date</th>
<th>EXP Date</th>
</tr>
</thead>   
<tbody>
<?php
$a=mysql_query("SELECT * FROM sample_pur_entry ORDER BY sam_pur_entry_id");
$count_a=mysql_num_rows($a);
$x=1;
while($row_a=mysql_fetch_array($a)){ 
?> 
<tr>
    <td><?=$x;?></td>
    <td><?=$row_a['sam_pur_entry_pname'];?></td>
    <td><?=$row_a['sam_pur_entry_qty'];?></td> 
    <td><?=$row_a['sam_pur_entry_sval'];?></td>
    <td><?=$row_a['sam_pur_entry_tval'];?></td>
    <td><?=$row_a['sam_pur_entry_bat'];?></td>
    <td><?=$row_a['sam_pur_entry_mfrdate'];?></td>           
    <td><?=$row_a['sam_pur_entry_expdate'];?></td> 

</tr>
<?php
$x++;
}
?>
</tbody>
</table> 
<script>
function yuvaraj(DID,pin){
	if(confirm("Are sure you want to Delete this Doctor Details!!!!")){
		window.location.href="view_doctor.php?mode=del&DID="+DID+"&pincode="+pin+"";
	}
}
function pin_chy(pin){
	window.location.href="view_doctor.php?pincode="+pin;
}
</script>           
</div>
</div>
</div>
</div></div></div>
<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>     

	
<?php include("include/footer.php"); ?>
		
	</div>
	<script src="js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
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
$(function(){ $( "#mfrdate,#expdate,#purchasedate" ).datepicker(); });
$("#samplevalue").change(function(){	
	var quantity = $("#quantity").val();
	var samplevalue = $("#samplevalue").val();
	var totalvalue = parseInt(quantity)*parseInt(samplevalue);
	$('#totalvalue').val(totalvalue);
	});

$("#quantity").change(function(){	
	var quantity = $("#quantity").val();
	var samplevalue = $("#samplevalue").val();
	var totalvalue = parseInt(quantity)*parseInt(samplevalue);
	$('#totalvalue').val(totalvalue);
	});

$("#productname").change(function(){	
	$.post("samplepurchaseentryadd.php",{productname:$("#productname").val()}, function( data ) { 
		$('#samplevalue').val(data);
	});
	$.post("samplepurchaseentryadd.php",{productnamebatch:$("#productname").val()}, function( data ) { 
		$('#batch').val(data);
	});
});
</script>	
		
</body>
</html>
<?php
}
?>
