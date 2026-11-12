<?php
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
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
include("encrypt.php");

if(@$_REQUEST['submit']=="Submit"){
	$hos_name=$_REQUEST['hos_name'];
	$add_hospital=$_REQUEST['add_hospital'];
	$type=$_REQUEST['type'];
	$doc_name=$_REQUEST['doc_name'];

	if($_REQUEST['condition']=='new_hos' && $add_hospital!=''){
		mysql_query("INSERT INTO mst_hospital(hos_name,hos_type,c_date,c_time) VALUES('$add_hospital','$type',curdate(),curtime())");
		$hos_name=mysql_insert_id();
		mysql_query("UPDATE doctors SET doc_hospital_clinic_name='$hos_name' WHERE id='$doc_name'");
	} elseif($_REQUEST['condition']=='old_hos' && $hos_name!='') {
		mysql_query("UPDATE doctors SET doc_hospital_clinic_name='$hos_name' WHERE id='$doc_name'");
	}
	echo "<script type='text/javascript'>window.location='hospital_doctor_mapping.php'</script>"; 
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
</head>

<body id="mm">
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
<h2><i class="icon-user"></i>Hospital Doctor Mapping</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">

<div>
    <form class="form-horizontal" name="thisForm" id="thisForm" action="" method="post">
        <input type="hidden" name="condition" id="condition" value="old_hos">

        <div class="control-group" id="old_hospital">
        	<label class="control-label" for="typeahead">Hospital<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="hos_name" name="hos_name" data-rel="chosen" style="width: 250px;">
                    <option value="">--Select--</option>
                    <?php 
                    $select=mysql_query("SELECT id,hos_name,hos_type FROM mst_hospital WHERE hos_name!='' ORDER BY hos_name ASC");
                    while($row_sel=mysql_fetch_array($select)){ 
                    ?>
                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['hos_name']." - ".$row_sel['hos_type']; ?></option>
                    <?php } ?> 
                </select>
            	&nbsp;&nbsp;<a class="btn btn-primary" id="new" style="width: 40px;margin-top: -15px;">Add</a>
            </div>
        </div>

        <div id="new_hospital">
	        <div class="control-group">
	        	<label class="control-label" for="typeahead">Hospital<span style="color:#FF0000;">*</span> </label>
				<div class="controls">
					<input type="text" name="add_hospital" id="add_hospital">
	            	&nbsp;&nbsp;<a class="btn btn-primary" id="old">Select</a>
	            </div>
	        </div>

	        <div class="control-group">
	        	<label class="control-label" for="typeahead">Type<span style="color:#FF0000;">*</span> </label>
				<div class="controls">
	                <select id="type" name="type" data-rel="chosen" style="width: 250px;">
	                    <option value="">--Select--</option>
	                    <option value="Clinic">Clinic</option>
	                    <option value="Nursing">Nursing</option>
	                    <option value="Multispeciality">Multispeciality</option>
	                </select>
	            </div>
	        </div>
        </div>

        <div class="control-group">
        	<label class="control-label" for="typeahead">Doctor<span style="color:#FF0000;">*</span> </label>
			<div class="controls">
                <select id="doc_name" name="doc_name" data-rel="chosen" style="width: 250px;">
                    <option value="">--Select--</option>
                    <?php 
                    $select=mysql_query("SELECT id,doctor_name FROM doctors WHERE doctor_name!='' AND doc_hospital_clinic_name NOT IN (select id from mst_hospital where hos_name!='') ORDER BY doctor_name ASC");
                    while($row_sel=mysql_fetch_array($select)){ 
                    ?>
                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['doctor_name']; ?></option>
                    <?php } ?> 
                </select>
            </div>
        </div>


        <div class="control-group">
        	<div class="controls">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit"/> 
            </div>
        </div>
    </form>
</div>

</div>
</div>
</div>
</div>
</div>
<hr>

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
$("#new_hospital").hide();

$("#new").click(function(){
	$("#old_hospital").hide();
	$("#new_hospital").show();
	$("#condition").val("new_hos");
});

$("#old").click(function(){
	$("#old_hospital").show();
	$("#new_hospital").hide();
	$("#condition").val("old_hos");
});

$("#thisForm").submit(function(){
	if($("#condition").val()=='new_hos'){
		if($("#add_hospital").val()==''){
			alert("Please Enter Hospital Name");
			return false;
		} else if($("#type").val()==''){
			alert("Please Select Hospital Type");
			return false;
		} else if($("#doc_name").val()==''){
			alert("Please Select Doctor Name");
			return false;
		} else {
			form.submit();
		}
	} else if($("#condition").val()=='old_hos'){
		if($("#hos_name").val()==''){
			alert("Please Select Hospital Name");
			return false;
		} else if($("#doc_name").val()==''){
			alert("Please Select Doctor Name");
			return false;
		} else {
			form.submit();
		}
	}

});

</script>
</body>
</html>
<?php
}
?>