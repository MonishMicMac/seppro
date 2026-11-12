<?php
include("connect2.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$c_date = date('Y-m-d');
$c_time=date('h:i:s A');

$clientid=$_REQUEST['clientid'];
$repid=$_REQUEST['repid'];

$outfeedback=$_REQUEST['outfeedback'];
$outtime=$_REQUEST['outtime'];
$latitude_out=$_REQUEST['latitude_out'];
$longitude_out=$_REQUEST['longitude_out'];

/*echo "update sampletimeinandout set outfeedback='$outfeedback',attenstatus='1',latitude_out='$latitude_out',longitude_out='$longitude_out',outtimestatus='1',outtime='$c_time' where clientid='$clientid' and feedback!='' and repid='$repid' and c_date='$c_date'";exit();*/

mysql_query("update sampletimeinandout set outfeedback='$outfeedback',attenstatus='1',latitude_out='$latitude_out',longitude_out='$longitude_out',outtimestatus='1',outtime='$outtime' where clientid='$clientid' and feedback!='' and repid='$repid' and scheduledate='$c_date'");

mysql_query("UPDATE doctors SET outtimestatus='1' WHERE id='$clientid'");
	
?>