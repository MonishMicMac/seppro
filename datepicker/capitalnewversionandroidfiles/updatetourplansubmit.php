<?php
include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];


$b = $je->prepare("UPDATE representative SET blockopeningmonth='$date',deleteopen='1' WHERE id= '$rep_id'")or die(mysql_error());

$b->execute();

?>