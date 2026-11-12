<?php
include("connect2.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$c_date = date('Y-m-d');
$c_time=date('h:i:s A');

$clientid=$_REQUEST['clientid'];
$repid=$_REQUEST['repid'];



$jj = mysql_query("SELECT * FROM sampletimeinandout WHERE repid= '$repid' AND scheduledate='$c_date'  AND clientid= '$clientid'  and attenstatus='0' ")or die(mysql_error());

 $jj_count = mysql_num_rows($jj);
     if($jj_count > 0)
    {
}
else
{
 mysql_query("INSERT INTO sampletimeinandout(repid,clientid,scheduledate,scheduletime) VALUES ('$repid','$clientid','$c_date','$c_time')")or die(mysql_error());
}

?>

