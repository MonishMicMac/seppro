<?php

include("connect1.php");

$repid=$_REQUEST['repid'];
$blockopendate=$_REQUEST['blockopendate'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];
$expenses=$_REQUEST['expenses'];

					
date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$antony= mysql_query("SELECT * FROM blockingopen WHERE repid= '$repid' AND blockopendate= '$blockopendate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

mysql_query("update  blockingopen set cdate='$c_date',reason='$reason' where repid='$repid' and blockopendate='$blockopendate'")or die(mysql_error());
   }
   else
   {
mysql_query("insert into blockingopen(repid,blockopendate,cdate,ctime,reason)values('$repid','$blockopendate','$c_date','$c_time','$reason')")or die(mysql_error());

}


$antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

   }
   else
   {
mysql_query("insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time)values('$repid','$leaveapplieddate','$reason','$expenses','$c_date','$c_time')")or die(mysql_error());

}


?>