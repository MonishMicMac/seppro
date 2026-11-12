<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');


$repid=$_REQUEST['repid'];
$clientid=$_REQUEST['clientid'];
$productid=$_REQUEST['productid'];
$fromdate=$_REQUEST['fromdate'];
$todate=$_REQUEST['todate'];
$feedback=$_REQUEST['feedback'];

mysql_query("insert into diagnoses_add(rep_id,client_id,product_id,from_date,to_date,feedback)values('$repid','$clientid','$productid','$fromdate','$todate','$feedback')")or die(mysql_error());

?>