<?php
include("connect1.php");


date_default_timezone_set("Asia/Kolkata"); 

$msg=$_REQUEST['msg'];
$repid=$_REQUEST['repid'];
$cdate = date('Y-m-d');
$ctime = date('H:i');
mysql_query("insert into companymessage(msg,date,time,repid)values('$msg','$cdate','$ctime','$repid')")or die(mysql_error());













?>