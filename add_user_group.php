<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
if(!isset($_SESSION['id'])){
	echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
} else {

if(@$_REQUEST["submit"]=="submit"){

    // $subid=implode(',',$_REQUEST['check']);
    // echo $subid;
     if(isset($_REQUEST["aid"])!='')
  {
  
    mysql_query("DELETE from tbl_previleges where user_group_id='".$_REQUEST['aid']."'")or die(mysql_error());
    $subids = $_REQUEST["check"];
    foreach($subids as $subid)
    {
        echo $subid;
        $submenu=mysql_query("SELECT * FROM mst_submenu WHERE submenu_id='".$subid."'")or die(mysql_error());
        $submenu_row=mysql_fetch_array($submenu);
        mysql_query("INSERT INTO tbl_previleges(user_group_id,mainmenu_id,submenu_id)values('".$_REQUEST["aid"]."','".$submenu_row['mainmenu_id']."','".$subid."')")or die(mysql_error());

       // mysql_query("UPDATE tbl_previleges SET user_group_id='".$LastId."' WHERE mainmenu_id='".$submenu_row['mainmenu_id']."' AND submenu_id='".$subid."'")or die(mysql_error());

        

    }
    
    echo "<script>alert('Update Successfully');window.location.href='user_group.php';</script>";
  }
  else
  {
    mysql_query("INSERT INTO user_group(name,status)values('".$_REQUEST['name']."','".$_REQUEST['select']."')")or die(mysql_error());
     $LastId = mysql_insert_id();
    $subids = $_REQUEST["check"];
    foreach($subids as $subid)
    {
        echo $subid;
        $submenu=mysql_query("SELECT * FROM mst_submenu WHERE submenu_id='".$subid."'")or die(mysql_error());
        $submenu_row=mysql_fetch_array($submenu);
        mysql_query("INSERT INTO tbl_previleges(user_group_id,mainmenu_id,submenu_id)values('".$LastId."','".$submenu_row['mainmenu_id']."','".$subid."')")or die(mysql_error());

       // mysql_query("UPDATE tbl_previleges SET user_group_id='".$LastId."' WHERE mainmenu_id='".$submenu_row['mainmenu_id']."' AND submenu_id='".$subid."'")or die(mysql_error());
        

    }
    echo "<script>alert('Added Successfully');window.location.href='user_group.php';</script>";
}



    // mysql_query("INSERT INTO user_group(name)values('".$_REQUEST['name']."')")or die(mysql_error());
    // echo "<script>alert('INSERT Successfully');window.location.href='user_group.php';</script>";
    // for(i=0; i<count($_REQUEST['check[]');$i++;)
    // {
    // $exploded = multiexplode(array(",",".","|",":"),$text);
    // mysql_query("INSERT INTO user_group(name)values('".$_REQUEST['name']."')")or die(mysql_error());
    
    // }
    
    
}
  $sql5=mysql_query("SELECT * FROM user_group where id='".$_REQUEST['aid']."'")or die(mysql_error());
  $row5=mysql_fetch_array($sql5);
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
    
<script type="text/javascript">
    function valid1()
    {
    var x=document.getElementById("rep_id").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Representative Name");
    return false; 
    }
    return true;
    }

    function valid2()
    {
    var x=document.getElementById("rep_id1").value;
    if(x === "null" || x === "")
    {
    alert("Please Select Representative Name");
    return false; 
    }
    return true;
    }
</script>

    
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
<h2><i class="icon-edit"></i>Download & Upload Customer Report</h2>
<div class="box-icon">
</div>
</div>
<div class="box-content">
    <form action="" >
        <?php  if($_REQUEST["aid"])
    {?>
        <input type="hidden" class="form-control" id="aid" name="aid" value="<?php echo $row5['id'];?>">
        <?php }
        ?>

        <table style="width:100%;">
            <tr>                
                <td style="text-transform:uppercase;font-size:12px;font-family:serif;">User Group Name</td>
                <td>:</td>
                <td>
                  <input type="text" class="form-control" id="" name="name" value="<?php echo $row5['name'];?>">
                </td>             
             <td>
            <Label style="text-transform:uppercase;font-size:12px;font-family:serif;">Status</label>
            </td>
            <td>:</td>
            <td>
             <div class="controls">
                        <select id="selectError" data-rel="chosen" name="select">
                            <option value="">Select</option>
                             <option value="Y" <?php if($row5['status']=="Y"){echo "selected";}?>>Active</option>
                            <option value="N" <?php if($row5['status']=="N"){echo "selected";}?>>Inactive</option>
                            
                        </select>
                    </div>
            </td>
            </tr>
        </table>
        <h3 style="text-align:center;">PERMISSION</h3>
 <table id="rep" class="table table-striped table-bordered">
  <?php
  $i = 1;
  $SQL=mysql_query("SELECT * FROM mst_mainmenu")or die(mysql_error());
  while($row=mysql_fetch_array($SQL))
 {
 
   if ($i % 2 == 1) {
       ?><tr> <?php 
    }  ?>
  <td ><span style="color:#f4429e;font-size:16px;font-family: initial;text-transform:uppercase;"><?php echo $row['main_menu'];  ?></span>
		<br/><br/> <?php
		$SQL1=mysql_query("SELECT * FROM mst_submenu WHERE mainmenu_id='".$row['mainmenu_id']."'")or die(mysql_error());
while($row1=mysql_fetch_array($SQL1))
 { $SQL7=mysql_query("SELECT * FROM tbl_previleges WHERE user_group_id='".$row5['id']."' AND submenu_id='".$row1['submenu_id']."'")or die(mysql_error()); 
 $row7=mysql_fetch_array($SQL7);
  if($_REQUEST["aid"])
    {?>
 <label class="checkbox-inline"><input type="checkbox" name="check[]" id="inlineCheckbox1" value="<?php echo $row1['submenu_id']; ?>" <?php   if($row7['submenu_id']==$row1['submenu_id']){ ?> checked <?php } else { ?> unchecked <?php }?>> <span style="text-transform:uppercase;font-size:12px;font-family:serif;"><?php echo $row1['submenu_title']; ?></span></label>
 <?php } else
 { ?>
<label class="checkbox-inline"><input type="checkbox" name="check[]" id="inlineCheckbox1" value="<?php echo $row1['submenu_id']; ?>"> <span style="text-transform:uppercase;font-size:12px;font-family:serif;"><?php echo $row1['submenu_title']; ?></span></label>
<?php
 }
 ?>
	
	<br/>
	<?php
 } ?></td>
	<?php
		  if ($i % 2 == 0) {
       ?> </tr> <?php
        
    }
	$i ++;
	} ?>
		
		</table>
		    
	   <div class="form-actions">
<input type="submit" class="btn btn-primary" name="submit" id="submit" value="submit"/></div>

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
?>
