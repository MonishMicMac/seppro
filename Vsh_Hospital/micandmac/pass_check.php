<?php

include("../include/connect.php");
	session_start();
	$id=$_SESSION['id'];
$c_pass=$_GET['q'];

$result2=mysql_query("select password from login where password='$c_pass' AND id='$id'") or die(mysql_error());
$count=mysql_num_rows($result2);
if($count=='0')
{
echo "Password Incorrect";
}



?>