<?php
include('connect.php');



$repid=$_REQUEST['repid'];
$lattt=$_REQUEST['lattt'];
$longgg=$_REQUEST['longgg'];
$date=$_REQUEST['date'];

$expenses=$_REQUEST['expenses'];


 
$time= date("G.i", time());
 


$chkall=mysql_query("SELECT * FROM attendancetable WHERE repid='$repid' AND date='$date'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
mysql_query("UPDATE attendancetable SET   expenses='$expenses',time='$time',area='$expenses' WHERE  repid='$repid' and date='$date'");
}
else
{

mysql_query("INSERT INTO attendancetable(repid,lattt,longg,date,time,expenses,area)VALUES('$repid','$lattt','$longgg','$date','$time','$expenses','$expenses')")or die(mysql_error());

}


?>