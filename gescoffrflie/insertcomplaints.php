<?php



include("connect1.php");

$cusid=$_REQUEST['cusid'];
$type=$_REQUEST['type'];
$complaints=$_REQUEST['complaints'];
$billno=$_REQUEST['billno'];
$repid=$_REQUEST['repid'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");










$jjsdzz = mysql_query("insert into complaints(cusid,type,complaints,billno,cdate,ctime,repid)values('$cusid','$type','$complaints','$billno','$c_date','$c_time','$repid')")or die(mysql_error());










?>
