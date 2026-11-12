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
<h2>Admin</h2>
</span>
<div class="clr"></div>
<!--<ul>
	<li><a href="#" >Admin</a></li>
    <li><a href="#">Master</a></li>
    <li><a href="#">Quotation</a></li>
     <li><a href="#">Billing</a></li>
      <li><a href="#">Payment</a></li>
    <li><a href="#">Reports</a></li>
</ul>-->


<?php
include("include/menu.php");
?>

</div>
<div class="contentRight">

<div class="mContainer">
<!--<div class="mCover">
<a href="add_admin.php"class="rMenu1"></a>
<div class="dCription">Create Admin</div>
</div>-->
<div class="mCover">
<a href="add_marketer.php"class="rMenu2"></a>
<div class="dCription">Add Admin</div>
</div>

<div class="mCover">
<a href="site_config.php"class="rMenu3"></a>
<div class="dCription">Logo</div>
</div>


<div class="mCover">
<a href="site_config.php"class="rMenu4"></a>
<div class="dCription">Footer</div>
</div>
<div class="clr"></div>



<div class="mCover">
<a href="change_pass.php"class="rMenu5"></a>
<div class="dCription">Change Password</div>
</div>

<div class="mCover">
<a href="menu.php"class="rMenu2"></a>
<div class="dCription">Menu Level</div>
</div>

<div class="mCover">
<a href="../distributor_pincode_excel_no_dist.php"class="rMenu7"></a>
<div class="dCription">Download Excel</div>
</div>

<div class="mCover">
</div>
<div class="mCover">
<a href="logout.php"class="rMenu6"></a>
<div class="dCription">Logout</div>
</div>
</div>


</div>
<div class="clr"></div>
</div>
<?php
include("include/footer.php")
?>
</div>
</div>
</body>
</html>
<?php
}
?>
