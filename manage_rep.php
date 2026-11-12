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
	
			if(@$_REQUEST["repid"]!=""){
			$pin = explode(",",$_REQUEST["pins"]);
			foreach($pin as $p){
				mysql_query("INSERT INTO assigningreptomanager(managerid,repid) VALUES('".$_REQUEST["repid"]."','".$p."')");		
			}
			$_SESSION["_err"] = "Rep Assigned Manager...";
			}
			
	
	if(@$_REQUEST["repid"]==""){

		$pin = explode(",",$_REQUEST["pins"]);
			foreach($pin as $p){
				mysql_query("INSERT INTO assigningreptomanager(managerid,repid) VALUES('".$_REQUEST["rep_id"]."','".$p."')");		
			}	

		$_SESSION["_err"] = "Rep Assigned Manager Updated...";
	}
	header("location:manage_rep.php");	
	die();
}
if(@$_REQUEST["mode"]=="delete"){
	$teritary = explode(",",$_REQUEST["t_id"]);
  /*echo "DELETE FROM assigningreptomanager WHERE managerid=".$teritary[0]." and id=".$teritary[1]." ";
  exit;*/
	mysql_query("DELETE FROM assigningreptomanager WHERE managerid=".$teritary[0]." and id=".$teritary[1]." ");
	
  $_SESSION["_err"] = "Rep Deleted...";
	header("location:manage_rep.php?rep_id=".$teritary[0]." ");	
	die();
}
if(@$_REQUEST["mode"]=="tdelete"){	
	mysql_query("DELETE FROM assigningreptomanager WHERE managerid=".$_REQUEST["t_id"]."");
	$_SESSION["_err"] = "Rep  Deleted...";
	header("location:manage_rep.php");	
	die();
}
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
/*if($_REQUEST["tertiary_id"]!=""){

	$T=mysql_query("SELECT * FROM  mst_tertiary WHERE tertiary_id=".$_REQUEST["tertiary_id"]."");
	$TR=mysql_fetch_object($T);
}*/
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
			window.location.href="mst_territory.php?state_id="+state;
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
<h2><i class="icon-user"></i>Manager Assign Rep</h2>
<div class="box-icon">
</div>
</div>

<div class="box-content">
   <!-- BODY CONTENT - Start -->
   <form name="thisForm" method="post" action="?mode=save" onSubmit="return fnValidate()">
   <input type="hidden" name="rep_id" value="<?=@$_REQUEST["rep_id"]; ?>">
   
   <table id="rep" class="table table-striped table-bordered bootstrap-datatable datatable">
   
   <tbody>
   <tr><td colspan="2"><?php if(@$_SESSION["_err"]!=""){ echo "<h3 style=\"color:red\">".$_SESSION["_err"]."</h3>"; $_SESSION["_err"]=""; } ?></td></tr>
   
   <tr>
   		<td>Manager Name</td>
        <td>
 <div class="control-group">
    <div class="controls">
<input type="hidden" name="command" id="command" value="insert_head_record" />
        <select name="repid" id="repid" data-rel="chosen"> 
            <option value="">---Select Rep---</option>   
            <?php
$select= mysql_query("SELECT * FROM representative where rep_id!='0' ".$repmgrid3." ");
while($row= mysql_fetch_array($select))
{
?>
<option value="<?php echo $row['id']; ?>"><?php echo $row['rep_name']; ?></option>
<?php
}
?>
</select>
</div>
</div></td>
   </tr>
   
    		<tr>
        		<td>Select (ONE / MULTIPLE) Rep(s)</td>  
            	<td>
                <?php  ?>
                	<input type="text" id="demo-input-local" name="pins" />
                    <script type="text/javascript">
                    $(document).ready(function() {
                        $("#demo-input-local").tokenInput([
                        <?php $sql = mysql_query("SELECT *  FROM `representative`  ".$repmgrid2." "); while($P=mysql_fetch_object($sql)){ ?>
                           {id: <?php echo $P->id ?>, name: "<?php echo trim($P->rep_name); ?>"},
                        <?php } ?>
                        ]);
                    });
                    </script>
                    <?php 
                    if($_REQUEST['rep_id']!=''){
                    $RY=mysql_query("SELECT *  FROM `assigningreptomanager` where managerid='".$_REQUEST['rep_id']."' "); while($YR=mysql_fetch_object($RY)){ ?>
                       <?php
                        $sqlbeat1=mysql_query("SELECT * from representative where id='".$YR->repid."'");
                        $row_beat1=mysql_fetch_object($sqlbeat1);
                      ?>
<table width="100%">
<tr><td width="40%"><?=$row_beat1->rep_name; ?></td><td><a class="baba" href="#" title="<?php echo $_REQUEST['rep_id'].",".$YR->id; ?>"><img src="img/uploadify-cancel.png" width="16" height="16"></a></td></tr>
</table>
<?php } } ?>
                </td>
                <tr><td colspan="2"><input type="submit" name="submit" id="submit" value="submit"></td></tr>
            </tr>                    
    </tbody>
        </table>
        
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        	<tr><th>Manager Name</th><th>Rep Name</th></tr>
            <?php $SQL=mysql_query("SELECT * FROM representative where rep_id!='0' ".$repmgrid3." "); while($R=mysql_fetch_object($SQL)){ ?>
            <tr>
            	<td><?=strtoupper($R->rep_name); ?> &nbsp;<a href="manage_rep.php?rep_id=<?=$R->id; ?>"><img src="img/2.png" width="20" height="20"></a>&nbsp;&nbsp;<a href="manage_rep.php?mode=tdelete&t_id=<?=$R->id; ?>"><img src="img/uploadify-cancel.png" width="16" height="16" title=""></a></td><td><?php  $RY=mysql_query("SELECT * FROM assigningreptomanager WHERE assigningreptomanager.managerid='".$R->id."' "); while($YR=mysql_fetch_object($RY)){ ?>
                	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                    	<!-- <tr><td><?=$YR->beadid; ?></td></tr> -->
                      <?php
                        $sqlbeat=mysql_query("SELECT * from representative where id='".$YR->repid."' ".$repmgrid2." ");
                        $row_beat=mysql_fetch_object($sqlbeat);
                      ?>
                      <tr><td><?=$row_beat->rep_name; ?></td></tr>
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
<script type="text/javascript">
	$(document).ready(function(){
	$(".baba").click(function(){
   
	window.location.href="manage_rep.php?mode=delete&rep_id=<?php echo @$_REQUEST['id']; ?>&beadid=<?php echo @$_REQUEST['beadid']; ?>&t_id="+$(this).attr('title');	
		});	
	
	});
		
</script>
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
    

</body>
</html>
<?php
}
?>