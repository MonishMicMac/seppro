<?php
include("connect2.php"); 



$allowance=$_REQUEST['allowance'];
$billdate=$_REQUEST['billdate'];
$rupees=$_REQUEST['rupees'];

$repid=$_REQUEST['repid'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$proid = explode(",",$allowance);
$qtyid = explode(",",$billdate);
$mrpid= explode(",",$rupees);

for($i=0;$i< count($proid);$i++)
{


mysql_query("insert into allowancecal(allowance,billdate,rupees,repid,cdate,ctime)values('$proid[$i]','$qtyid[$i]','$mrpid[$i]','$repid','$c_date','$c_time')")or die(mysql_error());



}


?>