<?php
include('connect.php');

$managerid=$_REQUEST['managerid'];
$log=$_REQUEST['log'];
$date=$_REQUEST['date'];



mysql_query("INSERT INTO Activity_log(managerid,log,date)VALUES('$managerid','$log','$date')")or die(mysql_error());

?>