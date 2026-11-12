<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$eventid=$_REQUEST['eventid'];
$studentid=$_REQUEST['studentid'];
$studentname=$_REQUEST['studentname'];
$standardname=$_REQUEST['standardname'];
$sectionname=$_REQUEST['sectionname'];
$applieddate=$_REQUEST['applieddate'];





$a=mysql_query("insert into applyingforevents(eventid,studentid,studentname,standardname,sectionname,applieddate)values('$eventid','$studentid','$studentname','$standardname','$sectionname','$applieddate')")or die(mysql_error());

?>