<?php
include("include/connect.php");


	
 ?>


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
	<?php
	 if(@$_REQUEST["mode"]=="servicedel")
{ 
  // echo "DELETE FROM reorting WHERE id = '".$_REQUEST["spid"]."'";
  mysql_query("DELETE FROM stationplanforrep WHERE id = '".$_REQUEST["spid"]."'") or die(mysql_error());
  header("location:station_plan.php");

}





		if(isset($_REQUEST["insertstation"])){	 
 $id = explode(",", $_REQUEST['pincode']);

if($_REQUEST['wage']=='out')
{
$repamt=mysql_query("SELECT * FROM representative WHERE rep_id ='".$_REQUEST['rep']."' ");	
			$repamt_res=mysql_fetch_object($repamt);
			$outlocal=$repamt_res->rep_out_wages;
		}
		if($_REQUEST['wage']=='local')
		{
			$repamt=mysql_query("SELECT * FROM representative WHERE rep_id ='".$_REQUEST['rep']."' ");	
			$repamt_res=mysql_fetch_object($repamt);
			$outlocal=$repamt_res->rep_hq_wages;
		}

foreach($id as $ids)
{


	
	// echo "INSERT INTO stationplanforrep(`repid`, `station`,amount, `pinid`)VALUES('".$_REQUEST['rep']."','".$_REQUEST['wage']."','".$ids."','".$_REQUEST['wage']."')";

 $query=mysql_query("INSERT INTO stationplanforrep(`repid`, `station`,amount, `pinid`)VALUES('".$_REQUEST['rep']."','".$_REQUEST['wage']."','".$outlocal."','".$ids."')")or die(mysql_error());
}

}


	
?>
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