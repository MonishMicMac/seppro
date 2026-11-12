<?php
	include("../include/connect.php");
        include("../include/select.php");
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
        $ad=new select1();
		
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
<!----------------------------------------------------------------------------->
<?php
if(@$_REQUEST["mode"]=="save")
{
	mysql_query("INSERT INTO mst_submenu(mainmenu_id,submenu_title,submenu_url) VALUES ('".$_REQUEST["main_menu"]."','".$_REQUEST["sub_menu_title"]."','".$_REQUEST["sub_menu_url"]."')");  
	header("location:sub_menu.php?main_menu=".$_REQUEST["main_menu"]."");  
	die();
}

?>
<div class="contentRight" align="center" style="height: 150px;" >
    <span style="font-weight: 200;color:blue;"><?php if(isset($_REQUEST['command'])){ echo "EDIT "; }else{ echo "ADD "; }?> MENU</span>

<div style="margin-top: 3%;">
<form name="frm" action="?mode=save" method="post">    
    <table width="50%" border="1">

<tr>
    <td>Main Menu</td>
    <td>:</td>
    <td>
        <?php $SQL = mysql_query("SELECT * FROM mst_mainmenu"); ?>
        <select name="main_menu" id="main_menu" style="width: 250px;">
            <option value="">---Select Main Menu---</option>
         <?php while($row_st=mysql_fetch_object($SQL)){ ?>
            <option value="<?=$row_st->mainmenu_id;?>"><?=$row_st->main_menu;?></option>              
         <?php } ?>
        </select>
        <script>document.getElementById("main_menu").value="<?=@$_REQUEST["main_menu"]; ?>";</script>
    </td> 
</tr>     

<tr>
    <td>Sub Menu</td>
    <td>:</td>
    <td><input type="text" name="sub_menu_title" id="menu_title" maxlength="250" required/></td> 
</tr>  
        
<tr>
    <td></td>
    <td></td>
    <td></td> 
</tr>
<tr>
    <td>Sub Menu URL</td>
    <td>:</td>
    <td><input type="text" name="sub_menu_url" id="menu_url" maxlength="250" required/></td> 
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
    <td colspan="3" align="center">
        <input type="submit" name="Submit" value="Add Menu"/></td>
</tr>   
</table>
</form>
<div id="res"></div>    
</div>  
</div>
<!----------------------------------------------------------------------------->

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

