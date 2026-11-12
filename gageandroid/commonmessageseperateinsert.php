<?php
include("../includes/connect_db.php"); 

$parentid=$_REQUEST['parentid'];
$parentmessage=$_REQUEST['parentmessage'];
$teacherimage=$_REQUEST['teacherimage'];
$teachername=$_REQUEST['teachername'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );




$id=(explode(",",$parentid));
$count=count($id)-1;
if($count == 0)
{
$a=mysql_query("insert into commonmessageparents(parentid,parentmessage,teacherimage,date,time,teachername)values('$parentid','$parentmessage','$teacherimage','$c_date','$c_time','$teachername')")or die(mysql_error());
}
else
{
for($i=0;$i<=$count;$i++)
{
$ids=$id[$i];
 mysql_query("insert into commonmessageparents(parentid,parentmessage,teacherimage,date,time,teachername)values('$ids','$parentmessage','$teacherimage','$c_date','$c_time','$teachername')")or die(mysql_error());
}
}



?>