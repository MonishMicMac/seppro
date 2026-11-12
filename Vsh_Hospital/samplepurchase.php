<?php
$GLOBALS["jvNUZuArDlDbVsDKKNjT"]=base64_decode("c3RhdHVz");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["QKxcDWrwBriuUnsPPVFt"]=base64_decode("PHNjcmlwdCB0eXBlPXRleHQvamF2YXNjcmlwdD53aW5kb3cubG9jYXRpb249Jy4uL2luZGV4LnBocD9lcnInOzwvc2NyaXB0Pg==");$GLOBALS["goixdYVcLnjFkAOIxAIX"]=base64_decode("L2luY2x1ZGUvY29ubmVjdC5waHA=");$GLOBALS["PBLWvAuEsHHzJxJcoBaP"]=base64_decode("aW5jbHVkZS9oZWFkZXIucGhw");$GLOBALS["nGqCsGeEOPjkIDijGU"]=base64_decode("aW5jbHVkZS9tZW51LnBocA==");$GLOBALS["yPZDSSMKXmMCZcdoGfbh"]=base64_decode("WS1tLWQ=");$GLOBALS["CGbFgRIFcNnyLvvmfknU"]=base64_decode("Jw==");$GLOBALS["nGfyCWzXCLYUOMRokbZA"]=base64_decode("c2VsZWN0ICogZnJvbSBwYXRpZW50IHdoZXJlIGlkPSc=");$GLOBALS["TtOzRJzXQSQxdUXTMjZM"]=base64_decode("cGF0aWVudF9uYW1l");$GLOBALS["rHQcROtjtGwxmEfsumaI"]=base64_decode("Y29udGFjdG5vMQ==");$GLOBALS["pUAXzMjNDFzrvDHDKFnZ"]=base64_decode("Y29udGFjdG5vMg==");$GLOBALS["pSyDfVIvynENrUJiURmk"]=base64_decode("YWRkcmVzcw==");$GLOBALS["EjGTruiCURmZwZocXuMH"]=base64_decode("YXJlYW5hbWU=");$GLOBALS["WKBChtIeVLMffdOLPBQn"]=base64_decode("Y2l0eQ==");
?><?php include($GLOBALS["goixdYVcLnjFkAOIxAIX"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $SKNmHYRkePqZGoJevRCh=$_SESSION[$GLOBALS["jvNUZuArDlDbVsDKKNjT"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])) { echo $GLOBALS["QKxcDWrwBriuUnsPPVFt"]; } else { $azxKcbCEHCWoNMWQxZas=rand(1000000,9999999); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Sample Purchase Entry -  Buy Online Prescription Drugs and  Pharmacy list</title>
<meta name="description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/css/font-awesome.min.css" />

		<style type="text/css">
@font-face {
font-family: 'Open Sans';
font-style: normal;
font-weight: 300;
src: local('Open Sans Light'), local('OpenSans-Light'), url(font_1.woff) format('woff');
}
@font-face {
font-family: 'Open Sans';
font-style: normal;
font-weight: 400;
src: local('Open Sans'), local('OpenSans'), url(font_2.woff) format('woff');
}
</style>
<link rel="stylesheet" href="assets/css/ace.min.css" />
<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
<script src="assets/js/ace-extra.min.js"></script>
<script type="text/javascript">
window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>
<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
<!--****************************************autocomplete**********-->
	<script type="text/javascript" src="jquery/js/jquery-ui-1.8.2.custom.min.js"></script> 
	<script type="text/javascript"> 
 
		jQuery(document).ready(function(){
		
		
			$('#pro_name').autocomplete({source:'get_medicine.php', minLength:1});
		});
 
	</script> 
	<link rel="stylesheet" href="jquery/css/smoothness/jquery-ui-1.8.2.custom.css" /> 
	<style type="text/css"><!--
	
	        /* style the auto-complete response */
	        li.ui-menu-item { font-size:12px !important; }
				
	--></style> 
<!--***************************************-->
<script type="text/javascript">
function onlyNumbers(event) {
var e = event || evt; // for trans-browser compatibility
var charCode = e.which || e.keyCode;
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
return true; }

</script>
<!--<!**********************************getsvale**************************-->
<script language="JavaScript" type="text/javascript">
 var xmlHttp
function getssts()
{
//alert("12345");
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url1=document.getElementById("pro_name").value;
var str1=encodeURIComponent(url1);
var str2=document.getElementById("quantity").value;
var str3=document.getElementById("rand_no").value;
var str4=0;
var str5=document.getElementById("pat_id").value;
if (url1==null || url1=='')
{
alert ("Please Enter Product Name")
return
}
if (str2==null || str2=='')
{
alert ("Please Enter Quantity")
return
}
 var url="get_cart1.php";
 url=url+"?pro_name="+str1+"&quantity="+str2+"&rand_no="+str3+"&pharm_id="+str4+"&pat_id="+str5;
 url=url+"&sid="+Math.random();
 xmlHttp.onreadystatechange=stateChanged;
 xmlHttp.open("GET",url,true);
 xmlHttp.send(null);
}

function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	 document.getElementById("pro_name").value='';
	 document.getElementById("quantity").value='';
	 document.getElementById("orderlist").innerHTML=xmlHttp.responseText;
	
  } 
}  





function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
</script>
<script language="JavaScript" type="text/javascript">
 var xmlHttp
function get_delete(str1)
{
var str2=document.getElementById("rand_no").value;
var str3=document.getElementById("pat_id").value;
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
  
  
 var url="get_delete.php";
 url=url+"?tab_id="+str1+"&rand_no="+str2+"&pat_id="+str3;
// alert(url);
 url=url+"&sid="+Math.random();
 xmlHttp.onreadystatechange=stateChanged1;
 xmlHttp.open("GET",url,true);
 xmlHttp.send(null);
}

function stateChanged1() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	
	
	var r=confirm('Are you sure want to delete!');
if(r==true)
{
 document.getElementById("orderlist").innerHTML=xmlHttp.responseText;
}
else
{
//return false;
}
	 //document.getElementById("orderlist").innerHTML=xmlHttp.responseText;
	
  } 
}  
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}


</script>

<!--*************************************************************************-->
</head>
<body>
<div class="navbar navbar-default" id="navbar">
<script type="text/javascript">
try{ace.settings.check('navbar' , 'fixed')}catch(e){}
</script> <?php include($GLOBALS["PBLWvAuEsHHzJxJcoBaP"]); ?>
<!-- /.container -->
</div>

<div class="main-container" id="main-container">
<script type="text/javascript">
try{ace.settings.check('main-container' , 'fixed')}catch(e){}
</script>

<div class="main-container-inner">
<a class="menu-toggler" id="menu-toggler" href="#">
<span class="menu-text"></span>
</a>

<div class="sidebar" id="sidebar">
<script type="text/javascript">
try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
</script> <?php include($GLOBALS["nGqCsGeEOPjkIDijGU"]); ?><!-- #sidebar-shortcuts -->
<div class="sidebar-collapse" id="sidebar-collapse">
<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
</div>

<script type="text/javascript">
try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
</script>
</div>

<div class="main-content">
<div class="breadcrumbs" id="breadcrumbs">
<script type="text/javascript">
try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
</script>
</div>

<div class="page-content">
<div class="row">
<div class="col-xs-12">
<!-- PAGE CONTENT BEGINS -->
<div class="space-6"></div>
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="widget-box transparent invoice-box">
<div class="widget-header widget-header-large">
<h3 class="grey lighter pull-left position-relative">
<i class="icon-leaf green"></i>
Patient Order Details
</h3>
<div class="widget-toolbar no-border invoice-info">
<span class="invoice-info-label"></span>
<span class="red"></span>
<br />
<span class="invoice-info-label"></span>
<span class="blue"></span>
</div>

<div class="widget-toolbar no-border invoice-info">
													<span class="invoice-info-label">Invoice:</span>
													<span class="red">#<?php echo $azxKcbCEHCWoNMWQxZas; ?></span>

													<br />
													<span class="invoice-info-label">Date:</span>
													<span class="blue"><?php echo date($GLOBALS["yPZDSSMKXmMCZcdoGfbh"]); ?> </span>												</div>
</div>

<div class="widget-body">
<div class="widget-main padding-24">
<div class="row">
<div class="col-sm-6"  style="width: 100%;">
<div class="row">
	<div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
		<b>Patient Info</b>
	</div>
</div> <?php $VPXESCfscBEJIQTLGbnn=mysql_query($GLOBALS["nGfyCWzXCLYUOMRokbZA"].$id.$GLOBALS["CGbFgRIFcNnyLvvmfknU"]); $sYWGFnfCrijzOYJeNbNw=mysql_fetch_array($VPXESCfscBEJIQTLGbnn); ?>

<div class="row">
	<ul class="list-unstyled spaced">
		<li>
			<i class="icon-caret-right blue"></i>
		Patient Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<b class="red"><?php echo $sYWGFnfCrijzOYJeNbNw[$GLOBALS["TtOzRJzXQSQxdUXTMjZM"]]; ?></b>
		</li>

		<li>
			<i class="icon-caret-right blue"></i>
		Contact No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<b class="red"> <?php echo $sYWGFnfCrijzOYJeNbNw[$GLOBALS["rHQcROtjtGwxmEfsumaI"]]; ?>,<?php echo $sYWGFnfCrijzOYJeNbNw[$GLOBALS["pUAXzMjNDFzrvDHDKFnZ"]]; ?></b>
		</li>

		<li>
			<i class="icon-caret-right blue"></i>
		Address&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;<b class="red"> <?php echo $sYWGFnfCrijzOYJeNbNw[$GLOBALS["pSyDfVIvynENrUJiURmk"]]; ?></b>
		</li>

		<li>
			<i class="icon-caret-right blue"></i>
			Areaname&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
            	<b class="red"><?php echo $sYWGFnfCrijzOYJeNbNw[$GLOBALS["EjGTruiCURmZwZocXuMH"]]; ?></b>
		</li>

		<li class="divider"></li>

		<li>
			<i class="icon-caret-right blue"></i>
			City&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;
            	<b class="red"><?php echo $sYWGFnfCrijzOYJeNbNw[$GLOBALS["WKBChtIeVLMffdOLPBQn"]]; ?></b>
		</li>
	</ul>
</div>
</div><!-- /span -->

<!-- /span -->
</div><!-- row -->

<input type="hidden" name="pharm_id" id="pharm_id" value="<?php echo $oDqUKVFHcmXfRsyKHAZO; ?>" />
<input type="hidden" name="pat_id" id="pat_id" value="<?php echo $id; ?>" />


<input type="hidden" name="rand_no" id="rand_no" value="<?php echo $azxKcbCEHCWoNMWQxZas; ?>" />
<table width="100%">
<tr>
<td width="51%">
<div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-6">Product Name</label>
<div class="col-sm-9"><input type="text" id="pro_name" name="pro_name"  placeholder="Product Name" class="col-xs-10 col-sm-5"  style="width: 88.667%;"/></div></div>
</td>
<td width="33%">
<div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-6">Quantity</label>
<div class="col-sm-9"><input type="text" id="quantity" name="quantity"  placeholder="Quantity" class="col-xs-10 col-sm-5" maxlength="7" /></div></div>
</td>

 <td width="16%">
 
<span class="input-group-btn">
<a href="#" onClick="getssts()">
<button type="button" class="btn btn-purple btn-sm">Add to Cart<i class="icon-shopping-cart icon-on-right bigger-110"></i></button>
</a>
</span>

</td>
</tr>
</table>




<div class="space"></div>


<div>

</div>

<div class="hr hr8 hr-double hr-dotted"></div>
 <div id="orderlist" class="orderlist"></div>
<div class="row">
<div class="col-sm-5 pull-right">
<h4 class="pull-right">
	
</h4>
</div>
<div class="col-sm-7 pull-left"> </div>
</div>

<div class="space-6"></div>
<div class="well">
<table>
  <tr>
    	<td colspan="2">
        	                                        <p>Note -</p>
<ul>

<li>No medicine will be delivered without prescription.</li>
<li>A minimum order of Rs 200 is required </li>
<li>  Free delivery on all medicines if your total order amount is Rs. 500/- or more. Otherwise Rs. 30/- is charged as delivery charges.</li>
<li>Currently we have the Payment  Method of COD Only (Cash On Delivery) and more methods will available soon</li>

</ul>
        </td>
    </tr>
    </table>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- PAGE CONTENT ENDS -->
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.page-content -->
</div><!-- /.main-content -->

<!-- /#ace-settings-container -->
</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
<i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
</div><!-- /.main-container -->



</body>
</html> <?php } ?>
