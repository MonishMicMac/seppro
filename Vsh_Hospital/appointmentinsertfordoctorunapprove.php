<?php
include("connect.php"); 

$wp_date=$_REQUEST['wp_date'];
$wp_pin_id=$_REQUEST['wp_pin_id'];
$wp_dc=$_REQUEST['wp_dc'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_rep_id=$_REQUEST['wp_rep_id'];

$UP=$_REQUEST['UP'];



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$c_time=date('h:i:s A');

$strSQL=$je->prepare("INSERT INTO unapprovedtbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time)VALUES('$wp_date','$wp_pin_id','$wp_dc','$wp_dc_id','$wp_rep_id','$UP','$c_date','$c_time')")or die(mysql_error());

$strSQL->execute();








?>
