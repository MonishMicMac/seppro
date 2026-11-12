<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');



$staffid=$_REQUEST['staffid'];
$staffname=$_REQUEST['staffname'];
$dateofleave=$_REQUEST['dateofleave'];
$reasonforleave=$_REQUEST['reasonforleave'];
$noofdays=$_REQUEST['noofdays'];
$leaverequesteddate=date('Y-m-d');







$a=mysql_query("insert into leaverequestedforstaff(staffid,staffname,dateofleave,reasonforleave,leaverequesteddate,noofdays)values('$staffid','$staffname','$dateofleave','$reasonforleave','$leaverequesteddate','$noofdays')")or die(mysql_error());

?>