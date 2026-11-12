<?php
include("connect.php"); 

$repid=$_REQUEST['repid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$a=$je->prepare("insert into repgivenasleave(repid,date,time)values('$repid','$c_date','$c_time')")or die(mysql_error());

$a->execute();


?>
