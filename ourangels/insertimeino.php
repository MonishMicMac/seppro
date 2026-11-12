<?php
include("../includes/connect_db.php"); 

$imeino=$_REQUEST['imeino'];
$gmailid=$_REQUEST['gmailid'];
$onoff=$_REQUEST['onoff'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );


$a=mysql_query("insert into democheck(imeino,gmailid,date,time,onoff)values('$imeino','$gmailid','$c_date','$c_time','$onoff')")or die(mysql_error());

?>