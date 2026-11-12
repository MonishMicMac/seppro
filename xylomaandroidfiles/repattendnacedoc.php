<?php
include("connect.php"); 


$doctorid=$_REQUEST['doctorid'];
$comment=$_REQUEST['comment'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$repid=$_REQUEST['repid'];








$a= $je->prepare("insert into reportforattendance(doctorid,comment,date,time,repid)values('$doctorid','$comment','$date','$time','$repid')")or die(mysql_error());

$a->execute();

?>
