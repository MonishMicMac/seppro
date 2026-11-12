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
<div class="clr"></div>
<div class="contentLeft">
<span class="headers">
<h2>Administrator</h2>
</span>
<div class="clr"></div>
<?php
include("include/menu.php");
?>
</div>
<style>
    .main
    {
        height:100%;
        width:100%;
        border:1px solid lightskyblue;
    }
    .sub_div
    {
        float:left;
        height:49.5%;
        width:49.5%;
        border:1px solid red;
    }
</style>
<div class="contentRight">
<div class="mContainer">
    <div class="main">
        <div class="sub_div">
            select states :
                            <select name="cars" multiple>
                                <option value="volvo">Volvo</option>
                                <option value="saab">Saab</option>
                                <option value="opel">Opel</option>
                                <option value="audi">Audi</option>
                            </select>
        </div>  
        <div class="sub_div">
        </div>
        <div class="sub_div">
        </div>  
        <div class="sub_div">
        </div>
    </div>    
<div class="clr"></div>
</div>
</div>
<div class="clr"></div>
</div>
<?php
include("include/footer.php")
?>
</div>
</body>
</html>
<?php
}
?>
