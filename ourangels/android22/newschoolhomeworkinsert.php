<?php

/*$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";*/

include("../../includes/connect_db.php");


 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

/*$assignment_date=$_REQUEST['assignment_date'];
echo date('Y-m-d', strtotime($assignment_date));
die();*/
$staff_id=$_REQUEST['staff_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$assignment_date=$_REQUEST['assignment_date'];
$subject=$_REQUEST['subject'];
$description=$_REQUEST['description'];
$deadline_date=$_REQUEST['deadline_date'];
$status=$_REQUEST['status'];
$pageno=$_REQUEST['pageno'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];





$a=mysql_query("insert into assignment(staff_id,standard_id,section_id,standard_name,section_name,assignment_date,subject,description,deadline_date,status,pageno,month,year)values('$staff_id','$standard_id','$section_id','$standard_name','$section_name','$assignment_date','$subject','$description','$deadline_date','$status','$pageno','$month','$year')")or die(mysql_error());

?>