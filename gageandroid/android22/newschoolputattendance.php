<?php

/*$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";*/

include("../../includes/connect_db.php");

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');
$staff_id=$_REQUEST['staff_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$student_id=$_REQUEST['student_id'];
$date=$_REQUEST['date'];
$status=$_REQUEST['status'];
$day=$_REQUEST['day'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];



$a=mysql_query("insert into student_attendance(staff_id,standard_id,section_id,standard_name,section_name,student_id,date,status,day,month,year)values('$staff_id','$standard_id','$section_id','$standard_name','$section_name','$student_id','$date','$status','$day','$month','$year')")or die(mysql_error());

?>