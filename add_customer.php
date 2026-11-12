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
	
	mysql_query("INSERT INTO  tbl_customer_master(shop_name,customer_name,mobile_no,drug_lincense_no1,drug_lincense_no2,customer_address,chemist_latitude,chemist_longtitude,pin_id,pincode,area_id,state_id,district_id,c_date,c_time) VALUES('".$_REQUEST["dis_shop_name"]."','".$_REQUEST["dis_cust_name"]."','".$_REQUEST["dis_cust_no"]."','".$_REQUEST["drug_lic_no1"]."','".$_REQUEST["drug_lic_no2"]."','".$_REQUEST["doc_addr"]."','".$_REQUEST["doc_latitude"]."','".$_REQUEST["doc_longitude"]."','".$_REQUEST["doc_pincode"]."','".$R->pincode."','".$R->id."','".$R->state_id."','".$R->dist_id."','".date("Y-m-d")."','".date("H:i:s")."')");
	$P=mysql_insert_id();
	mysql_query("UPDATE tbl_doctor_chemist SET chemist_id=".$P." WHERE doctor_id>0 AND status=1");
	header("location:add_customer.php");
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
	window.location.href="add_customer.php?pin="+pin;
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
<h2><i class="icon-edit"></i>Add Customer</h2>
<div class="box-icon">
</div>
</div>   
<?php if(@$_REQUEST["pin"]!=""){ ?> 
<div style="float:right;margin-top:5px;margin-right:80px">
<div class="control-group">
<div class="controls">
<section class="v-center">
  <div>
   <a href="#" class="btn btn-info btn-setting">SELECT DOCTORS</a>&nbsp;&nbsp; <a class="js-open-modal btn btn-success" href="#" data-modal-id="popup1"> ADD NEW DOCTORS</a></div>
</section>
</div></div>
<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
</div>
<?php } ?>
<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
<input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
  <div class="control-group"><label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;"></span> </label>
  <div class="controls">
  <input class="input-xlarge focused"  type="text" name="pincode" id="pincode"  maxlength="6"  onKeyPress="isAlphaNumeric(event)"/> 
</div></div>
     
<div class="control-group"><label class="control-label" for="typeahead">Shop Name<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dis_shop_name" id="dis_shop_name"  onKeyPress="isAlphaNumeric(event)"/>        
</div>
</div>
     
     
<div class="control-group"><label class="control-label" for="typeahead">Customer Name<span style="color:#FF0000;"></span> </label>
<div class="controls">
    <input class="input-xlarge focused"  type="text" name="dis_cust_name" id="dis_cust_name"  onKeyPress="isAlphaNumeric(event)"/>        
</div>
</div>
  
    
<div class="control-group">
    <label class="control-label" for="typeahead">Mobile No<span style="color:#FF0000;"></span> </label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="dis_cust_no" id="dis_cust_no" onKeyPress="return onlyNumbers(event)" onBlur="check_count1(this.value,this.id);" maxlength="10" />
    </div>
</div>     

<div class="control-group">
<label class="control-label" for="typeahead">Drug License No 1<span style="color:#FF0000;"></span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="drug_lic_no1" id="drug_lic_no1" /></div>
</div>

     
<div class="control-group">
<label class="control-label" for="typeahead">Drug License No 2 </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="drug_lic_no2" id="drug_lic_no2"/></div>
</div>

<div class="control-group"><label class="control-label" for="typeahead">Location<span style="color:#FF0000;"></span> </label>
<div class="controls">
<div id="map_canvas" style="width:400px;height:200px;border:solid black 1px;"></div><br/>
<div>
    <input type="hidden" id="address" name="doc_addr" placeholder="Address"/>
    <input type="hidden" id="latitude" name="doc_latitude" placeholder="Latitude"/>
    <input type="hidden" id="longitude" name="doc_longitude" placeholder="Longitude"/>
</div>
</div>

     
<div class="control-group"><label class="control-label" for="typeahead">Address<span style="color:#FF0000;"></span> </label>
<div class="controls"><input class="input-xlarge focused"  type="text" name="address" id="address" style="width:270px; height:160px;" /></div></div>     


<!-- <div class="control-group"><label class="control-label" for="typeahead">Area Name</label>
<div class="controls">
	<input id="dd_user_input5" type="text" name="dd_user_input5" class="search_form" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" <?php if(@$_REQUEST["area"]!=""){ ?>value="<?php echo @$_REQUEST["area"]; ?>"<?php }else{ ?>value="Type your Input Here" <?php } ?>/>
 <input type="button"  class="btn btn-primary" name="composition_prescribing_add" id="area_id" value="Add"/>
</div></div>  -->

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
<div id="popup1" class="modal-box">
  <header> <a href="#" class="js-modal-close close">×</a>
    <h3>ADD NEW DOCTOR</h3>
  </header>
  <div class="modal-body" id="map">
    <p>
<table width="100%" cellpadding="5" cellspacing="2">
	<tr>
    	<td>Pincode <span style="color:#FF0000;">*</span></td>
        <td>        	
            <select name="che_pincode" id="che_pincode" data-rel="chosen">
                <option value="">---Select---</option>
                <?php $P=mysql_query("SELECT * FROM master_pincode"); while($I=mysql_fetch_object($P)){ ?>
                    <option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
                <?php } ?>
            </select>                
        </td>
    </tr>
    <tr><td>Doctor Name <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="doctor_name" id="doctor_name"/></td></tr>
    <tr>
    	<td>Qualification <span style="color:#FF0000;">*</span></td>
    	<td>
        	<select  id="qualification" name="qualification" data-rel="chosen">
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
</select> <a id="otherdeg">others.....</a> 
        </td>
    </tr>
    <tr style="display:none;" id="other_deg"><td>if other Qualification here <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="other_specialist" id="other_specialist" /></td></tr>
    <tr>
    	<td>Gender <span style="color:#FF0000;">*</span></td>
        <td>        	
           <label class="radio">
               <input type="radio" name="doc_gender" id="gender" value="M" checked>
               Male 
           </label>
           <label class="radio">
               <input type="radio" name="doc_gender" id="gender" value="F"> 
               Female
           </label>
        </td>
    </tr>
    <tr>
    	<td>Specialist <span style="color:#FF0000;">*</span></td>
    	<td>
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
            </select> <a id="other">others.....</a>
        </td>
    </tr>
    <tr style="display:none;" id="other_spe"><td>if other specify here <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="other_specialist" id="other_specialist" /></td></tr>
    <tr>
    	<td>Category <span style="color:#FF0000;">*</span></td>
    	<td>
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
            </select> <a id="othercategory">others.....</a>
        </td>
    </tr>
    <tr style="display:none;" id="other_category"><td>if other Category here <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="other_category" id="other_category" /></td></tr>
    <tr>
    	<td>Classification <span style="color:#FF0000;">*</span></td>
    	<td>
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
            </select> <a id="otherclass">others.....</a>
        </td>
    </tr>
    <tr style="display:none;" id="other_class"><td>if other Classification here <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="other_class" id="other_class" /></td></tr>
    <tr><td>Registered No <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="dr_reg" id="dr_reg"/></td></tr>
    <tr><td>Mobile No <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="dr_cno" id="dr_cno"/></td></tr>
    <tr><td>Email Id <span style="color:#FF0000;">*</span></td><td><input class="input-xlarge focused"  type="text" name="dr_email" id="dr_email"/></td></tr>    
    <tr>
    	<td>Total No of Years Experience <span style="color:#FF0000;">*</span></td>
    	<td>
        <select name="doc_yr_practice" id="doc_yr_practice" data-rel="chosen">
            <option value="">---Select---</option>
            <?php for($i=1;$i<50;$i++){ ?>
                <option value="<?=$i; ?>"><?=$i; ?></option>
            <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
    	<td>Years of Practice in this Location <span style="color:#FF0000;">*</span></td>
    	<td>
        <select name="doc_practice_loc" id="doc_practice_loc" data-rel="chosen" >
            <option value="">---Select---</option>
            <?php for($i=1;$i<50;$i++){ ?>
                <option value="<?=$i; ?>"><?=$i; ?></option>
            <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
    	<td>No of Patients Per Day <span style="color:#FF0000;">*</span></td>
    	<td>
        <select name="doc_practice_pday" id="doc_practice_pday" data-rel="chosen" >
            <option value="">---Select---</option>
            <?php for($i=1;$i<100;$i++){ ?>
                <option value="<?=$i; ?>"><?=$i; ?></option>
            <?php } ?>
        </select>
        </td>
    </tr>
    <tr>
    	<td>Day Specific <span style="color:#FF0000;">*</span></td>
    	<td>
        <?php
			$day = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
			foreach($day as $D){
				echo "<input type='checkbox' class=\"input-xlarge disabled checkbox\" id='doc_specific[]'  name='doc_specific[]' value='$D'> ".$D." &nbsp;";
			}
		?>
        </td>
    </tr>
    <script>
    	function initialize1() 
		{
			// Set static latitude, longitude value
			var latlng = new google.maps.LatLng(13.053085074428376,80.21314787274173);
			
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
        	<input type="hidden" id="address1" placeholder="Address"/>
            <input type="hidden" id="latitude1" placeholder="Latitude"/>
            <input type="hidden" id="longitude1" placeholder="Longitude"/><br>
			<div id="map_canvas1" style="width:400px;height:200px;"></div>
        </div>            
        </td>
    </tr>
    <tr><td colspan="2"><img src="img/button_plus_blue.png" width="48" height="48" id="addChemist"></td></tr>
    <script>
    	$(document).ready(function(){
			$("#addChemist").click(function(){
			//alert($("#doc_specific").val());
			var checkValues = $('input[name="doc_specific[]"]:checked').map(function()
			{ return $(this).val();	}).get();			
			
				$.get("autosearch-y/rcpa.php?chemist_doctor=add&che_pincode="+$("#che_pincode").val()+"&doctor_name="+$("#doctor_name").val()+"&qualification="+$("#qualification").val()+"&other_qua="+$("#other_qua").val()+"&gender="+$("#gender").val()+"&specilist="+$("#specilist").val()+"&other_specialist="+$("#other_specialist").val()+"&doc_category="+$("#doc_category").val()+"&other_category="+$("#other_category").val()+"&doc_classification="+$("#doc_classification").val()+"&other_class="+$("#other_class").val()+"&dr_reg="+$("#dr_reg").val()+"&dr_cno="+$("#dr_cno").val()+"&dr_email="+$("#dr_email").val()+"&doc_yr_practice="+$("#doc_yr_practice").val()+"&doc_practice_loc="+$("#doc_practice_loc").val()+"&doc_practice_pday="+$("#doc_practice_pday").val()+"&doc_specific="+checkValues+"&address1="+$("#address1").val()+"&latitude1="+$("#latitude1").val()+"&longitude1="+$("#longitude1").val()+"",function(data,status){
					alert(data); 
				});
			});
		});
    </script>
</table>
    </p>
  </div>

</div>   


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
