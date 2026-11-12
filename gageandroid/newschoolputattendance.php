<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$staff_id=$_REQUEST['staff_id'];
$standard_id=$_REQUEST['standardid'];
$section_id=$_REQUEST['sectionid'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$student_id=$_REQUEST['student_id'];
$date=$_REQUEST['date'];
$status=$_REQUEST['status'];
$day=$_REQUEST['day'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$morning=$_REQUEST['morning'];


$a=mysql_query("insert into student_attendance(staff_id,standardid,sectionid,standard_name,section_name,student_id,date,status,day,month,year,morning)values('$staff_id','$standard_id','$section_id','$standard_name','$section_name','$student_id','$date','$status','$day','$month','$year','$morning')")or die(mysql_error());

?>