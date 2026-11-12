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
	if(@$_REQUEST["tertiary_id"]==""){
		$Ex=mysql_query("SELECT * FROM mst_tertiary WHERE tertiary_name='".$_REQUEST["tertiary_name"]."'");
		$ExCnt = mysql_num_rows($Ex);
		if($ExCnt>0){
			$_SESSION["_err"] = "Already Existing Tertiary!!!";
		}
		if($ExCnt==0){
			mysql_query("INSERT INTO mst_tertiary(state_id,tertiary_name) VALUES('".$_REQUEST["state_id"]."','".$_REQUEST["tertiary_name"]."')");
			$TID = mysql_insert_id();
			$pin = explode(",",$_REQUEST["pins"]);
			foreach($pin as $p){
				mysql_query("INSERT INTO tbl_tertiary(state_id,tertiary_id,tertiary_pin) VALUES('".$_REQUEST["state_id"]."','".$TID."','".$p."')");		
			}
			$_SESSION["_err"] = "Tertiary Created...";
		}
	}
	if(@$_REQUEST["tertiary_id"]!=""){
		mysql_query("UPDATE mst_tertiary SET tertiary_name='".$_REQUEST["tertiary_name"]."' WHERE tertiary_id='".$_REQUEST["tertiary_id"]."'");		
		$pin = explode(",",$_REQUEST["pins"]);
		foreach($pin as $p){
			mysql_query("INSERT INTO tbl_tertiary(state_id,tertiary_id,tertiary_pin) VALUES('".$_REQUEST["state_id"]."','".$_REQUEST["tertiary_id"]."','".$p."')");		
		}
		$_SESSION["_err"] = "Tertiary Updated...";
	}
	header("location:mst_territory.php");	
	die();
}
if(@$_REQUEST["mode"]=="delete"){
	$teritary = explode(",",$_REQUEST["t_id"]);
	mysql_query("DELETE FROM tbl_tertiary WHERE t_id=".$teritary[0]."");
	mysql_query("DELETE FROM rep_area WHERE tertiary_pin=".$teritary[1]."");
	mysql_query("UPDATE areawise_temp SET rep_id=0 WHERE pin_id=".$teritary[1]."");
	mysql_query("UPDATE tbl_customer_master SET rep_id=0 WHERE pin_id=".$teritary[1]."");
	mysql_query("UPDATE doctors SET rep_id=0 WHERE doc_pin_id='".$teritary[1]."'");
	$_SESSION["_err"] = "Tertiary Pincode Deleted...";
	header("location:mst_territory.php?tertiary_id=".$_REQUEST["tertiary_id"]."&state_id=".$_REQUEST["state_id"]."");	
	die();
}
if(@$_REQUEST["mode"]=="tdelete"){	
	$SQL=mysql_query("SELECT tertiary_pin FROM tbl_tertiary WHERE tertiary_id=".$_REQUEST["t_id"]."");
	while($T=mysql_fetch_object($SQL)){	
		mysql_query("UPDATE areawise_temp SET rep_id=0 WHERE pin_id=".$T->tertiary_pin."");
		mysql_query("UPDATE tbl_customer_master SET rep_id=0 WHERE pin_id=".$T->tertiary_pin."");
		mysql_query("UPDATE doctors SET rep_id=0 WHERE doc_pin_id='".$T->tertiary_pin."'");
	}
	mysql_query("DELETE FROM mst_tertiary WHERE tertiary_id=".$_REQUEST["t_id"]."");
	mysql_query("DELETE FROM tbl_tertiary WHERE tertiary_id=".$_REQUEST["t_id"]."");
	mysql_query("DELETE FROM rep_area WHERE tertiary_id=".$_REQUEST["t_id"]."");
	$_SESSION["_err"] = "Tertiary Deleted...";
	header("location:mst_territory.php");	
	die();
}
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
if($_REQUEST["tertiary_id"]!=""){

	$T=mysql_query("SELECT * FROM  mst_tertiary WHERE tertiary_id=".$_REQUEST["tertiary_id"]."");
	$TR=mysql_fetch_object($T);
}
$fun = new select1;
$res=$fun->view('distributor','where m_id16='.$m_id16,'order by id desc');
if($_REQUEST["tertiary_id"]!=""){

	$T=mysql_query("SELECT * FROM  mst_tertiary WHERE tertiary_id=".$_REQUEST["tertiary_id"]."");
	$TR=mysql_fetch_object($T);
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
<h2><i class="icon-user"></i>Tertiary Assign</h2>
<div class="box-icon">

</div>
</div>

<div class="box-content">
   <!-- BODY CONTENT - Start -->
   <form name="thisForm" method="post" action="?mode=save" onSubmit="return fnValidate()">
   <input type="hidden" name="tertiary_id" value="<?=@$_REQUEST["tertiary_id"]; ?>">
   <table id="rep" class="table table-striped table-bordered bootstrap-datatable datatable">
   
   <tbody>
   <tr><td colspan="2"><?php if(@$_SESSION["_err"]!=""){ echo "<h3 style=\"color:red\">".$_SESSION["_err"]."</h3>"; $_SESSION["_err"]=""; } ?></td></tr>
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
   <tr><td>Tertiary Name</td><td><input type="text" id="tertiary_name" name="tertiary_name" required value="<?=$TR->tertiary_name; ?>" /></td></tr>
   
    		<tr>
        		<td>Select (ONE / MULTIPLE) Pincode(s)</td>  
            	<td>
                <?php  ?>
                	<input type="text" id="demo-input-local" name="pins" />
                    <script type="text/javascript">
                    $(document).ready(function() {
                        $("#demo-input-local").tokenInput([
                        <?php $sql = mysql_query("SELECT * FROM master_pincode,pincode_list,master_state,master_district WHERE  master_state.state_id = pincode_list.state_id AND master_pincode.pin_id=pincode_list.pin_id AND master_state.state_id='".$_REQUEST["state_id"]."' AND master_district.district_id=pincode_list.dist_id GROUP BY pincode_list.pin_id"); while($P=mysql_fetch_object($sql)){ ?>
                            {id: <?php echo $P->pin_id ?>, name: "<?php echo $P->pincode."-".$P->district_name."-".$P->state_name; ?>"},
                        <?php } ?>
                        ]);
                    });
                    </script>
                    <?php $RY=mysql_query("SELECT pincode,area_name,tbl_tertiary.t_id,tbl_tertiary.tertiary_pin FROM tbl_tertiary,pincode_list WHERE tertiary_id='".$TR->tertiary_id."' AND tbl_tertiary.tertiary_pin=pincode_list.pin_id GROUP BY pincode_list.pin_id ORDER BY tertiary_pin"); while($YR=mysql_fetch_object($RY)){ ?>
                	<table width="100%">
                    	<tr><td width="40%"><?=$YR->pincode."-".$YR->area_name; ?></td><td><a class="baba" href="#" title="<?php echo $YR->t_id.",".$YR->tertiary_pin; ?>"><img src="img/uploadify-cancel.png" width="16" height="16"></a></td></tr>
                    </table>
                    <?php } ?>
                </td>
                <tr><td colspan="2"><input type="submit" name="submit" id="submit" value="submit"></td></tr>
            </tr>                    
    </tbody>
        </table>
        
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        	<tr><th>Tertiary Name</th><th>Tertiary Pins</th></tr>
            <?php $SQL=mysql_query("SELECT * FROM mst_tertiary"); while($R=mysql_fetch_object($SQL)){ ?>
            <tr>
            	<td><?=strtoupper($R->tertiary_name); ?> &nbsp;<a href="mst_territory.php?tertiary_id=<?=$R->tertiary_id; ?>&state_id=<?=$R->state_id; ?>"><img src="img/2.png" width="20" height="20"></a>&nbsp;&nbsp;<a href="mst_territory.php?mode=tdelete&t_id=<?=$R->tertiary_id; ?>"><img src="img/uploadify-cancel.png" width="16" height="16" title=""></a></td><td><?php $RY=mysql_query("SELECT pincode,area_name FROM tbl_tertiary,pincode_list WHERE tertiary_id='".$R->tertiary_id."' AND tbl_tertiary.tertiary_pin=pincode_list.pin_id GROUP BY pincode_list.pin_id ORDER BY tertiary_pin"); while($YR=mysql_fetch_object($RY)){ ?>
                	<table class="table table-striped table-bordered bootstrap-datatable datatable">
                    	<tr><td><?=$YR->pincode."-".$YR->area_name; ?></td></tr>
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
			window.location.href="mst_territory.php?mode=delete&state_id="+<?php echo @$_REQUEST["state_id"]; ?>+"&tertiary_id="+<?php echo @$_REQUEST["tertiary_id"]; ?>+"&t_id="+$(this).attr('title')+"";	
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