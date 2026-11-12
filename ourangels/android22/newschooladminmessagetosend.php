<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$standardid=$_REQUEST['standardid'];
$sectionid=$_REQUEST['sectionid'];
$message=$_REQUEST['message'];
$status=$_REQUEST['status'];
$cdate=date('Y-m-d');
$time=$_REQUEST['time'];








$a=mysql_query("insert into adminmessage(standardid,sectionid,message,status,date,time)values('$standardid','$sectionid','$message','$status','$cdate','$time')")or die(mysql_error());

?>