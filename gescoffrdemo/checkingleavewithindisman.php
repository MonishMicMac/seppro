<?php

include("connect1.php");

$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];
$expenses=$_REQUEST['expenses'];
$filename=$_REQUEST['filename'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {
mysql_query("UPDATE repgivenasleave SET expenses='$expenses',reason='$reason',filename='$filename',date='$c_date',time='$c_time' WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate'")or die(mysql_error());
   }
   else
   {
mysql_query("insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time,filename)values('$repid','$leaveapplieddate','$reason','$expenses','$c_date','$c_time','$filename')")or die(mysql_error());


}







?>