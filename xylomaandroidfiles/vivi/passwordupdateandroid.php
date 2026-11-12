<?php
include("../includes/connect_db.php"); 

$stuid = $_REQUEST['student_id'];

$password = $_REQUEST['Password'];

$jjstudent = mysql_query("SELECT * FROM student_profile WHERE Phone_no IN (SELECT Phone_no FROM student_profile WHERE student_id='$stuid')")or die(mysql_error());

while($jjstudent_res = mysql_fetch_array($jjstudent))
{

    mysql_query("UPDATE student_profile SET Password='$password' WHERE Phone_no='".$jjstudent_res['Phone_no']."'")or die(mysql_error());
}
?>