<?php

include("connect1.php");

$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];
$expenses=$_REQUEST['expenses'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

// echo "insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time)values('$repid','$leaveapplieddate','$reason','$expenses','$c_date','$c_time')";exit();
$antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {
 mysql_query("update repgivenasleave set time='$c_time' where repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
   }
   else
   {
// echo "2";
// echo "insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time)values('$repid','$leaveapplieddate','$reason','$expenses','$c_date','$c_time')";
  mysql_query("insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time)values('$repid','$leaveapplieddate','$reason','$expenses','$c_date','$c_time')")or die(mysql_error());

}







?>