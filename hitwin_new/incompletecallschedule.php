<?php
include('connect.php');

$wpid=$_REQUEST['wpid'];

$clientid=$_REQUEST['clientid'];

$type=$_REQUEST['type'];

$pid=$_REQUEST['pid'];
$typeofcall=$_REQUEST['typeofcall'];
$scheduleddate=$_REQUEST['scheduleddate'];
$time=$_REQUEST['time'];

$repid=$_REQUEST['repid'];

$noremark=$_REQUEST['noremark'];
$amount=$_REQUEST['amount'];




$wpid1 = explode("*",$wpid);
$clientid1 = explode("*",$clientid);
$type1 = explode("*",$type);
$pid1 = explode("*",$pid);
$noremark1 = explode("*",$noremark);
$amount1 = explode("*",$amount);


for($i=0;$i< count($wpid1);$i++)
{




$chkall=mysql_query("SELECT * FROM reorting WHERE tdate='$scheduleddate' AND clientid='$clientid1[$i]' AND attendance='0' AND servicetype='$type1[$i]' AND productrequested='$pid1[$i]' AND repid='$repid'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{
mysql_query("INSERT INTO reorting(tdate,clientid,scheduleddate,scheduledtime,repid,typeofcall,servicetype,productrequested,complaints,amount)VALUES('$scheduleddate','$clientid1[$i]','$scheduleddate','$time','$repid','$typeofcall','$type1[$i]','$pid1[$i]','NO REMARK','$pid1[$i]')")or die(mysql_error());

mysql_query("UPDATE reorting SET incompletecall='0' WHERE id='$wpid1[$i]'")or die(mysql_error());


}

echo  'success';


}



?>