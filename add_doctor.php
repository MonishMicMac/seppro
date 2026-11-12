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
<!-- email Validation-->
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
function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true; }

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
  function pin_chy(pin){
  	//$.post("autosearch-y/chemist.php?pin="+pin+"", function(data){$("#CHY").load("autosearch-y/chemist.php");});
  	//alert(pin);
	//$.post("add_doctor.php #CHY?pin="+pin+"", function(data){});
	window.location.href="add_doctor.php?pin="+pin;
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
<h2><i class="icon-edit"></i>Add Doctor</h2>
<div class="box-icon">
</div>
</div>
<div style="float:right;margin-top:5px;margin-right:80px">
<div class="control-group">
<div class="controls">
<section class="v-center">
  <div>
   <a href="doctor_import.php" class="btn btn-primary" target="_blank">Doctor Import</a>&nbsp;&nbsp; <a href="#" class="btn btn-info btn-setting">Select Chemist</a>&nbsp;&nbsp; <a class="js-open-modal btn btn-success" href="#" data-modal-id="popup1"> ADD NEW CHEMIST</a></div>
</section>
</div></div>
<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_doctor" />
 <fieldset>

<div class="control-group"><label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;"></span> </label>
<div class="controls">
	<select name="doc_pincode" id="doc_pincode" data-rel="chosen"  onChange="pin_chy(this.value);">
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM master_pincode ORDER BY pincode"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
        <?php } ?>
    </select><script>document.getElementById("doc_pincode").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_pin_id;} if(@$_REQUEST["DID"]==""){echo $_REQUEST["pin"];} ?>";</script>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">Doctor's Name<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="doc_name" id="doc_name" ="" value="<?=$R->doctor_name; ?>"/>        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">DOB<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dob" id="dob" ="" value="<?=$R->dob; ?>"/>        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Anniversary<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="anniversary" id="anniversary" value="<?=$R->anniversary; ?>"/>        
</div>
</div>

<div class="control-group"> 
    <label class="control-label" for="typeahead">Gender<span style="color:#FF0000;"></span></label>
    <div class="controls"> 
       <label class="radio">
           <input type="radio" name="doc_gender" id="add" value="M" checked>
           Male 
       </label>
       <label class="radio">
           <input type="radio" name="doc_gender" id="add2" value="F"> 
           Female
       </label>       
    </div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Specialist<span style="color:#FF0000;"></span> </label>
<div class="controls">
<select  id="specilist" name="specilist" data-rel="chosen">
    <option value="">---Select---</option>
<?php
$spe=mysql_query("select * from specilist_list")or die(mysql_error());
$count_spe=mysql_num_rows($spe);
if($count_spe > 0)
{
while($row_spe=mysql_fetch_array($spe))
{ ?>
<option value="<?=$row_spe['id']?>"><?=$row_spe['specilist_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No specialist added</option>
<?php }
?>
</select><script>document.getElementById("specilist").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_specilist_id;} ?>";</script> <a id="other">others.....</a>   
</div>
</div>

<div class="control-group" style="display:none;" id="other_spe">
    <label class="control-label" for="typeahead">if other specify here<span style="color:#FF0000;"></span></label>
<div class="controls">
<input class="input-xlarge focused"  type="text" name="other_specialist" id="other_specialist" />        
</div>
</div>


<div class="control-group"><label class="control-label" for="typeahead">Qualification<span style="color:#FF0000;"></span> </label>
<div class="controls">
<select  id="qualification" name="qualification" data-rel="chosen" >
    <option value="">---Select---</option>
<?php
$spe=mysql_query("select * from mst_doctor_degree")or die(mysql_error());
$count_spe=mysql_num_rows($spe);
if($count_spe > 0)
{
while($row_spe=mysql_fetch_array($spe))
{ ?>
<option value="<?=$row_spe['deg_id']?>"><?=$row_spe['deg_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No Degree added</option>
<?php }
?>
</select><script>document.getElementById("qualification").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_qualification;} ?>";</script> <a id="otherdeg">others.....</a>   
</div>
</div>

<div class="control-group" style="display:none;" id="other_deg">
    <label class="control-label" for="typeahead">if other Degree here<span style="color:#FF0000;"></span></label>
<div class="controls">
<input class="input-xlarge focused"  type="text" name="other_degree" id="other_degree" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Doctor Register no </label>
<div class="controls"><input class="input-xlarge disabled"  type="text"  name="doc_reg_no" id="doc_reg_no" value="<?=$R->doc_regis_no; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Category<span style="color:#FF0000;"></span> </label>
<div class="controls">
<select  id="doc_category" name="doc_category" data-rel="chosen">
    <option value="">---Select---</option>
<?php
$spe=mysql_query("select * from mst_category")or die(mysql_error());
$count_spe=mysql_num_rows($spe);
if($count_spe > 0)
{
while($row_spe=mysql_fetch_array($spe))
{ ?>
<option value="<?=$row_spe['category_id']?>"><?=$row_spe['category_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No Category added</option>
<?php }
?>
</select><script>document.getElementById("doc_category").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_category;} ?>";</script> <a id="othercategory">others.....</a>   
</div>
</div>

<div class="control-group" style="display:none;" id="other_category">
    <label class="control-label" for="typeahead">if other Category here<span style="color:#FF0000;"></span></label>
<div class="controls">
<input class="input-xlarge focused"  type="text" name="other_category" id="other_category" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Patient Type<span style="color:#FF0000;"></span> </label>
<div class="controls">
<input id="dd_user_input" type="text" name="doc_patient_type" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["patient_type"]!=""){ ?>value="<?php echo @$_REQUEST["patient_type"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/> <input type="button"  class="btn btn-primary" name="pt_add" id="pt_add" value="Add"/>   
</div>
</div>
<div class="control-group" style="height:auto;margin-left:220px;" id="show_pt"></div>

<div class="control-group" style="display:none;" id="other_ptype">
    <label class="control-label" for="typeahead">if other Patient Type here<span style="color:#FF0000;"></span></label>
<div class="controls">
<input class="input-xlarge focused"  type="text" name="other_ptype" id="other_ptype" />        
</div>
</div>


<div class="control-group"><label class="control-label" for="typeahead">Classification<span style="color:#FF0000;"></span> </label>
<div class="controls">

<select  id="doc_classification" name="doc_classification" data-rel="chosen">
    <option value="">---Select---</option>
<?php
$spe=mysql_query("select * from mst_classification")or die(mysql_error());
$count_spe=mysql_num_rows($spe);
if($count_spe > 0)
{
while($row_spe=mysql_fetch_array($spe))
{ ?>
<option value="<?=$row_spe['classification_id']?>"><?=$row_spe['classification_name'];?></option>           
<?php  }
}  
else 
{ ?>
<option value="">No Classification Name added</option>
<?php }
?>
</select><script>document.getElementById("doc_classification").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_classification;} ?>";</script> <a id="otherclass">others.....</a>   
</div>
</div>

<div class="control-group" style="display:none;" id="other_class">
    <label class="control-label" for="typeahead">if other Classification Type here<span style="color:#FF0000;"></span></label>
<div class="controls">
<input class="input-xlarge focused"  type="text" name="other_class" id="other_class" />        
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Total No of Years Experience<span style="color:#FF0000;"></span> </label>
<div class="controls">	
    <select name="doc_yr_practice" id="doc_yr_practice" data-rel="chosen" >
    	<option value="">---Select---</option>
        <?php for($i=1;$i<50;$i++){ ?>
        	<option value="<?=$i; ?>"><?=$i; ?></option>
        <?php } ?>
    </select>
    <script>document.getElementById("doc_yr_practice").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_yr_practice;} ?>";</script>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">How many years the Doctor in this Location<span style="color:#FF0000;"></span> </label>
<div class="controls">
<select name="doc_practice_loc" id="doc_practice_loc" data-rel="chosen" >
    	<option value="">---Select---</option>
        <?php for($i=1;$i<50;$i++){ ?>
        	<option value="<?=$i; ?>"><?=$i; ?></option>
        <?php } ?>
    </select>
    <script>document.getElementById("doc_practice_loc").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_practice_loc;} ?>";</script>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">No of Patients Per Day<span style="color:#FF0000;"></span> </label>
<div class="controls">	
    <select name="doc_practice_pday" id="doc_practice_pday" data-rel="chosen" >
    	<option value="">---Select---</option>
        <?php for($i=1;$i<100;$i++){ ?>
        	<option value="<?=$i; ?>"><?=$i; ?></option>
        <?php } ?>
    </select>
    <script>document.getElementById("doc_practice_pday").value="<?php if(@$_REQUEST["DID"]!=""){echo $R->doc_practice_pday;} ?>";</script>
</div></div>


<div class="control-group"><label class="control-label" for="typeahead">Enter Doctor availability day for Rep<span style="color:#FF0000;"></span> </label>
<div class="controls">
<?php
	$day = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	foreach($day as $D){
		echo "<input type='checkbox' class=\"input-xlarge disabled\"  name='doc_specific[]' value='$D'> ".$D." &nbsp;";
	}
?>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">Enter Doctor availability time for Rep<span style="color:#FF0000;"></span> </label>
<div class="controls">
 <label class="radio"><input type="radio" name="dr_time" value="9 AM To 2 PM"> 9 AM To 2 PM</label>&nbsp;&nbsp; <label class="radio"><input type="radio" name="dr_time" value="2 PM To 10 PM"> 2 PM To 10 PM</label>
</div></div>

<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $cus_next; ?>" />
<div class="control-group"><label class="control-label" for="typeahead">Location<span style="color:#FF0000;"></span> </label>
<div class="controls">
<div id="map_canvas" style="width:400px;height:200px;border:solid black 1px;"></div><br/>
<div>
    <input type="text" id="address" name="doc_addr" placeholder="Address" value="<?=$R->doc_loc_address; ?>"/>
    <input type="text" id="latitude" name="doc_latitude" placeholder="Latitude" value="<?=$R->dr_latitude; ?>"/>
    <input type="text" id="longitude" name="doc_longitude" placeholder="Longitude" value="<?=$R->dr_longitude; ?>"/>
</div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Doctor Address<span style="color:#FF0000;"></span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="doc_address" id="doc_addr" style="width:270px; height:160px;" value="<?=$R->doctor_addrs; ?>" /></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Area Name</label>
<div class="controls">
	<input id="dd_user_input5" type="text" name="dd_user_input5" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["area"]!=""){ ?>value="<?php echo @$_REQUEST["area"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
 <input type="button"  class="btn btn-primary" name="composition_prescribing_add" id="area_id" value="Add"/>
</div></div>

<div class="control-group"><label class="control-label" for="typeahead">Contact No<span style="color:#FF0000;"></span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="doc_cont_no" id="doc_cont_no" onKeyPress="return onlyNumbers(event)" maxlength="10"  value="<?=$R->doc_contact_no; ?>"/></div></div>

<div class="control-group"><label class="control-label" for="typeahead">Email Id<span style="color:#FF0000;"></span></label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="doc_email" id="doc_email" onBlur="valid_email(this.value,this.id);"  value="<?=$R->email; ?>"/></div></div>

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

<div id="popup1" class="modal-box">
  <header> <a href="#" class="js-modal-close close">×</a>
    <h3>ADD NEW CHEMIST</h3>
  </header>
  <div class="modal-body" id="map">
    <p>
<table width="100%" cellpadding="5" cellspacing="2">
	<tr>
    	<td>Pincode <span style="color:#FF0000;">*</span></td>
        <td>
        	<select name="che_pincode" id="che_pincode">
                <option value="">---Select---</option>
                <?php $P=mysql_query("SELECT * FROM master_pincode"); while($I=mysql_fetch_object($P)){ ?>
                    <option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr><td>Shop Name <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="shop_name" id="shop_name"/></td></tr>
    <tr><td>Customer Name <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="customer_name" id="customer_name"/></td></tr>
    <tr><td>Mobile No <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="chemist_cno" id="chemist_cno"/></td></tr>
    <tr><td>Drug License No 1 <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="chemist_drug" id="chemist_drug"/></td></tr>
    <tr><td>Drug License No 2 <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="chemist_drug1" id="chemist_drug1"/></td></tr>
    <script>
    	function initialize1() 
		{
					
			var latlng = new google.maps.LatLng(<?php if(@$_REQUEST["DID"]!=""){ echo $R->dr_latitude; }if(@$_REQUEST["DID"]==""){echo "13.053085074428376";} ?>,<?php if(@$_REQUEST["DID"]!=""){ echo $R->dr_longitude; }if(@$_REQUEST["DID"]==""){echo "80.21314787274173";} ?>);
			
			var geocoder = new google.maps.Geocoder();
			
			var infowindow = new google.maps.InfoWindow();
			// Set map options
			var myOptions = {
				zoom: 14,
				center: latlng,
				panControl: true,
				zoomControl: true,
				scaleControl: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
			// Create map object with options
			map = new google.maps.Map(document.getElementById("map_canvas1"), myOptions);
			// Create and set the marker
			marker = new google.maps.Marker({
				map: map,
				draggable:true,	
				position: latlng
			});
			
			geocoder.geocode({'latLng': latlng }, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						document.getElementById('address1').value=results[0].formatted_address;
						infowindow.setContent(results[0].formatted_address);
						infowindow.open(map, marker);
					}
				}
			});
			
			
			// Register Custom "dragend" Event
			google.maps.event.addListener(marker, 'dragend', function() {
																	  
				 geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								if (results[0]) {
								   document.getElementById('address1').value=results[0].formatted_address;
									infowindow.setContent(results[0].formatted_address);
									infowindow.open(map, marker);
								}
							}
						});													  
				
				// Get the Current position, where the pointer was dropped
				var point = marker.getPosition();
				// Center the map at given point
				map.panTo(point);
				// Update the textbox
				document.getElementById('latitude1').value=point.lat();
				document.getElementById('longitude1').value=point.lng();
			});
		}
    </script>
    <tr>
    	<td valign="top">Location <span style="color:#FF0000;">*</span></td>
        <td>
        	<div>
            <img src="img/show_map.png" width="32" height="32" alt="" onClick="javascript:initialize1();">
        	<input type="text" id="address1" placeholder="Address"/>
            <input type="text" id="latitude1" placeholder="Latitude"/>
            <input type="text" id="longitude1" placeholder="Longitude"/><br>
			<div id="map_canvas1" style="width:400px;height:200px;"></div>
        </div>            
        </td>
    </tr>
    <tr><td colspan="2"><img src="img/button_plus_blue.png" width="48" height="48" id="addChemist"></td></tr>
</table>
    </p>
  </div>

</div>

<div class="control-group"><label class="control-label" for="typeahead">Any other Practice Location<span style="color:#FF0000;"></span> </label>
<div class="controls"><a href="#" id="past_details"><span style="color:#FF0000;">Click Here</span></a></div></div>

<div class="control-group" style="display:none" id="past_hc"><label class="control-label" for="typeahead">Another Hospital / Clinic<span style="color:#FF0000;">*</span> </label>
<div class="controls"><span style="color:#FF0000;"><input class="input-xlarge disabled"  type="text"  name="doc_past_hc" id="doc_past_hc"/></span>
</div></div>

<div class="control-group" style="display:none" id="past_yr"><label class="control-label" for="typeahead">How many years the Doctor in this Location<span style="color:#FF0000;">*</span> </label>
<div class="controls">	
        <select name="doc_past_yr" id="doc_past_yr" data-rel="chosen">
            <option value="">---Select---</option>
            <?php for($i=1;$i<50;$i++){ ?>
                <option value="<?=$i; ?>"><?=$i; ?></option>
            <?php } ?>
        </select>
</div></div>

<div class="control-group" style="display:none" id="past_loc"><label class="control-label" for="typeahead">Another Location<span style="color:#FF0000;">*</span> </label>
<div class="controls"><span style="color:#FF0000;"><input class="input-xlarge disabled"  type="text"  name="doc_past_loc" id="doc_past_loc"/></span>
</div></div>

<div class="control-group" style="display:none" id="past_pincode"><label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
<div class="controls">
	<select name="doc_past_pincode" id="doc_past_pincode" data-rel="chosen">
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM master_pincode"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
        <?php } ?>
    </select><script>document.getElementById("doc_past_pincode").value="<?=$_REQUEST["pin"] ?>";</script>
</div></div>

<div class="control-group" style="display:none" id="past_address"><label class="control-label" for="typeahead">Address<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="doc_past_address" id="doc_past_address" style="width:270px; height:160px;"/>&nbsp;&nbsp;<img src="img/button_plus_blue.png" width="48" height="48" id="Past"></div></div>

<div class="control-group" style="height:auto;" id="show_past"></div>

<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" /> 
    <input type="reset" class="btn" value="Cancel" />
</div>

</fieldset></form></div></div></div>
<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
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
						$SQL=mysql_query("SELECT * FROM tbl_customer_master WHERE pin_id=".@$_REQUEST["pin"]." ORDER BY shop_name");
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
        <script type="text/javascript">
            $(document).ready(function(){
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
			
			$("#past_details").click(function(){
			$("#past_hc").toggle();
            	$("#past_yr").toggle();
				$("#past_loc").toggle();
				$("#past_pincode").toggle();
				$("#past_address").toggle();
            });
			$("#Past").click(function(){
				$.get("autosearch-y/pastdoctor.php?pastyr="+$("#doc_past_yr").val()+"&pastloc="+$("#doc_past_loc").val()+"&pastpincode="+$("#doc_past_pincode").val()+"&pastaddr="+$("#doc_past_address").val()+"",function(data,status){
					$("#show_past").html(data); 
				});	
			});
			$("#addChemist").click(function(){
				
            	$.get("autosearch-y/addchemist.php?pin="+$("#che_pincode").val()+"&sname="+$("#shop_name").val()+"&cname="+$("#customer_name").val()+"&cno="+$("#chemist_cno").val()+"&drug="+$("#chemist_drug").val()+"&drug1="+$("#chemist_drug1").val()+"&address1="+$("#address1").val()+"&latitude1="+$("#latitude1").val()+"&longitude1="+$("#longitude1").val()+"",function(data,status){
					alert(data);
					//$("#show_dis").html(data); 
				});	
            });
			 $("#chemist").click(function(){
			 	//alert($("#chy").val());
				var d_id=$("#chy").val();
			//var pin=$("#area_id").val();
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
			 $("#myModal").click(function(){
					$('#myModal').triggerevent(function(){
						$('#myModal').html(newContent);
					});
				});		
            });
			function delMe(id){				
				$.get("autosearch-y/chemist_del.php?d_id="+id+"",function(data,status){
					$("#show_dis").html(data); 
				});				
			}
			function Address(id){
				
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
$(function(){ 
	$( "#anniversary" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "2015:2025",
		dateFormat:"dd/mm/yy"
	});
	$( "#dob" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "1980:2025",
		dateFormat:"dd/mm/yy"
	});
 });
</script>	
		
</body>
</html>
<?php
}
?>
