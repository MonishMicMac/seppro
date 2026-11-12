<?php
include("connect.php"); 

date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$drid=$_REQUEST['drid'];
$repid=$_REQUEST['repid'];
$managerid=$_REQUEST['managerid'];







$c=$je->prepare("DELETE FROM dropenforschedule WHERE repid='$repid' && drid='$drid' && managerid='$managerid' && dateopen='$cdate' && cdate='$cdate'")or die(mysql_error());

$c->execute();



?>