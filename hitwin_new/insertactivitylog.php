<?php
include('connect.php');

$managerid=$_REQUEST['managerid'];
$log=$_REQUEST['log'];
$date=$_REQUEST['date'];
$clid=$_REQUEST['clid'];



mysql_query("INSERT INTO Activity_log(managerid,client_id,log,date)VALUES('$managerid','$clid','$log','$date')")or die(mysql_error());

?>