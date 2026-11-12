<?php 
include("../include/connect.php");

$command=$_REQUEST['command'];

if($command === 'delete_dis')
{
    $dis_id=$_REQUEST['dis_id'];
    mysql_query("delete from master_district where district_id = '$dis_id'")or die(mysql_error());
    echo "<script type='text/javascript'>window.location.href='district_master.php';</script>";
}

if($command === 'delete_pin')
{
    $pin_id=$_REQUEST['pin_id'];
    mysql_query("delete from master_pincode where pin_id = '$pin_id'")or die(mysql_error());
    echo "<script type='text/javascript'>window.location.href='pincode_master.php';</script>";
}


if($command === 'del_div_rest')
{
    $ds_id=$_GET['ds_id'];
    mysql_query("delete from tbl_division_state where ds_id='$ds_id'")or die(mysql_error());
    echo "<script type='text/javascript'>window.location.href='restriction_master.php';</script>";
}

$a_id=$_REQUEST['a_id'];
mysql_query("delete from marketer where mark_id='$a_id'");
mysql_query("delete from admin where u_name='$a_id'");
echo "<script type='text/javascript'>window.location.href='add_marketer.php';</script>";


