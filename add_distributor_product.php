<?php
	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
        $distributor_id=$_SESSION['id'];
	if(!isset($_SESSION['id']))
	{

		echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
	}
	else
	{

require_once("include/select.php");
$ad=new select1();
$dis_product=$ad->view('dist_prod','','order by id desc');
$count_product=$ad->count1('dist_prod','','order by id desc');
if($count_product > 0)
{
$row_dis=mysql_fetch_object($dis_product);
$product_id=$row_dis->pro_id+1;
}
else
{
   $product_id="100001"; 
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

</head>

<body>

<?php include("include/header.php"); ?>

<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
			
			
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
<input type="hidden" name="mark_id" id="mark_id" value="<?php echo $m_id16; ?>" />
<input class="input-xlarge focused"  type="hidden" name="dis_pro_no" id="dis_pro_no" value="<?=$product_id;?>" readonly/>
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
        <input class="input-xlarge focused"  type="text" name="dis_pro_no" id="dis_pro_no" value="<?php // echo $product_id;?>" readonly/>
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
		
</body>
</html>
<?php
}

