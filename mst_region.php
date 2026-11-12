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
include("include/select.php");
if(@$_REQUEST["mode"]=="save"){
	mysql_query("INSERT INTO mst_region(state_id,region_name) VALUES('".$_REQUEST["state_id"]."','".$_REQUEST["region_name"]."')");
	$TID = mysql_insert_id();	
	foreach($_REQUEST["zone_name"] as $p){
		mysql_query("INSERT INTO tbl_region(state_id,region_id,region) VALUES('".$_REQUEST["state_id"]."','".$TID."','".$p."')");		
	}
	header("location:mst_region.php");	
	die();
}
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
$T=mysql_query("SELECT * FROM  mst_region WHERE region_id=".$_REQUEST["region_id"]."");
$TR=mysql_fetch_object($T);
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
    <script>
    	function yuvaraj(state){
			window.location.href="mst_region.php?state_id="+state;
		}
    </script>
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
<h2><i class="icon-user"></i>REGION</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
   <!-- BODY CONTENT - Start -->
   <form name="thisForm" method="post" action="?mode=save">
   <table id="rep" class="table table-striped table-bordered bootstrap-datatable datatable">
   
   <tbody>
   <tr>
   		<td>State Name</td>
        <td>
     <div class="control-group">
    <div class="controls">
        <select class="input-xlarge disabled" name="state_id" id="state_id" required onChange="yuvaraj(this.value);">
            <option value="">---Select---</option>
            <?php
				$ds_id=mysql_query("SELECT * FROM master_state");
             	while($row_ds=mysql_fetch_array($ds_id)){
			?>
               <option value="<?=$row_ds['state_id']; ?>"><?=$row_ds['state_name'];?></option>  
       <?php }  ?>
        </select> 
        <script>document.thisForm.state_id.value=<?=@$_REQUEST["state_id"]; ?></script>       
    </div>
</div>
        </td>
   </tr>
   <tr><td>REGION NAME</td><td><input type="text" id="region_name" name="region_name" value="<?=$TR->region_name; ?>" /></td></tr>
   
    		<tr>
        		<td>SELECT (ONE / MULTIPLE) SUB REGION</td>  
            	<td>
					<?php $SQL=mysql_query("SELECT * FROM mst_zone"); while($R=mysql_fetch_object($SQL)){ ?>
                    	<div style="margin:5px"><input type="checkbox" name="zone_name[]" value="<?=$R->zone_id; ?>" ><?=$R->zone_name; ?></div>
                    <?php } ?>                	
                </td>
                <tr><td colspan="2"><input type="submit" name="submit" value="submit"></td></tr>
            </tr>                    
    </tbody>
        </table>
        
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        	<tr><th>REGION</th><th>ZONE</th></tr>
            <?php $SQL=mysql_query("SELECT * FROM mst_region"); while($R=mysql_fetch_object($SQL)){ ?>
            <tr>
            	<td><?=strtoupper($R->region_name); ?> &nbsp;<a href="mst_region.php?region_id=<?=$R->region_id; ?>&state_id=<?=$R->state_id; ?>"><img src="img/2.png" width="20" height="20"></a>&nbsp;&nbsp;<img src="img/uploadify-cancel.png" width="16" height="16"></td><td><?php $RY=mysql_query("SELECT * FROM tbl_region,mst_zone WHERE region_id='".$R->region_id."' AND tbl_region.region=mst_zone.zone_id"); while($YR=mysql_fetch_object($RY)){ ?>
                	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                    	<tr><td><?=$YR->zone_name; ?></td></tr>
                    </table>
                    <?php } ?>
                </td>
                
             </tr>
            <?php } ?>
        </table>       
   </form>
   <!-- BODY CONTENT - End -->
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
    <script type="text/javascript" src="src/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="styles/token-input.css" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){ $("#Submit").click(function(){ alert("T"); }); });
</script>
</body>
</html>
<?php
}
?>