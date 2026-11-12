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
$abs_mark=$_GET['q'];
$result1=mysql_query("select  *  from marketer where mark_abb='$abs_mark'") or die(mysql_error());
$count=mysql_num_rows($result1);
if($count=='0')
{
echo "1";
}
else
{
echo "2";
}
}
?>