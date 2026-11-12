<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');


$clientid=$_REQUEST['clientid'];
$scheduleddate=$_REQUEST['scheduleddate'];
$repid=$_REQUEST['repid'];
$typeofcall=$_REQUEST['typeofcall'];

$rtd;
$exp = explode(',',$clientid);

$count = count($exp);

for($i=0;$i<$count;$i++)
{

$jj = mysql_query("SELECT * FROM reorting WHERE clientid= '$exp[$i]' AND scheduleddate='$scheduleddate' AND repid= '$repid'")or die(mysql_error());
      
    if(mysql_num_rows($jj)>0)
   {

   }
   else
   {

     mysql_query("insert into reorting(clientid,scheduleddate,repid,tdate,attendance,typeofcall)values('$exp[$i]','$scheduleddate','$repid','$scheduleddate','0','$typeofcall')")or die(mysql_error());



}

mysql_query("UPDATE representative SET schedule_status='0' WHERE id='".$_REQUEST['repid']."'")or die(mysql_error());


}











?>