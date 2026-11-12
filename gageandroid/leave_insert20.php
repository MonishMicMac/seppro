<?php


// include("connectsms.php");

$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
mysql_select_db($_REQUEST['db'],$con);
date_default_timezone_set('Asia/Calcutta');

$stu_id = $_REQUEST['student_id'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$leave =$_REQUEST['leave_type'];
$reason =$_REQUEST['reason'];

if($leave==0)
{
	mysql_query("INSERT INTO leave_request (date_time,student_id,leave_type,from_date,reason) VALUES(DATE(NOW()),'$stu_id','$leave','$from','$reason')");
}
else if($leave==1)
{
	mysql_query("INSERT INTO leave_request (date_time,student_id,leave_type,from_date,reason,to_date) VALUES(DATE(NOW()),'$stu_id','$leave','$from','$reason','$to')");
}
?>