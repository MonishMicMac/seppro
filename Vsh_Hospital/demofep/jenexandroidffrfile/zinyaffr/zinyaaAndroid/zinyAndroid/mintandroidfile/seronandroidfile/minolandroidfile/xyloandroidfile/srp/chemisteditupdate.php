<?php
include("connect2.php"); 


$id=$_REQUEST['id'];
$shop_name=$_REQUEST['shop_name'];
$owner_name=$_REQUEST['owner_name'];
$rep_id=$_REQUEST['rep_id'];
$pin_id=$_REQUEST['pin_id'];
$pincode=$_REQUEST['pincode'];
$mobile_no=$_REQUEST['mobile_no'];
$customer_address=$_REQUEST['customer_address'];





$jjsdzz = mysql_query("UPDATE tbl_customer_master SET shop_name='$shop_name',owner_name='$owner_name',rep_id='$rep_id',pin_id='$pin_id',pincode='$pincode',mobile_no='$mobile_no',customer_address='$customer_address' WHERE id= '$id'")or die(mysql_error());






?>
