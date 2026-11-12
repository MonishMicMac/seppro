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
<!----------------------------------------------------------------------------->
<div class="contentRight" align="center" style="height: 500px;" >
<a href="add_state.php">Add State</a>
<div class="searchDetail" style="margin-top: 3%;">
<table width="50%" border="1">
<tr>
    <th>S.NO</th>
    <th>State Name</th>
    <th>Action</th>
</tr>
<?php
$co_state=$ad->count1("master_state", "", "LIMIT 0,1");
$state=$ad->view("master_state", "", "");
if($co_state > 0)
{
     $x=1;
     while($row_st=mysql_fetch_object($state))
       { ?>
        <tr>
            <td><?=$x;?></td>
            <td><?=$row_st->state_name;?></td> 
            <td>
                <a href="add_state.php?command=edit&&s_id=<?=$row_st->state_id;?>">Edit</a>
                <a href="#">Delete</a>
            </td>
        </tr>
<?php  $x++;}
}
else
{ ?>
<tr>
    <td colspan="3">No States Avaliable</td>
</tr>
<?php
}    
?>    
</table>
</div>  
</div>
<!----------------------------------------------------------------------------->
<!------------------------------------------------------------------------------>
<!--<div class="contentRight" align="center" style="height: 150px;margin-top: -29px;;" >
    <a href="add_district.php">Add District</a>
<div class="searchDetail" style="margin-top: 3%;">
<table width="50%" border="1">
<tr>
    <th>S.NO</th>
    <th>State Name</th>
    <th>District Name</th>
    <th>Action</th>
</tr>
<?php
$co_city=$ad->count1("master_district", "", "LIMIT 0,1");
$city=$ad->view("master_district", "", "");
if($co_city > 0)
{
     $x=1;
     while($row_cit=mysql_fetch_object($city))
       { ?>
        <tr>
            <td><?=$x;?></td>
            <td><?=$row_cit->state_id;?></td> 
            <td><?=$row_cit->district_name;?></td> 
            <td>
                <a href="#">Edit</a>
                <a href="#">Delete</a>
            </td>
        </tr>
<?php  $x++;}
}
else
{ ?>
<tr>
    <td colspan="4">No Cities Avaliable</td>
</tr>
<?php
}    
?>    
</table>
</div>
</div>-->
<!------------------------------------------------------------------------------>
<!----------------------------------------------------------------------------->
<!--<div class="contentRight" align="center" style="height: 150px;margin-top: -29px;;" >
    <a href="add_area_pin.php">Add Area & Pin code</a>
<div class="searchDetail" style="margin-top: 3%;">
<table width="75%" border="1">
<tr>
    <th>S.NO</th>
    <th>State Name</th>
    <th>District Name</th>
    <th>Area Name</th>
    <th>Action</th>
</tr>
<?php

$co_area=$ad->count1("master_area_pin", "", "LIMIT 0,1");
$area=$ad->view("master_area_pin", "", "");
if($co_area > 0)
{
     $x=1;
     while($row_are=mysql_fetch_object($area))
       { ?>
        <tr>
            <td><?=$x;?></td>
            <td><?=$row_are->state_id;?></td> 
            <td><?=$row_are->district_id;?></td> 
            <td><?=$row_are->area_name;?></td> 
            <td>
                <a href="#">Edit</a>
                <a href="#">Delete</a>
            </td>
        </tr>
<?php  $x++;}
}
else
{ ?>
<tr>
    <td colspan="5">No States Avaliable</td>
</tr>
<?php
}    
?>    
</table>
</div>
</div>-->
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
?>
