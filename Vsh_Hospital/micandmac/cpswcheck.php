<?php 
include("../include/connect.php");
session_start();
$id=$_SESSION['id'];
if(!isset($_SESSION['id']))
{
echo "<script type=text/javascript>
window.location='home.php'
</script>";
}
else
{
$c_pass=$_GET['q'];

$result1=mysql_query("select  *  from admin where u_name='$c_pass'") or die(mysql_error());
$count=mysql_num_rows($result1);
if($count=='0')
{
echo "Username Avaliable";
}
else
{
echo "Username Already Taken By Another User";
}
}

?>