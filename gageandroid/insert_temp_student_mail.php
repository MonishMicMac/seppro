<?php
include("../includes/connect_db.php"); 

$stud_name=$_REQUEST['stud_name'];
$stud_std=$_REQUEST['stud_std'];
$stud_sec=$_REQUEST['stud_sec'];
$stud_mobile=$_REQUEST['stud_mobile'];
$stud_email_id=$_REQUEST['stud_email_id'];
$stud_status=$_REQUEST['stud_status'];


$a=mysql_query("INSERT INTO `temp_student_profile`(`temp_stud_name`, `temp_stud_std`, `temp_stud_sec`, `temp_stud_mobile`, `temp_email_id`, `temp_status`)values('$stud_name','$stud_std','$stud_sec','$stud_mobile','$stud_email_id','$stud_status')")or die(mysql_error());

?>