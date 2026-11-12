<?php
$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$staff_id=$_REQUEST['staff_id'];
$staffname=$_REQUEST['staffname'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$standard_name=$_REQUEST['standard_name'];
$section_name=$_REQUEST['section_name'];
$type=$_REQUEST['type'];
$subjectname=$_REQUEST['subjectname'];
$message=$_REQUEST['message'];
$date=date('Y-m-d');







$a=mysql_query("insert into dairyupdate(staff_id,staffname,standard_id,section_id,standard_name,section_name,type,subjectname,message,date)values('$staff_id','$staffname','$standard_id','$section_id','$standard_name','$section_name','$type','$subjectname','$message','$date')")or die(mysql_error());

?>