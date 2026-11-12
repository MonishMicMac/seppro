<?php
error_reporting(0);
include 'vars.php';
$conn = mysql_connect($hostname,$username,$pass)Or DIE ("Unable to connect to database");
mysql_select_db($dbname,$conn);
global $username, $password, $tableuser, $tablepass;
session_start();
$username= $_SESSION['user'];
$password= $_SESSION['pass'];
$query = "select username, password from master";
$rs = mysql_query($query);
if (mysql_fetch_row($rs))
{ 
global $tableuser, $tablepass;
 $tableuser = mysql_result($rs,0,0);
 $tablepass = mysql_result($rs,0,1);
}
if ($username==$tableuser&&$password==$tablepass)
{
$c_pass=$_GET['q'];

$result2=mysql_query("select password from master where password='$c_pass' AND username='$username'") or die(mysql_error());
$count=mysql_num_rows($result2);;
if($count=='0')
{
echo "Password Incorrect";

}
}
else
{
echo "You are not logged in as administrator.";
}
mysql_close($conn);
?>