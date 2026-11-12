<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');



$standard_id=$_REQUEST['standard_id'];
$time=$_REQUEST['time'];
$filename=$_REQUEST['filename'];
$length=$_REQUEST['length'];
$date=$_REQUEST['date'];
$category=$_REQUEST['category'];







$a=mysql_query("insert into adminvoice(standard_id,time,filename,length,date,category)values('$standard_id','$time','$filename','$length','$date','$category')")or die(mysql_error());

?>