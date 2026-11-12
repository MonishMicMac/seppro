<?php
include("connect23.php"); 
$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];
$expenses=$_REQUEST['expenses'];
$managerchange=$_REQUEST['managerchange'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");



mysql_query("UPDATE repgivenasleave set reason='$reason',expenses='$expenses',date='$c_date',time='$c_time',managerchange='$managerchange' WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate'")or die(mysql_error());

  







?>