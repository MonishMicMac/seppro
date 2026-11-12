<?php
include("connectsms.php"); 

$id=$_REQUEST['id'];
$chat=$_REQUEST['chat'];
$senderid='1';


date_default_timezone_set("Asia/Kolkata");
$c_date=  date("Y-m-d");
$c_time=date("h:i:s A");


$a=mysql_query("insert into homeworkchat(bulksms_id,msg,senderid,date,time,status)values
('$id','$chat','$senderid','$c_date','$c_time','1')")or die(mysql_error());



?>