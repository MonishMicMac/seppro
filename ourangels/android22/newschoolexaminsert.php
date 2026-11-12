<?php

/*$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";*/

include("../../includes/connect_db.php");

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');




$std_id=$_REQUEST['std_id'];
$sec_id=$_REQUEST['sec_id'];
$std_name=$_REQUEST['std_name'];
$sec_name=$_REQUEST['sec_name'];
$staff_id=$_REQUEST['staff_id'];
$exam_date=$_REQUEST['exam_date'];
$exam_type=$_REQUEST['exam_type'];
$portion=$_REQUEST['portion'];
$subject_id=$_REQUEST['subject_id'];
$subject_name=$_REQUEST['subject_name'];

$total_marks=$_REQUEST['total_marks'];
$duration=$_REQUEST['duration'];
$given_date=$_REQUEST['given_date'];





$a=mysql_query("insert into exam_schedule(std_id,sec_id,std_name,sec_name,staff_id,exam_date,exam_type,portion,subject_id,subject_name,total_marks,duration,given_date)values('$std_id','$sec_id','$std_name','$sec_name','$staff_id','$exam_date','$exam_type','$portion','$subject_id','$subject_name','$total_marks','$duration','$given_date')")or die(mysql_error());

?>