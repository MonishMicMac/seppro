<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id']))
{

    echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
require_once("include/select.php");
$ad=new select1();
$count_mat=$ad->count1("dist_prod", "where status = '2'", "");
$count_umat=$ad->count1("dist_prod", "where status = '1'", "");
$matched=$ad->view("dist_prod", "where status = '2'", "");
$unmatched=$ad->view("dist_prod", "where status = '1'", "");

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
    <script type="text/javascript" src="jquery.js"></script>

<body>
<?php include("include/header.php"); ?>
<div class="container-fluid">
<div class="row-fluid">
<?php include("include/menu.php"); ?>
 
<div id="content" class="span10">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>View Matched Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<div class="form-horizontal">   
<div class="span7">
<div class="control-group">
    <label class="control-label" for="typeahead">
         Matched Products
    </label>
    <div class="controls">
        <input type="text" name="head_no" id="head_no" value="<?=$count_mat;?>"readonly/>&nbsp;&nbsp;<a class="btn btn-primary" id="mat">go</a>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="typeahead">
        Unmatched Products
    </label>
    <div class="controls">
        <input type="text" name="head_no" id="head_no" value="<?=$count_umat;?>"readonly/>&nbsp;&nbsp;<a class="btn btn-primary" id="unmat">go</a>
    </div>
</div>
</div> 
</div>
</div>
</div>
</div>
</div>
    
 
<div class="span10" id="unmatched">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>View Matched Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form name="frm" id="frm" action="product_match_save.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="command" id="command" value="update_product" />
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Marketer Id</th>
<th>Distributor Id</th>
<th>Product Name</th>
<th>Product ID</th>
<th>Present Product</th>
<th>Status</th>
</tr>
</thead>   
<tbody>
<?php
$i=1;
while($row_mat=mysql_fetch_array($unmatched))
{
?>
<tr>
<td><input type="hidden" name="p_id[<?=$i;?>]" id="p_id[<?=$i;?>]" value="<?=$row_mat['id']; ?>" /><?php echo $row_mat['dist_id']; ?></td>
<td><?php echo $row_mat['mark_id']; ?></td>
<td><?php echo $row_mat['pro_name']; ?></td>
<td><?php echo $row_mat['dis_pro_id']; ?></td>
<td>
    <select  id="our_id[<?=$i;?>]" name="our_id[<?=$i;?>]" data-rel="chosen">
        <option value="">---select---</option>
        <?php
        $product=$ad->view("product","","");
        $count_product=$ad->count1("product","","");
        if($count_product > 0)
        {
           while($row_pro=mysql_fetch_array($product))
           { ?>
        <option value="<?=$row_pro['id'];?>"><?=$row_pro['pro_name'];?></option>           
    <?php  }
        }
        else
        {   ?>
        <option value="">No product Avaliable</option>   
<?php   }
        ?>
    </select>
</td>
<td><?php if($row_mat['status'] == '1'){ echo "Not Matched"; }else{ echo "Matched"; } ?></td>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
    <div class="modal-footer">
         <input type="submit" class="btn btn-success" value="Update"/> 
    </div>  
</form>    
</div>
</div>
</div>
</div>    
    

<div class="span10" id="matched" style="display:none;">
<div class="row-fluid sortable">
<div class="box span12">
<div class="box-header well" data-original-title>
<h2><i class="icon-edit"></i>View Matched Product</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
<form name="frm1" id="frm" action="product_match_save.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="command" id="command" value="update_product_1" />
<table class="table table-striped table-bordered bootstrap-datatable datatable">
<thead>
<tr>
<th>Marketer Id</th>
<th>Distributor Id</th>
<th>Product Name</th>
<th>Product ID</th>
<th>Present Product</th>
<th>Status</th>
</tr>
</thead>   
<tbody>
<?php
$i=1;
while($row_mat=mysql_fetch_array($matched))
{
?>
<tr>
<td><input type="hidden" name="p_id[<?=$i;?>]" id="p_id[<?=$i;?>]" value="<?=$row_mat['id']; ?>" /><?php echo $row_mat['dist_id']; ?></td>
<td><?php echo $row_mat['mark_id']; ?></td>
<td><?php echo $row_mat['pro_name']; ?></td>
<td><?php echo $row_mat['dis_pro_id']; ?></td>
<td>
    <select  id="our_id_m[<?=$i;?>]" name="our_id_m[<?=$i;?>]" data-rel="chosen">
        <option value="">---select---</option>
        <?php
        $product=$ad->view("product","","");
        $count_product=$ad->count1("product","","");
        if($count_product > 0)
        {
           while($row_pro=mysql_fetch_array($product))
           { ?>
        <option value="<?=$row_pro['id'];?>" <?php if($row_pro['id'] === $row_mat['our_id']){ echo "Selected" ;}?>><?=$row_pro['pro_name'];?></option>           
    <?php  }
        }
        else
        {   
            ?>
        <option value="">No product Avaliable</option>   
<?php   }
        ?>
    </select>
</td>
<td><?php if($row_mat['status'] == '1'){ echo "Not Matched"; }else{ echo "Matched"; } ?></td>
</tr>
<?php
$i++;
}
?>
</tbody>
</table>
    <div class="modal-footer">
         <input type="submit" class="btn btn-success" value="Update"/> 
    </div>  
</form>    
</div>
</div>
</div>
</div>        
    
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
        <script type="text/javascript">
           $(function() {
             $("#unmat").click(function(){
                 $("#unmatched").toggle();
             });
             $("#mat").click(function(){
                 $("#matched").toggle();
             });
           });
        </script>
</body>
</html>
<?php
}
