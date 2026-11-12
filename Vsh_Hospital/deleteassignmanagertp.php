<?php
include("connect.php"); 

$repid=$_REQUEST['repid'];
$managerid=$_REQUEST['managerid'];
$date=$_REQUEST['date'];







$c=$je->prepare("DELETE FROM managerjoinworkplans WHERE repid='$repid' && managerid='$managerid' && date='$date'")or die(mysql_error());

$c->execute();



?>
