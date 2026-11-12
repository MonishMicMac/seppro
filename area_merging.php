<?php
include("include/connect.php");
error_reporting(0);
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{


if(@$_REQUEST['submit']=='Merge Area'){
	$pin_id=$_REQUEST['pin_id'];
	$sql1=mysql_query("SELECT * FROM master_pincode where pin_id=".$_REQUEST['pin_id']);
	$row1=mysql_fetch_array($sql1);
	$state_id=$row1['state_id'];
	$dist_id=$row1['district_id'];
	$pincode=$row1['pincode'];
	$new_area=$_REQUEST['new_areaname'];
	$area=implode(',', $_REQUEST['area_name']);

	mysql_query("INSERT INTO pincode_list (state_id,dist_id,area_name,pin_id,pincode,c_date,c_time) VALUES('$state_id','$dist_id','$new_area','$pin_id','$pincode',CURDATE(),CURTIME())");
	$area_id=mysql_insert_id();

mysql_query("DELETE FROM pincode_list WHERE id IN ($area)");

	mysql_query("UPDATE areawise_temp SET area_id='$area_id' WHERE area_id IN ($area)");
	mysql_query("UPDATE tbl_customer_master SET area_id='$area_id' WHERE area_id IN ($area)");

	echo "<script type='text/javascript'>window.location='area_merging.php'</script>"; 
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
<h2><i class="icon-edit"></i>AREA MERGING</h2>
<div class="box-icon">
</div>
</div>   
<div class="box-content">
<form class="form-horizontal" action="" enctype="multipart/form-data" method="post"  name="frm" id="frm">
	<fieldset>
	 	<div class="control-group"><label class="control-label" for="typeahead">Pincode<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
				<select name="pin_id" id="pin_id" data-rel="chosen" required>
			    	<option value="">---Select---</option>
			        <?php $P=mysql_query("SELECT * FROM master_pincode"); while($I=mysql_fetch_object($P)){ ?>
			        <option value="<?=$I->pin_id; ?>"><?=$I->pincode; ?></option>
			        <?php } ?>
			    </select>
			</div>
		</div>
		<div class="control-group" id="new_areaname"><label class="control-label" for="typeahead">New Area<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
				<input type="text" name="new_areaname" required />
			</div>

			<div class="controls" id="show_area"></div>
			<div class="controls">
				<input type="submit" name="submit" value="Merge Area" class="btn btn-primary">
			</div>
			
		</div>
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
$(document).ready(function(){
	$("#new_areaname").hide();
	$("#pin_id").change(function(){
	    $.ajax({
	    	url: "autosearch-y/representative.php", 
	    	data: "&condition=area_merging&pin_id="+$(this).val(),
	    	success: function(result){
	    		$("#new_areaname").show();
	        	$("#show_area").html(result);
		    }
		});
	});
});
</script>

</body>
</html>
<?php
}
?>
