<?php
include("connect.php"); 

$rto='';
$erql = mysql_query("SELECT approval FROM profileenrollment where id= '".$_REQUEST['id']."'");
$row=mysql_fetch_array($erql);
$reid=$row['approval'];

if($reid=='0')
{
$rto='1';
}
else
{
$rto='0';
}



mysql_query("UPDATE profileenrollment SET approval='$rto'  WHERE id= '".$_REQUEST['id']."'")or die(mysql_error());











?>
