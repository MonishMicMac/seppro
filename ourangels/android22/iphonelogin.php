<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');






$query=mysql_query("select * from student_profile WHERE student_id='".$_REQUEST['username']."' and Phone_no='".$_REQUEST['password']."'") or die(mysql_error());
   $res=mysql_fetch_row($query);
   if($res)
   {
   echo '{"success":1}';
   }
   else
   {
   echo '{"success":0,"error_message":"Username and/or password is invalid."}';
   }
?>