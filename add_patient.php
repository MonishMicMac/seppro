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
if(@$_REQUEST["mode"]=="save"){

	$SQL=mysql_query("SELECT * FROM pincode_list WHERE pin_id='".$_REQUEST["doc_pincode"]."' AND area_name='".$_REQUEST["dd_user_input5"]."'");
	$R=mysql_fetch_object($SQL);
	
	mysql_query("INSERT INTO  tbl_customer_master(shop_name,customer_name,mobile_no,drug_lincense_no1 	,drug_lincense_no2,customer_address,chemist_latitude,chemist_longtitude,pin_id,pincode,area_id,state_id,district_id,c_date,c_time) VALUES('".$_REQUEST["dis_shop_name"]."','".$_REQUEST["dis_cust_name"]."','".$_REQUEST["dis_cust_no"]."','".$_REQUEST["drug_lic_no1"]."','".$_REQUEST["drug_lic_no2"]."','".$_REQUEST["doc_addr"]."','".$_REQUEST["doc_latitude"]."','".$_REQUEST["doc_longitude"]."','".$_REQUEST["doc_pincode"]."','".$R->pincode."','".$R->id."','".$R->state_id."','".$R->dist_id."','".date("Y-m-d")."','".date("H:i:s")."')");
	$P=mysql_insert_id();
	mysql_query("UPDATE tbl_doctor_chemist SET chemist_id=".$P." WHERE doctor_id>0 AND status=1");
	header("location:add_patient.php");
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

function getcat(title)
{
 var strURL="getInfo1.php?title="+title;
 var req = getXMLHTTP();
 if (req)
 {
     req.onreadystatechange = function()
     {
      if (req.readyState === 4)
      {
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
  ///////////////////////////////////////////////////////////////////////////////
function get_doc(title)
{
var strURL="get_doc.php?command=get_doctor&&pin="+title;
var req = getXMLHTTP();
if (req)
{
    req.onreadystatechange = function()
        {
        if (req.readyState === 4)
        {
            if (req.status === 200)
            {
            document.getElementById('doctor').innerHTML=req.responseText;
            } else {
            alert("There was a problem while using XMLHTTP:\n" + req.statusText);
            }
        }
        }
req.open("GET", strURL, true);
req.send(null);
} 
}
function pin_chy(pin){  	
	window.location.href="add_patient.php?pin="+pin;
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
<h2><i class="icon-edit"></i>Add Patient</h2>
<div class="box-icon">
</div>
</div>   
<?php if(@$_REQUEST["pin"]!=""){ ?> 
<div style="float:right;margin-top:5px;margin-right:80px">
<div class="control-group">
<div class="controls">
<section class="v-center">
 </div>
<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
</div>
<?php } ?>
<div class="box-content">
<form class="form-horizontal" action="patient_store.php" role="form">
<!-- <input type="hidden" name="command" id="command" value="add_distributed_customer" /> -->
 <fieldset>
   
     
<div class="control-group"><label class="control-label" for="typeahead">Patient Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dis_shop_name"   id="dis_shop_name" required onKeyPress="isAlphaNumeric(event)"/>        
</div>
</div>
     
     
<div class="control-group"><label class="control-label" for="typeahead">Contact Person<span style="color:#FF0000;">*</span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dis_cust_name" id="dis_cust_name" required onKeyPress="isAlphaNumeric(event)"/>        
</div>
</div>
  
    
<div class="control-group">
    <label class="control-label" for="typeahead">Mobile No<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="dis_cust_no" id="dis_cust_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10" required/>
    </div>
</div>     


    
<div class="control-group">
    <label class="control-label" for="typeahead">Location<span style="color:#FF0000;">*</span> </label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="location" id="location" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10" required/>
    </div>
</div>  


<div class="control-group">
<label class="control-label" for="typeahead">Health Condition<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="drug_lic_no1" id="drug_lic_no1" required/></div>
</div>

     
<div class="control-group">
<label class="control-label" for="typeahead">Patient Details</label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="drug_lic_no2" id="drug_lic_no2"/></div>
</div>


     
<div class="control-group"><label class="control-label" for="typeahead">Address<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="address" id="address" style="width:270px; height:120px;" required/></div></div>     


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();" /> 
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
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Select Doctors</h3>
                </div>
                <div class="modal-body" style="height:510px;">
                    <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                    <thead><tr><th>Select</th><th>Doctor</th><th>Address</th></tr></thead>
                    <tbody>
					<?php						
						$SQL=mysql_query("SELECT * FROM doctors WHERE doc_pin_id=".@$_REQUEST["pin"]." ORDER BY doctor_name");
						while($R=mysql_fetch_object($SQL)){
							echo "<tr><td width=\"10%\"><input type=\"checkbox\" name=\"chy[]\" id=\"chy\" value=\"$R->id\"</td><td width=\"40%\">".$R->doctor_name."</td><td width=\"50%\">".$R->doctor_addrs."</td></tr>";
						}
					?>
                    </tbody>
                    </table>                    
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal" id="doctors">Add</a>
                </div>
            </div>
        </div>
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
				$("#doctors").click(function(){	 	
					var d_id=$("#chy").val();			
					var favorite = [];
					$.each($("input[name='chy[]']:checked"), function(){            
					favorite.push($(this).val());
					});
					var pin =favorite;
					$.get("autosearch-y/doctors.php?pin="+pin+"",function(data,status){
						$("#show_dis").html(data); 
					});					
			 	});
				$("#other").click(function(){
					$("#other_spe").toggle();
				});
				$("#otherdeg").click(function(){
					$("#other_deg").toggle();
				});
				$("#othercategory").click(function(){
					$("#other_category").toggle();
				});
				$("#otherptype").click(function(){
					$("#other_ptype").toggle();
				});
				$("#otherclass").click(function(){
					$("#other_class").toggle();
				});				 
			});
			function delMe(id){				
				$.get("autosearch-y/doctor_del.php?d_id="+id+"",function(data,status){
					$("#show_dis").html(data); 
				});				
			}
        </script>
        <script>
$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
	window.location.replace("<?=$_SERVER['REQUEST_URI']; ?>");
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();
 
});
</script>
</body>
</html>
<?php
}
?>
