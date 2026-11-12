<?php
include("include/connect.php");
session_start();
$id=$_SESSION['id'];
$c_pass=$_GET['q'];
//echo "select * from admin where password='$c_pass' AND id='$id'";
$result2=mysql_query("select * from admin where pass='$c_pass' AND id='$id'") or die(mysql_error());
$count=mysql_num_rows($result2);
if($count=='0')
{
echo "Password Incorrect";
}
if($count=='1')
{
echo "";
}


?>