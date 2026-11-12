<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');



$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$staff_id=$_REQUEST['staff_id'];
$assignment_date=$_REQUEST['assignment_date'];
$duration=$_REQUEST['duration'];
$time=$_REQUEST['time'];
$student_id=$_REQUEST['student_id'];
$filename=$_REQUEST['filename'];
$status=$_REQUEST['status'];






$a=mysql_query("insert into homeworkvoice(standard_id,section_id,standard_name,section_name,staff_id,assignment_date,duration,time,student_id,filename,status)values('$standard_id','$section_id','$standard_name','$section_name','$staff_id','$assignment_date','$duration','$time','$student_id','$filename','$status')")or die(mysql_error());

?>