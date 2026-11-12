<?php
include("connect2.php"); 


$repid=$_REQUEST['repid'];
$date=$_REQUEST['date'];




mysql_query("UPDATE repgivenasleave SET expenses_status='1' WHERE repid= '$repid' AND leaveapplieddate ='$date'")or die(mysql_error());




?>