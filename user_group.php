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
//echo "delete from user_group where id='".$_REQUEST['did']."'"; exit;
if(@($_REQUEST['mode'])=='DELETE')
{
//echo "delete from user_group where id='".$_REQUEST['id']."'"; exit;
mysql_query("delete from user_group where id='".$_REQUEST['id']."'")or die(mysql_error());
echo "<script>alert('Deleted Successfully');window.location.href='user_group.php';</script>";
}
include("encrypt.php");
include("include/select.php");
$fun = new select1;
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
<h2><i class="icon-user"></i> User Group</h2>
<div class="box-icon">
  <a href="add_user_group.php" class="btn btn-primary" style="width: 100px !important;">Add</a>
</div>
</div>
<div class="box-content">

<table class="table table-striped table-bordered ">
<thead>
<tr>
<th>S.NO</th>
<th>User Name</th>
<!--<th>Division</th>-->
<th>Status</th>
<th>Action</th>
</tr>
</thead>   
<tbody> 
<?php
$i=1;
  $SQL=mysql_query("SELECT * FROM user_group")or die(mysql_error());
  while($row=mysql_fetch_array($SQL))
  {
  ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['status']; ?></td>  
            <td>
			<a class="btn btn-info" href="add_user_group.php?aid=<?php echo $row['id']; ?>"><i class="icon-edit icon-white"></i>Edit</a>
            <!-- <a class="btn btn-danger" href="javascript:void(0);" did="<?php echo $row['id']; ?>"  onclick="delme(this);"><i class="icon-trash icon-white"></i> Delete</a> -->
			</td>
        </tr>
		<?php $i++;} ?>
</tbody>
</table>    
<?php if($_REQUEST['aid']!='')
{
 ?>

  <table style="width:100%;">
  <?php 
  $sql=mysql_query("SELECT * FROM user_group where id='".$_REQUEST['aid']."'")or die(mysql_error());
  $row1=mysql_fetch_array($sql);
?>
   <form action="" method="post">
   <input type="hidden" name="praba" value="<?php echo $_REQUEST['aid']?>">
            <tr>
                
                <td style="text-transform:uppercase;font-size:12px;font-family:serif;">User Group Name</td>
                <td>:</td>
                <td>
                  <input type="text" class="form-control" name="nam" value="<?php echo $row1['name'];?>">
                </td>
                <!--<td><Label style="text-transform:uppercase;font-size:12px;font-family:serif;">Division User Group</label></td>
                <td>:</td>
                <td><select id="selectError1" multiple class="form-control" data-rel="chosen">
                            <option>Option 1</option>
                            <option selected>Option 2</option>
                            <option>Option 3</option>
                            <option>Option 4</option>
                            <option>Option 5</option>
                        </select></td>-->
                <td></td>
            </tr>
			<tr>
			<td>
			<Label style="text-transform:uppercase;font-size:12px;font-family:serif;">Status</label>
			</td>
			<td>:</td>
			<td>
			 <div class="controls">
                        <select id="selectError" data-rel="chosen" name="select">
                            <option value="">Select</option>
                            <option value="Y" <?php if($row1['status']=="Y"){echo "selected";}?>>Active</option>
                            <option value="N" <?php if($row1['status']=="N"){echo "selected";}?>>Inactive</option>
                            
                        </select>
                    </div>
			</td>
			</tr>


            <tr>
                
                <td colspan="8" id="error_append_search" style="color: #ce3737;text-align: center"></td>
            </tr>
            
			<td><input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit"/></td>	
			</form>
        </table> 
<?php  
if(isset($_REQUEST['submit'])=='submit')
{

mysql_query("update user_group set name='".$_REQUEST['nam']."', status='".$_REQUEST['select']."' where id='".$_REQUEST['praba']."'");
echo "<script>alert('Upated Successfully');window.location.href='user_group.php';</script>";
}

} ?>		

  	
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
<script>
function delme(e)
{
if(confirm('Sure To Remove This Record ?'))
{
 window.location.href='user_group.php?id='+$(e).attr('did')+"&mode=DELETE";
}
}
</script>	
</body>
</html>
<?php
}
?>
