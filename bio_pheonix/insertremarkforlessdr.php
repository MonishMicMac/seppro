<?php
include("connect23.php"); 


$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];





$jjxx = mysql_query("UPDATE repgivenasleave SET reasonforlessdr='$reason' WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate'")or die(mysql_error());




?>