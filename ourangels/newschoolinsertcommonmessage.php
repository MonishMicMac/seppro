<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$staff_id=$_REQUEST['staff_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$student_id=$_REQUEST['student_id'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$message=$_REQUEST['message'];
$status=$_REQUEST['status'];


$a=mysql_query("insert into commonmessageasvoiceortext(staff_id,standard_id,section_id,standard_name,section_name,student_id,date,time,message,status)values('$staff_id','$standard_id','$section_id','$standard_name','$section_name','$student_id','$date','$time','$message','$status')")or die(mysql_error());

?>