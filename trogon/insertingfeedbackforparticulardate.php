<?php
include("connect23.php"); 

$repid=$_REQUEST['repid'];

$feedbackdate=$_REQUEST['feedbackdate'];
$reason=$_REQUEST['reason'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$antony= mysql_query("SELECT * FROM dayfeedback WHERE repid= '$repid' AND feedbackdate= '$feedbackdate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {
mysql_query("UPDATE dayfeedback SET reason='$reason',cdate='$c_date',ctime='$c_time' WHERE repid='$repid' AND feedbackdate='$feedbackdate'")or die(mysql_error());
   }
   else
   {
mysql_query("insert into dayfeedback(repid,reason,feedbackdate,cdate,ctime)values('$repid','$reason','$feedbackdate','$c_date','$c_time')")or die(mysql_error());
   }







?>