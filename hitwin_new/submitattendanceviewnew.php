<?php
include('connect.php');

	

// $next_month_ts = strtotime($_REQUEST['date'].'+1 month');
$prev_month_ts = strtotime($_REQUEST['date'].'-1 month');

// $next_month = date('Y-m-d', $next_month_ts);
$prev_month = date('Y-m-d', $prev_month_ts);


$repid=$_REQUEST['repid'];
$lattt=$_REQUEST['lattt'];
$longgg=$_REQUEST['longgg'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$expenses=$_REQUEST['expenses'];
$area=$_REQUEST['area'];



$chkall=mysql_query("SELECT * FROM attendancetable WHERE repid='".$_REQUEST['repid']."' AND date='".$_REQUEST['date']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
mysql_query("UPDATE attendancetable SET   time='$time'	 WHERE  repid='$repid' and date='$date'");
}
else
{

mysql_query("INSERT INTO attendancetable(repid,lattt,longg,date,time,expenses,area)VALUES('$repid','$lattt','$longgg','$date','$time','$expenses','$area')")or die(mysql_error());

}

$date = $_REQUEST['date'];
$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-d' , $newdate );
 
// echo "SELECT count(*) AS unvisitcall FROM  reorting WHERE repid='".$_REQUEST['repid']."' AND tdate='".$newdate."' AND attendance='0'";

$callcount=mysql_query("SELECT count(*) AS unvisitcall FROM  reorting WHERE repid='".$_REQUEST['repid']."' AND (tdate BETWEEN '".$prev_month."' AND '".$date."') AND attendance='0'")or die(mysql_error());
$callcount_row=mysql_fetch_array($callcount);
echo $callcount_row['unvisitcall'];


?>