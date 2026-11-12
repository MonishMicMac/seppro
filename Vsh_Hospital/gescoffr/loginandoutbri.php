<?php

include("connect1.php");

$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];


date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');
$c_time=date("H:i:s");




$antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate' AND logoutbri=''")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

  mysql_query(" UPDATE repgivenasleave SET logoutbri='$c_time' WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
   }
   else
   {

}






?>