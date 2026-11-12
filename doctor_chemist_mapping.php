<?php
include("include/connect.php");
session_start();
error_reporting(E_ALL);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
if(@$_REQUEST["mode"]=="save"){	
	mysql_query("UPDATE tbl_doctor_chemist SET doctor_id='".$_REQUEST["doctor"]."' WHERE chemist_id>0 AND status=1");
	header("location:doctor_chemist_mapping.php");
	die();
}
if(@$_REQUEST["mode"]=="delete"){	
	mysql_query("DELETE FROM tbl_doctor_chemist WHERE dc_id=".$_REQUEST["dc_id"]."");
	header("location:doctor_chemist_mapping.php?pin=".$_REQUEST["pin"]."&d_id=".$_REQUEST["d_id"]."");
	die();
}
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
<!-- email Validation-->

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
	
	$(function() {
	
	$("#dd_user_input7").autocomplete({
	source: "autosearch-y/distributor_search.php",
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
		$("#area_id").click(function(){			
			$.get("autosearch-y/rcpa.php?area_id=add&area_name="+$("#dd_user_input5").val()+"&pin_id="+$("#doc_pincode").val()+"",function(data,status){
					alert(data);
			});	
		});
	});

function valid_email(text_value,text_id) 
{
    var atpos = text_value.indexOf("@");
    var dotpos = text_value.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
    {
        document.getElementById(text_id).value = "";
        document.getElementById("doc_email").focus();
        alert("Not a valid e-mail address");
        return false;
    }
}
<!--            end             -->         
function valid()
{
var x=document.getElementById("cust_name").value;
if(x==="null" || x==="")
{
alert("Please Enter Customer Name");
return false; 
}
var y=document.getElementById("dist_id").value;
if(y==="null" || y==="")
{
alert("Please Enter District Name");
return false; 
}
var z=document.getElementById("cust_addr").value;
if(z==="null" || z==="")
{
alert("Please Enter Customer Address");
return false; 
}
var a=document.getElementById("cont_no").value;
if(a==="null" || a==="")
{
alert("Please Enter Contact Number");
return false; 
}

return true;
}
<!-- mobile number validation-->
function onlyNumbers(event) 
{
var charCode = (event.which) ? event.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false; 
return true; 
}
//accepts all ten numbers
function check_count1(num_value,num_id) 
{
if (num_value.length < 10)
{
alert('Mobile number must be 10 digits');
document.getElementById(num_id).value = "";
return false;
}
return true;
}
<!--        end                -->

<!--Name validation-->
function isAlphaNumeric(evtGet) 
{
    var browser = navigator.appName;
    if (browser == "Microsoft Internet Explorer" || browser == "Mozilla Firefox") {
        var keyGet = evtGet.keyCode;
    } else {
        var keyGet = evtGet.which; //(window.Event) ? evtGet.which : evtGet.keyCode;
    }
  //  alert(keyGet);
        if ((keyGet > 47 && keyGet < 58) || (keyGet > 64 && keyGet < 91) || (keyGet > 96 && keyGet < 123) || (keyGet == 9) || (keyGet == 32) || (keyGet == 8) || (keyGet == 0) || (keyGet == 13)||(keyGet==110))
            return;
        else
            if (browser == "Microsoft Internet Explorer" || browser == "Mozilla Firefox")
            window.event.returnValue = null;
        else
            evtGet.preventDefault();
}
<!--              end           -->

</script>
<script type="text/javascript">
function pin_chy(pin){  	
	window.location.href="doctor_chemist_mapping.php?pin="+pin;
  }
function doctors(pin,d_id){
	window.location.href="doctor_chemist_mapping.php?pin="+pin+"&d_id="+d_id+"";
}
</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>  
 <script type="text/javascript" src="google_dynamic_map.js"></script>
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
<h2><i class="icon-edit"></i>DOCTOR + CHEMIST MAPPING</h2>
<div class="box-icon">
</div>
</div>   

<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
  <div class="control-group"><label class="control-label" for="typeahead">Select Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<select name="doc_pincode" id="doc_pincode" data-rel="chosen" required onChange="pin_chy(this.value);">
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM master_pincode ORDER BY pincode"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
        <?php } ?>
    </select><script>document.getElementById("doc_pincode").value="<?=$_REQUEST["pin"] ?>";</script>
</div></div>  

<div class="control-group"><label class="control-label" for="typeahead">Select Doctor<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<select name="doctor" id="doctor" data-rel="chosen" required onChange="doctors(document.getElementById('doc_pincode').value, this.value);">
    	<option value="">---Select---</option>
        <?php $DC=mysql_query("SELECT * FROM doctors WHERE doc_pin_id = '".$_REQUEST["pin"]."' ORDER BY doctor_name"); while($D=mysql_fetch_object($DC)){ ?>
        	<option value="<?=$D->id; ?>"><?=$D->doctor_name." / ".$D->doctor_addrs; ?></option>
        <?php } ?>
    </select><script>document.getElementById("doctor").value="<?=$_REQUEST["d_id"] ?>";</script>
</div></div>
<?php if(@$_REQUEST["pin"]!=""){ ?> 
<div class="control-group">
	<div class="controls"><a href="#" class="btn btn-info btn-setting">SELECT CHEMIST</a></div>
</div>
<?php } ?> 
<div class="control-group" style="height:auto" id="show_dis"></div>
<?php if((@$_REQUEST["pin"]!="")&&(@$_REQUEST["d_id"]!="")){ ?>

<div class="row-fluid sortable">		
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-user"></i> MAPPED DOCTOR <-> CHEMIST DETAILS</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
	<table  class="table table-striped table-bordered bootstrap-datatable datatable">
    <thead><tr><th style="text-align:center">S.No</th><th>Doctor</th><th style="width:750px;">Address&hellip;&hellip;&hellip;&hellip;&hellip;</th><th style="text-align:center"><img src="img/uploadify-cancel.png" width="10" height="10"></th></tr></thead>
    <tbody>
    	<?php 
			$y=1;
			$R=mysql_query("SELECT tbl_customer_master.shop_name AS SNAME, tbl_customer_master.customer_address AS ADDRESS, tbl_doctor_chemist.dc_id AS ID FROM tbl_doctor_chemist,tbl_customer_master WHERE tbl_doctor_chemist.rep_id=0 AND tbl_doctor_chemist.status=1 AND tbl_doctor_chemist.doctor_id=".$_REQUEST["d_id"]." AND tbl_doctor_chemist.chemist_id=tbl_customer_master.id");
			while($S=mysql_fetch_object($R)){
		?>
    	<tr><td style="text-align:center"><?=$y; ?></td><td><?=$S->SNAME; ?></td><td><?=$S->ADDRESS; ?></td><td style="text-align:center"><a href="doctor_chemist_mapping.php?mode=delete&pin=<?=$_REQUEST["pin"]; ?>&d_id=<?=$_REQUEST["d_id"]; ?>&dc_id=<?=$S->ID; ?>"><img src="img/uploadify-cancel.png" width="10" height="10"></a></td></tr>
        <?php $y++; } ?>
    </tbody>
</table>
</div>
</div>
</div>
<?php } ?>	



<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" /> 
    <input type="reset" class="btn" value="Cancel" />
</div>

</fieldset>
</form>
</div>
</div>
</div>

</div>
</div>

<hr>
      <div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>CHEMIST LIST</h3>
			</div>
			<div class="modal-body">
				<p>
                	<table  class="table table-striped table-bordered bootstrap-datatable datatable">
                    <thead><tr><th>Select</th><th>Chemist Name</th><th>Address</th></tr></thead>
                    <tbody>
					<?php						
						$SQL=mysql_query("SELECT * FROM tbl_customer_master WHERE pin_id=".@$_REQUEST["pin"]." AND id NOT IN (SELECT chemist_id FROM tbl_doctor_chemist WHERE doctor_id = ".$_REQUEST["d_id"]." ) ORDER BY shop_name");
						while($R=mysql_fetch_object($SQL)){
							echo "<tr><td width=\"10%\"><input type=\"checkbox\" name=\"chy[]\" id=\"chy\" value=\"$R->id\"</td><td width=\"40%\">".$R->shop_name."</td><td width=\"50%\">".$R->customer_address."</td></tr>";
						}
					?>
                    </tbody>
                    </table>
                </p>
			</div>
			<div class="modal-footer">            	
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary" id="chemist">Save changes</a>
			</div>
            
            <hr>

		
            
		</div>

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
            $(document).ready(function(){
				$("#chemist").click(function(){
					var d_id=$("#chy").val();
					var favorite = [];
					$.each($("input[name='chy[]']:checked"), function(){            
					favorite.push($(this).val());
					});
					var pin =favorite;
					$.get("autosearch-y/chemist.php?pin="+pin+"",function(data,status){
						$("#show_dis").html(data); 
					});					
				 });
				 $("#show_dis").click(function(){
					$.get("district_show.php?d_id="+d_id+"&&pin="+pin+"&&command=district_show",function(data,status){
						$("#show_dis").html(data); 
					});
				});			 
			});
			function delMe(id){
				//alert(id);				
				$.get("autosearch-y/chemist_del.php?d_id="+id+"",function(data,status){
					$("#show_dis").html(data); 
				});				
			}
        </script>
        
</body>
</html>
<?php
}
?>
