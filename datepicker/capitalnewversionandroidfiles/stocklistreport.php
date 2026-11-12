<?php
include("connect23.php"); 



$drunavailablereason=$_REQUEST['drunavailablereason'];

$wp_rep_id=$_REQUEST['wp_rep_id'];
$wp_dc_id=$_REQUEST['wp_dc_id'];
$wp_date=$_REQUEST['wp_date'];
date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$jjsdzz  = mysql_query("INSERT INTO tbl_work_plan(attendancestatus,wp_dc,drunavailablereason,reporteddate,reportedtime,wp_rep_id,wp_dc_id,wp_date)VALUES('1','S','$drunavailablereason','$c_date','$c_time','$wp_rep_id','$wp_dc_id','$wp_date')")or die(mysql_error());




?>