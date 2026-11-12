<?php
include("connectpon2.php");



$stud_name=$_REQUEST['stud_name'];
$stud_std=$_REQUEST['stud_std'];
$stud_sec=$_REQUEST['stud_sec'];

$appy_stud_std=$_REQUEST['appy_stud_std'];
$appy_stud_sec=$_REQUEST['appy_stud_sec'];
$school_name=$_REQUEST['school_name'];

$stud_dob = $_REQUEST['stud_dob'];

$av=mysql_query("select * from `application_form` where app_student_name='$stud_name' AND app_dob='$stud_dob' AND app_school_name='$school_name'")or die(mysql_error());
if(mysql_num_rows($av)==0) {

	$a=mysql_query("INSERT INTO `application_form`(`app_student_name`, `app_std`, `app_sec`, `appy_std`, `appy_sec`, `app_school_name`, `app_dob`)values('$stud_name','$stud_std','$stud_sec','$appy_stud_std','$appy_stud_sec','$school_name','$stud_dob')")or die(mysql_error());
echo "sucess";
}

?>
