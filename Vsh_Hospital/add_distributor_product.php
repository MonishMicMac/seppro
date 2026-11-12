<?php
$GLOBALS["rLIcDxBaHTTSgNPpxvE"]=base64_decode("b3JkZXIgYnkgaWQgZGVzYw==");$GLOBALS["tugkmwKQmrdyfghQnRJj"]=base64_decode("");$GLOBALS["iVqDePazAEUnrjghIQAg"]=base64_decode("ZGlzdF9wcm9k");$GLOBALS["vXjpuQeiRtPyECNULhgN"]=base64_decode("bV9pZDE2");$GLOBALS["SiRSACHoXsTIZeRmGmwq"]=base64_decode("aWQ=");$GLOBALS["pjRlZOumzlQexPlnHSAM"]=base64_decode("MTAwMDAx");$GLOBALS["YwTxtTPHFcxOofSfhhI"]=base64_decode("aW5jbHVkZS9zZWxlY3QucGhw");$GLOBALS["JyetPmcGcjfVOGKljFQB"]=base64_decode("PHNjcmlwdCB0eXBlPSd0ZXh0L2phdmFzY3JpcHQnPndpbmRvdy5sb2NhdGlvbj0naW5kZXgucGhwP2Vycic8L3NjcmlwdD4=");$GLOBALS["fYnHIJWSnwzufWAZkBqF"]=base64_decode("aW5jbHVkZS9jb25uZWN0LnBocA==");$GLOBALS["PsFfkBiXMpQvSLYqwDXQ"]=base64_decode("aW5jbHVkZS90aXRsZS5waHA=");$GLOBALS["PBLWvAuEsHHzJxJcoBaP"]=base64_decode("aW5jbHVkZS9oZWFkZXIucGhw");$GLOBALS["ceLpMtfDxtWMNPunDlCC"]=base64_decode("aW5jbHVkZS9tZW51LnBocA==");$GLOBALS["UdElpHHfUPjqXpaaPuNN"]=base64_decode("aW5jbHVkZS9mb290ZXIucGhw");
?><?php include($GLOBALS["fYnHIJWSnwzufWAZkBqF"]); session_start(); $id=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; $drHwlbyHHweIeFkcMuoY=$_SESSION[$GLOBALS["vXjpuQeiRtPyECNULhgN"]]; $lJxYrgOZIjpuNbWusLOE=$_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]]; if(!isset($_SESSION[$GLOBALS["SiRSACHoXsTIZeRmGmwq"]])) { echo $GLOBALS["JyetPmcGcjfVOGKljFQB"]; } else { require_once($GLOBALS["YwTxtTPHFcxOofSfhhI"]); $SusZXNaeTUgubQSljYmT=new LxRBOTrjnRbZktJdrB(); $vjRCaTGWEdYwnMPrUHMH=$SusZXNaeTUgubQSljYmT->jzoHVDmIGcyuXlnDUyPF($GLOBALS["iVqDePazAEUnrjghIQAg"],$GLOBALS["tugkmwKQmrdyfghQnRJj"],$GLOBALS["rLIcDxBaHTTSgNPpxvE"]); $rdidZglFbkCOJsUsoSJx=$SusZXNaeTUgubQSljYmT->nrujouwLIHHlRrJWIcFV($GLOBALS["iVqDePazAEUnrjghIQAg"],$GLOBALS["tugkmwKQmrdyfghQnRJj"],$GLOBALS["rLIcDxBaHTTSgNPpxvE"]); if($rdidZglFbkCOJsUsoSJx > 0) { $lJKlAJazOckqgEzORwyY=mysql_fetch_object($vjRCaTGWEdYwnMPrUHMH); $vryRWOSAuUlWWHqCFzmZ=$lJKlAJazOckqgEzORwyY->pro_id+1; } else { $vryRWOSAuUlWWHqCFzmZ=$GLOBALS["pjRlZOumzlQexPlnHSAM"]; } ?>
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

<body>
 <?php include($GLOBALS["PBLWvAuEsHHzJxJcoBaP"]); ?>

<div class="container-fluid">
<div class="row-fluid"> <?php include($GLOBALS["ceLpMtfDxtWMNPunDlCC"]); ?>
			
			
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Add Distributor's Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form class="form-horizontal" action="include/control.php" enctype="multipart/form-data" method="post"  name="frm"  >
<input type="hidden" name="command" id="command" value="add_dis_product" />
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $drHwlbyHHweIeFkcMuoY; ?>" />
<input class="input-xlarge focused"  type="hidden" name="dis_pro_no" id="dis_pro_no" value="<?php echo $vryRWOSAuUlWWHqCFzmZ;?>" readonly/>
<fieldset>
<div class="control-group">
    <div class="controls">
        <div style="float:right;"> 
            <a href="import_distributor_product.php">Import Distributor Product</a>
            <a href="excelformat/distributor_product.xls">| Download Excel Sheet Format</a>
        </div>
    </div>
</div>
<!--<div class="control-group">
    <label class="control-label" for="typeahead">Distributor Product No<span style="color:#FF0000;">*</span></label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="dis_pro_no" id="dis_pro_no" value="<?php ?>" readonly/>
    </div>
</div>-->
<div class="control-group">
    <label class="control-label" for="typeahead">Distributor Product Name<span style="color:#FF0000;">*</span></label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="pro_name" id="pro_name" />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="typeahead">Combinations</label>
    <div class="controls">
        <input class="input-xlarge focused"  type="text" name="pro_com" id="pro_com" style="width:371px; height:160px;" />
    </div>
</div>
<div class="form-actions">
    <input type="submit" class="btn btn-primary" name="submit" value="submit" onClick="return valid();" /> 
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
		
</body>
</html> <?php } ?>