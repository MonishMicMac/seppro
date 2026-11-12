<?php
include("include/connect.php");
// session_start();
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
if(isset($_GET["doctor"])){
	$SQL=mysql_query("SELECT id,doctor_name FROM doctors WHERE doc_pin_id=".$_GET["pin"]."");
	$CNT=mysql_num_rows($SQL);
	if($CNT>0){
		
?>
<h3>ASSIGN REPRESENTATIVE <-> DOCTOR </h3>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
    <tbody>
    <tr>
<?php 
    $y=0;
    while($BABA=mysql_fetch_object($SQL)){
    if($y % 2 == 0){ echo '</tr><tr>'; }
    $y++;
?>        	
    <td><input type="checkbox" name="doctors[]" value="<?=$BABA->id; ?>">&nbsp;&nbsp;<?=$BABA->doctor_name; ?></td>            
<?php } ?>
</tr>
<tr><td colspan="2" style="text-align:right"><a href="#" id="area_assign"><img src="img/man259.png" width="64" height="64"></a></td></tr>
</tbody>        
</table>
<?php
	}
	if($CNT==0){
	
	}
	exit;
}
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
function pin_chy(rep,pin){  	
	window.location.href="rep_areawise_mapping.php?rep="+rep+"&pin="+pin;
  }
  function rep(pin){  	
	window.location.href="rep_areawise_mapping.php?rep="+pin;
  }
</script>
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
<h2><i class="icon-edit"></i>REPRESENTATIVE DAILY REPORT DOCTOR</h2>
<div class="box-icon">
</div>
</div>   
<?php if(@$_REQUEST["rep"]!=""){ ?> 
<div style="float:right;margin-top:5px;margin-right:5px;margin-left:5px">
<div class="control-group">
<div class="controls">
	<a href="#" id="popup1" class="btn btn-success"> ADD NEW AREA</a>
    <a href="#" id="popup2" class="btn btn-inverse"> AREA CORRECTION</a>
</div></div>

<h3>REP <-> ASSIGNED TERITARY</h3>
<table class="table table-striped table-bordered bootstrap-datatable datatable">	
    	<tr><td><strong>Sl.No</strong></td><td><strong>Teritary&lsquo;s</strong></td><td><strong>Pincode&lsquo;s</strong></td></tr>            
    	<tr>        	
            <?php $y=1; $T=mysql_query("SELECT mst_tertiary.tertiary_name AS Name, mst_tertiary.tertiary_id AS TID FROM rep_area,mst_tertiary WHERE rep_area.rep_id=".$_REQUEST["rep"]." AND rep_area.tertiary_id=mst_tertiary.tertiary_id GROUP BY rep_area.tertiary_id"); while($R=mysql_fetch_object($T)){ ?>
            <td style="text-align:center"><?=$y; ?></td>
            <td><?=$R->Name; ?></td>            
            <td><?php $P=mysql_query("SELECT master_pincode.pincode AS PINCODE FROM rep_area,master_pincode WHERE rep_area.rep_id=".$_REQUEST["rep"]." AND rep_area.tertiary_id=".$R->TID." AND rep_area.pin_id=master_pincode.pin_id ORDER BY master_pincode.pincode "); while($PIN=mysql_fetch_object($P)){ @$pinId.=$PIN->PINCODE.", "; } echo substr($pinId,0,-2); ?></td>
            <?php $y++; } ?>            
        </tr>
</table>

<div class="control-group" style="height:auto; width:100px;" id="show_dis"></div>
</div>
<?php } ?>
<div class="box-content">
<form class="form-horizontal" action="?mode=save" enctype="multipart/form-data" method="post"  name="frm" id="frm">
 <input type="hidden" name="command" id="command" value="add_distributed_customer" />
 <fieldset>
 	<div class="control-group"><label class="control-label" for="typeahead">Current Representative<span style="color:#FF0000;">*</span> </label>
     <div class="controls">
	<select name="representative" id="representative" data-rel="chosen" required>
    	<option value="">---Select---</option>
        <?php $P=mysql_query("SELECT * FROM representative WHERE rep_activatedeactivate=0 ORDER BY id"); while($I=mysql_fetch_object($P)){ ?>
        	<option value="<?=$I->id; ?>"><?=$I->rep_name; ?></option>
        <?php } ?>
    </select><script>document.getElementById("representative").value="<?=$_REQUEST["rep"] ?>";</script>
</div>
</div>
<div class="control-group"><label class="control-label" for="typeahead">Report Date Range<span style="color:#FF0000;">*</span> </label>
  <div class="controls">
    <table style="width:100%;">
        <tr>
        <td><Label>From date</label></td>
        <td>:</td>
        <td><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST["from_date"]; ?>"/></td>
        <td><Label>To date</label></td>
        <td>:</td>
        <td><input type="text" name="to_date" id="to_date" readonly value="<?php echo @$_REQUEST["to_date"]; ?>"/></td>
        <td><input type="button" id="rep_report" name="submit" value="REP REPORT" class="btn btn-primary" style="margin-top:-12px" ></td>
        <td></td>
       </tr>
    </table>
  </div>
</div>

<div id="daily_report" style="height:auto"></div>		
		
   
	<script>
		
    	$(document).ready(function(){
			$("#rep_report").click(function(){				
				$.get("autosearch-y/representative.php?daily_report=add&representative1="+$("#representative").val()+"&from_date="+$("#from_date").val()+"&to_date="+$("#to_date").val()+"",function(data,status){										
					$("#daily_report").html(data);
				});
			});	
		});
    </script>
</fieldset>
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
    <script>
    	
    </script>
        
        <script>

/*$("#rep_report").click(function(){
	$.get("autosearch-y/representative.php?doctor=yuvaraj&pin="+$("#representative").val()+"&from_date="+$("#from_date").val()+"&to_date="+$("#to_date").val()+"",function(data,status){					
		$("#doctors").html(data);
		
	});

});*/
		
	
function yuvaraj(){
	var favorite = [];
	$.each($("input[name='doctors[]']:checked"), function(){            
	favorite.push($(this).val());
	});
	var pin =favorite;
	$.get("autosearch-y/representative.php?doctor_assign=yuvaraj&pin="+pin+"&rep_id="+$("#assign_rep").val()+"",function(data,status){					
		//$("#doctors").html(data);
		alert(data);
		
	});
}
</script>
<script>
function yuvi(){
	$("#summary td").click(function(){		
		$.get("autosearch-y/representative.php?daily_cmts=yuvaraj&wp_date="+$(this).closest('tr').find('td:eq(0)').text()+"&representative1="+$("#representative").val()+"",function(data,status){
		$("#y").html(data);		
		});
	});	

}
</script>

</body>
</html>
<?php
}
?>