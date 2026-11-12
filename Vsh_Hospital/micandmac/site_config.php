<?php
	include("../include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	if(!isset($_SESSION['id']))
	{
	echo "<script type='text/javascript'>window.location='index.php'</script>"; 
	}
	else
	{
	$admin=mysql_query("select * from login where id='$id'");
	$admin_row=mysql_fetch_array($admin);
	$username=$admin_row['username'];
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/title.php"); ?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/jquery.treeview.css" />

<script src="js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="js/jquery.treeview.js" type="text/javascript"></script>
<script src="js/jquery.cookie.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("li#con").mouseover(function(){
  $("li#con,li#con1,li#con2,li#con3").fadetoggle(2000,0);
  });
});
</script>

<script type="text/javascript">
	$(function() {
		$("#tree").treeview({
			collapsed: true,
			animated: "medium",
			control:"#sidetreecontrol",
			prerendered: true,
			persist: "location"
		});
	})	
</script>

</head>

<body>
<div id="wrapper">
<?php include("include/header.php"); ?>
<div class="clr"></div>
<div class="contentArea">
<!--<span><a href="#"><img src="images/ico.png" style="margin:50px 0 0 0px; float:left"  /></a></span>-->
<div class="clr"></div>
<div class="contentLeft">
<span class="headers">
<h2>Master</h2>
</span>
<div class="clr"></div>
<?php include("include/menu.php"); ?>
</div>

<div class="contentRight">
<form name="frm" action="save.php" method="post" enctype="multipart/form-data" />
<input type="hidden" name="command" id="command" value="site_conf" />
<div class="mTable">
<h2>Site Configuration</h2>
	<table width="690" height="243" border="1">
  	<tr>
    <td width="158">Site Logo<!--<span class="highlight">*</span>--></td>
    <td width="6">:</td>
    <td colspan="5">
    <input type="file" name="logo" id="logo" />
    
      </td>
  	</tr>
  	<tr>
    <td>Favicon</td>
    <td>:</td>
    <td colspan="5"> <input type="file" name="favicon" id="favicon" />  </td>
  	</tr>
  	<tr>
    <td>Footer Text</td>
    <td>:</td>
    <td colspan="5"><textarea name="footer" id="textarea" cols="45" rows="5" style="width: 333px; height: 85px; resize:none;" ></textarea></td>
  	</tr>
    <tr>
    <td></td>
    <td></td>
    <td width="57">  <input type="submit" name="submit" class="btn" id="button" value="ADD" />    </td>
    <td width="57"><input type="reset" class="btn" name="button4" id="button4" value="RESET" /></td>
    <td width="57"></td>
    <td width="107"></td>
    <td width="202"></td>
 	</tr>
	</table>

  
  <div class="searchDetail">
  <table width="700" border="1">
  <tr>
  	  <th>Logo</th>
      <th>Favicon</th>
      <th>Footer</th>
   </tr>
  <?php
  $add=mysql_query("select * from site_conf");
 $num_add=mysql_num_rows($add);
 if($num_add>0)
 { 
 while($row_add=mysql_fetch_array($add))
 {
 $logo_name=$row_add['logo'];
 $favicon_name=$row_add['favicon'];
 $footer=$row_add['footer'];
  ?>
  <tr>
      <td><img src="../logo/<?php echo $logo_name; ?>" style="height:50%;width:50%;"/></td>
      <td><img src="../favicon/<?php echo $favicon_name; ?>" style="height:50%;width:50%;" /></td>
      <td><?php echo  $footer ?></td>
  </tr>
  <?php
  }
  }
  else
  {
  ?>
  <tr><td colspan="5"><span style="color:#FF0000; font-weight:bold; font-size:14px;">Site Setting not yet Designed</span></td></tr>
  <?php
  }
  ?>
 
  </table>
  </div></div>
  </form>
</div>

</div>
<div class="clr"></div>

<?php include("include/footer.php"); ?>
</div>

</body>
</html>
<?php
}
?>