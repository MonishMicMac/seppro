<?php
include('connect.php');



$repid=$_REQUEST['repid'];
$lattt=$_REQUEST['lattt'];
$longgg=$_REQUEST['longgg'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$expenses=$_REQUEST['expenses'];



$chkall=mysql_query("SELECT * FROM attendancetable WHERE repid='".$_REQUEST['repid']."' AND date='".$_REQUEST['date']."'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{

mysql_query("INSERT INTO attendancetable(repid,lattt,longg,date,time,expenses)VALUES('$repid','$lattt','$longgg','$date','$time','$expenses')")or die(mysql_error());

}






?>