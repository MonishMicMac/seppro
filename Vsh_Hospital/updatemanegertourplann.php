<?php
include("connect.php"); 

$repid=$_REQUEST['repid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-');



$b = $je->prepare("UPDATE representative SET managertourplanopen='1',blockopeningmonth='$c_date' WHERE id= '$repid'")or die(mysql_error());

$b->execute();

?>