<?php
include("include/connect.php");
session_start();
date_default_timezone_set("Asia/Kolkata");
error_reporting();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{
    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
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
	<link rel="stylesheet" href="css/leaflet.css" />
  <link href="http://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="css/leaflet.awesome-markers.css">
    

    </head>

<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
			
			
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>Rep Tracking</h2>
<div class="box-icon">
</div>
</div>   
<div class="box-content">

<div>
    <form name="thisForm" action="" method="post">

        <table style="width:100%;">
            <tr>
                <td><Label>Representative Name</label></td>
                <td>:</td>
                <td>
	                <select id="rep_name" name="rep_name" data-rel="chosen" style="width: 250px;">
	                    <option value="">--Select--</option>
	                    <?php 
	                    $select=mysql_query("SELECT id,rep_name FROM representative WHERE rep_name!='' ORDER BY rep_name ASC");
	                    while($row_sel=mysql_fetch_array($select)){ 
	                    ?>
	                    <option value="<?php echo $row_sel['id']; ?>"><?php echo $row_sel['rep_name']; ?></option>
	                    <?php } ?> 
	                </select><script>document.getElementById("rep_name").value="<?=$_REQUEST['rep_name'] ?>";</script>
                </td>
                <td><Label>Date</label></td>
                <td>:</td>
                <td><input type="text" name="date" id="date" value="<?php echo @$_REQUEST["date"]; ?>" readonly/></td>
                <td><input type="submit" name="submit" value="REPORT" class="btn btn-primary" ></td>
                <td></td>
            </tr>
        </table>
    </form>
</div>

<iv class="row-fluid sortable">
<?php if($_REQUEST['submit']=='REPORT'){ ?>
	<div id="map" style="height: 500px;"></div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>

<hr>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-left:-35%;width:70%;"></div>

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
	<script src="js/leaflet.js"></script>
	<script src="js/leaflet.awesome-markers.js"></script>
	<script>
	    $(document).ready(function(){
			$(function() {
				$( "#date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "1990:2020",
				dateFormat:"yy/mm/dd"
				});
			});

			$(".location2").click(function(){
				var ltlg=$(this).attr("latlng");
				markerFunction($(this)[0].id,ltlg);
			});				 
		});

	    var markers = [];	
		var map = L.map('map').setView([13.0827,80.2707], 12);
		L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; mic&amp;Mac Solutions Private Limited',
		}).addTo(map);
		
		var marker = L.AwesomeMarkers.icon({
			icon: 'male', 
			markerColor: 'blue',
			prefix: 'fa', 
			iconColor: 'white'
		});

		<?php 
		if($_REQUEST['submit']=='REPORT'){
		$g=1; 
		$bus_latlong= mysql_query("SELECT latt,longg,reportedtime,(select rep_name from representative where id=reorting.repid) as rep_name FROM reorting WHERE latt!='' AND longg!='' AND repid='".$_REQUEST['rep_name']."' AND reporteddate='".date('Y-m-d',strtotime($_REQUEST['date']))."'")or die(mysql_error());
		while($tharun = mysql_fetch_array($bus_latlong)){ ?>
			var markers1 =  L.marker([<?php echo $tharun['latt'].",".$tharun['longg'] ?>],{icon: marker}).addTo(map).bindPopup("<?php echo $tharun['reportedtime'] ?>").openPopup();
			markers.push(markers1);
		<?php $g++; }} ?>
	</script>
</body>
</html>
<?php
}
?>
