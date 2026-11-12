<?php
$GLOBALS["tugkmwKQmrdyfghQnRJj"]=base64_decode("");$GLOBALS["iVqDePazAEUnrjghIQAg"]=base64_decode("ZGlzdF9wcm9k");$GLOBALS["rLIcDxBaHTTSgNPpxvE"]=base64_decode("b3JkZXIgYnkgaWQgZGVzYw==");$GLOBALS["wQUsJvosoMwRlHvHahf"]=base64_decode("d2hlcmUgbV9pZDE2PQ==");$GLOBALS["zbaNXOyfEoBcogrjPtmM"]=base64_decode("ZGlzdHJpYnV0b3I=");$GLOBALS["vXjpuQeiRtPyECNULhgN"]=base64_decode("bV9pZDE2");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["YwTxtTPHFcxOofSfhhI"]=base64_decode("aW5jbHVkZS9zZWxlY3QucGhw");$GLOBALS["JyetPmcGcjfVOGKljFQB"]=base64_decode("PHNjcmlwdCB0eXBlPSd0ZXh0L2phdmFzY3JpcHQnPndpbmRvdy5sb2NhdGlvbj0naW5kZXgucGhwP2Vycic8L3NjcmlwdD4=");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["PBLWvAuEsHHzJxJcoBaP"]=base64_decode("aW5jbHVkZS9oZWFkZXIucGhw");$GLOBALS["ceLpMtfDxtWMNPunDlCC"]=base64_decode("aW5jbHVkZS9tZW51LnBocA==");$GLOBALS["pdkFBWwmISaSvTSShwrw"]=base64_decode("ZnJvbV9kYXRl");$GLOBALS["UdElpHHfUPjqXpaaPuNN"]=base64_decode("aW5jbHVkZS9mb290ZXIucGhw");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $drHwlbyHHweIeFkcMuoY=$_SESSION[$GLOBALS["vXjpuQeiRtPyECNULhgN"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])) { echo $GLOBALS["JyetPmcGcjfVOGKljFQB"]; } else { require_once($GLOBALS["YwTxtTPHFcxOofSfhhI"]); $SusZXNaeTUgubQSljYmT=new LxRBOTrjnRbZktJdrB(); $uHrzRBdPUetDqbZAdw=$SusZXNaeTUgubQSljYmT->jzoHVDmIGcyuXlnDUyPF($GLOBALS["zbaNXOyfEoBcogrjPtmM"],$GLOBALS["wQUsJvosoMwRlHvHahf"].$drHwlbyHHweIeFkcMuoY,$GLOBALS["rLIcDxBaHTTSgNPpxvE"]); $OVrfYwrIuIBfaimkZNBS=$SusZXNaeTUgubQSljYmT->jzoHVDmIGcyuXlnDUyPF($GLOBALS["iVqDePazAEUnrjghIQAg"],$GLOBALS["tugkmwKQmrdyfghQnRJj"],$GLOBALS["rLIcDxBaHTTSgNPpxvE"]); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> <?php include($GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]); ?>
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
    
    <script type="text/javascript">
function valid()
{
var x=document.getElementById("dist_id").value;
if(x === "null" || x === "")
{
alert("Please Enter Distributor Name");
return false; 
}
return true;
}
</script>

    
</head>

<body>
 <?php include($GLOBALS["PBLWvAuEsHHzJxJcoBaP"]); ?>
		<div class="container-fluid">
		<div class="row-fluid">
        <?php include($GLOBALS["ceLpMtfDxtWMNPunDlCC"]); ?>
			
<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>MONTHWISE CONSOLIDATED REPORT</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="repwise_stockist_sales_excel.php" enctype="multipart/form-data" method="post"  name="frm">

<input type="hidden" name="sess_id" id="sess_id" value="<?php echo $id; ?>" />
<input type="hidden" name="syst_id" id="syst_id" value="<?php echo $drHwlbyHHweIeFkcMuoY; ?>" />
<fieldset>
<div class="control-group"><label class="control-label" for="typeahead">Month &amp; Year<span style="color:#FF0000;">*</span> </label>
<div class="controls"><input type="text" name="from_date" id="from_date" readonly value="<?php echo @$_REQUEST[$GLOBALS["pdkFBWwmISaSvTSShwrw"]]; ?>"  required/></div></div>
<!--onKeyUp="AllowAlphabet()"-->


<div class="form-actions"><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" onClick="return valid();"  /> <input type="reset" class="btn" value="Cancel" /></div>

</fieldset>
</form>

<div class="control-group" id="reportwise"><label class="control-label" for="typeahead">SALE RECORD<span style="color:#FF0000;">*</span> </label>
<div class="controls"><label class="radio"><input type="radio" name="customer" id="Customer" checked>&nbsp;CUSTOMER</label>&nbsp;&nbsp;<label class="radio"><input type="radio" name="customer" id="Product" >&nbsp;PRODUCT</label></div></div>
<div id="Upload"></div>
<div class="btn btn-danger" id="removedata" style="display:none">REMOVE DATA</div>
<div id="Record"></div>
</div>
</div>
</div>









</div>
</div>
				
		<hr>

        <?php include($GLOBALS["UdElpHHfUPjqXpaaPuNN"]); ?>
		
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
        $(document).ready(function()
        {
        $('#submit').click(function()
        {
        if($("#excel_file").val()===""){
        alert("Please Upload xls File");
        return false; 
        }
        else{
        var fup = document.getElementById('excel_file');
        var fileName = fup.value;
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        if(ext === "xls" || ext === "xlsx"){
        return true;
        }else
        {
        alert("Upload xls File only");
        $("#excel_file").val('');
        return false;
        }
        }
        });
        return true;
        });
		$("#reportwise").hide();
		$("#dist_id").change(function(){			
			$.post("autosearch-y/distributor_sales.php?dist_id=check&distributor_id="+$("#dist_id").val()+"&month="+$('#from_date').val()+"",function(data){
				if(data=="<h2 style=\"color:#0066FF;\">DATA NOT AVAILABLE</h2>"){$("#reportwise,#removedata").hide();}
				if(data!="<h2 style=\"color:#0066FF;\">DATA NOT AVAILABLE</h2>"){$("#reportwise,#removedata").show();}$("#Upload").html(data);
			});
			$.post("autosearch-y/distributor_sales.php?Customer=check&distributor_id="+$("#dist_id").val()+"&month="+$('#from_date').val()+"",function(data){
					$("#Record").html(data);
			});
		});
		$('#Customer').click(function(){
			if($(this).is(':checked')){
				$.post("autosearch-y/distributor_sales.php?Customer=check&distributor_id="+$("#dist_id").val()+"&month="+$('#from_date').val()+"",function(data){
					$("#Record").html(data);
				});
			}
		});
		$('#Product').click(function(){
			if($(this).is(':checked')){
				$.post("autosearch-y/distributor_sales.php?Product=check&distributor_id="+$("#dist_id").val()+"&month="+$('#from_date').val()+"",function(data){
					$("#Record").html(data);
				});
			}
		});
		$('#removedata').click(function(){
			if(confirm("Are you sure delete this Distributor data?")){
				$.post("autosearch-y/distributor_sales.php?Distributor=check&distributor_id="+$("#dist_id").val()+"&month="+$('#from_date').val()+"",function(data){
						$("#reportwise,#removedata,#Record").hide();$("#Upload").html(data);
				});
			}
		});
</script>	
<script>
$(function() {
    $('#from_date').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        yearRange: '1980:' + new Date().getFullYear(),
        beforeShow: function(el, dp) { 
            $('#ui-datepicker-div').addClass('hide-calendar');
        },
        onClose: function(dateText, inst) { 
            $('#ui-datepicker-div').removeClass('hide-calendar');
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
    });
});
</script>
<style>
 .ui-datepicker-calendar {
   display: none;
 }
</style>
</body>
</html> <?php } ?>