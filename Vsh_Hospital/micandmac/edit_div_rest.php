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
        $ds_id=$_REQUEST['ds_id'];
        $ed_ds=$ad->view("tbl_division_state","where ds_id='$ds_id'","");
        $row_ed=mysql_fetch_array($ed_ds);
        $div_name=$ad->get_admin_division($row_ed['division_id']);
        $state_name=$ad->get_admin_state($row_ed['state_id']);
        $no_of_dis=$row_ed['ds_no_distributors'];
        
 if(isset($_POST['EDIT']))
 {
    $ds_id=$_POST['ds_id'];
    $div_id=$_POST['div_id'];
    $state_id=$_POST['state_id'];
    $no_of_dis=$_POST['no_of_dis'];
    mysql_query("update tbl_division_state set ds_no_distributors = '$no_of_dis' where ds_id = '$ds_id'")or die(mysql_error());
    echo "<script type='text/javascript'>alert('Edited sucessfully');window.location.href='restriction_master.php';</script>";
 }
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/title.php"); ?>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/jquery.treeview.css" />
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
<div class="contentRight" align="center" style="height:auto;border: none;" align="center" >
    <style>
        td,tr,table
        {
            padding: 2%;
        }
    </style>
    <form name="dis" method="post" action="?" enctype="multipart/form-data">
        <table style="width:60%;margin-top: 15%;">
            <tr>
                <td>Division</td>
                <td>:</td>
                <td>
                    <input type="hidden" name="ds_id" value="<?=$ds_id;?>" readonly>
                    <input type="text" name="div_id" value="<?=$div_name;?>" readonly>
                </td>
            </tr>
            <tr>
                <td>State</td>
                <td>:</td>
                <td><input type="text" name="state_id" value="<?=$state_name;?>" readonly></td>
            </tr>
            <tr>
                <td>NO Of Distributors Allowed</td>
                <td>:</td>
                <td><input type="text" name="no_of_dis" value="<?=$no_of_dis;?>"></td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="submit" name="EDIT" value="EDIT">
                </td>
            </tr>
        </table>
    </form>   
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
