<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$classname=$_REQUEST['classname'];
$filename=$_REQUEST['filename'];
$category=$_REQUEST['category'];
$length=$_REQUEST['length'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];



$a=mysql_query("insert into adminvoicefilesentdetails(classname,filename,category,length,date,time)values('$classname','$filename','$category','$length','$date','$time')")or die(mysql_error());

?>