<?php
include("connect1.php"); 
$repid=$_REQUEST['repid'];

$intime=$_REQUEST['intime'];
$drid=$_REQUEST['drid'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");



mysql_query("UPDATE tbl_work_plan SET intime='$intime' WHERE  wp_dc_id='$drid' and wp_rep_id='$repid' and wp_date='$c_date'")or die(mysql_error());









?>