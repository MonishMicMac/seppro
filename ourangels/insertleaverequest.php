<?php
include("../includes/connect_db.php"); 


$teacherid=$_REQUEST['teacherid'];
$teachername=$_REQUEST['teachername'];
$leavedate=$_REQUEST['leavedate'];
$reason=$_REQUEST['reason'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$status='0';






$a=mysql_query("insert into leaverequest(teacherid,teachername,leavedate,reason,month,year,status)values('$teacherid','$teachername','$leavedate','$reason','$month','$year','$status')")or die(mysql_error());

?>