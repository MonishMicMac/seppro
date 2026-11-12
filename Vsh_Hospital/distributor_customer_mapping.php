<?php
$GLOBALS["rLIcDxBaHTTSgNPpxvE"]=base64_decode("b3JkZXIgYnkgaWQgZGVzYw==");$GLOBALS["tugkmwKQmrdyfghQnRJj"]=base64_decode("");$GLOBALS["zbaNXOyfEoBcogrjPtmM"]=base64_decode("ZGlzdHJpYnV0b3I=");$GLOBALS["vXjpuQeiRtPyECNULhgN"]=base64_decode("bV9pZDE2");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["YwTxtTPHFcxOofSfhhI"]=base64_decode("aW5jbHVkZS9zZWxlY3QucGhw");$GLOBALS["MKGYVopwacIFCWzzCbn"]=base64_decode("ZW5jcnlwdC5waHA=");$GLOBALS["JyetPmcGcjfVOGKljFQB"]=base64_decode("PHNjcmlwdCB0eXBlPSd0ZXh0L2phdmFzY3JpcHQnPndpbmRvdy5sb2NhdGlvbj0naW5kZXgucGhwP2Vycic8L3NjcmlwdD4=");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["PBLWvAuEsHHzJxJcoBaP"]=base64_decode("aW5jbHVkZS9oZWFkZXIucGhw");$GLOBALS["ceLpMtfDxtWMNPunDlCC"]=base64_decode("aW5jbHVkZS9tZW51LnBocA==");$GLOBALS["NerowOoMDDRhDwzZzWUH"]=base64_decode("ZGlzX2lk");$GLOBALS["JuanCDNHonsTIgUkoGHx"]=base64_decode("ZGlzX25hbWU=");$GLOBALS["UdElpHHfUPjqXpaaPuNN"]=base64_decode("aW5jbHVkZS9mb290ZXIucGhw");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $drHwlbyHHweIeFkcMuoY=$_SESSION[$GLOBALS["vXjpuQeiRtPyECNULhgN"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])) { echo $GLOBALS["JyetPmcGcjfVOGKljFQB"]; } else { include($GLOBALS["MKGYVopwacIFCWzzCbn"]); require_once($GLOBALS["YwTxtTPHFcxOofSfhhI"]); $SusZXNaeTUgubQSljYmT=new LxRBOTrjnRbZktJdrB(); $wxyLyYohdDKhqacixNMD=$SusZXNaeTUgubQSljYmT->jzoHVDmIGcyuXlnDUyPF($GLOBALS["zbaNXOyfEoBcogrjPtmM"],$GLOBALS["tugkmwKQmrdyfghQnRJj"],$GLOBALS["rLIcDxBaHTTSgNPpxvE"]); ?>
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

</head>

<body> <?php include($GLOBALS["PBLWvAuEsHHzJxJcoBaP"]); ?>
<div class="container-fluid">
<div class="row-fluid"> <?php include($GLOBALS["ceLpMtfDxtWMNPunDlCC"]); ?>


<div id="content" class="span10">

<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Search by Distributor</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="distributor_customer_map.php" enctype="multipart/form-data" method="post" name="frm">
<fieldset>
    
<div class="control-group">
<label class="control-label" for="typeahead">Distributor's Name<span style="color:#FF0000;">*</span> </label>
<div class="controls">
<select  id="dist_id" name="dist_id" data-rel="chosen">
<option value="">--Select--</option> <?php while($YBMnEMCZKubrJvWITooe=mysql_fetch_array($wxyLyYohdDKhqacixNMD)) { $TIWjKZQVBbimeIjiDqmA=$YBMnEMCZKubrJvWITooe[$GLOBALS["JuanCDNHonsTIgUkoGHx"]]; $OJyJwQCjbskjubRQXHnL=$YBMnEMCZKubrJvWITooe[$GLOBALS["NerowOoMDDRhDwzZzWUH"]]; ?>
<option value="<?php echo $OJyJwQCjbskjubRQXHnL; ?>"><?php echo $TIWjKZQVBbimeIjiDqmA; ?></option> <?php } ?> 
</select>
</div>
</div>
    
<div class="form-actions">
<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Search"/> 
</div>
    
</fieldset>
</form>
</div>
</div>
</div>
</div>
</div>

<hr>
 <?php include($GLOBALS["UdElpHHfUPjqXpaaPuNN"]); ?>

</div><
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
        $("form").submit(function(){
           var dis_id=$('#dist_id').val(); 
           if(dis_id === '')
           {
             alert("Please select Distributor");
             return false;
           } else
           {
             return true;
           }
        });
    });
</script>
</body>
</html> <?php } ?>