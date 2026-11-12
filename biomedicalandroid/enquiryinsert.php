<?php
include('connect.php');


$clientid=$_REQUEST['clientid'];

$typeofcall=$_REQUEST['typeofcall'];

$complaints=$_REQUEST['complaints'];

$amount=$_REQUEST['amount'];

$comingdate=$_REQUEST['comingdate'];

$comingtime=$_REQUEST['comingtime'];

$enquirystage=$_REQUEST['es'];




$productrequested=$_REQUEST['productrequested'];






$chkall=mysql_query("SELECT * FROM enquiry WHERE date='".$_REQUEST['sdate']."' AND productid='$productrequested' AND clientid='$clientid' AND repid='".$_REQUEST['repid']."' AND typeofenquiry='$typeofcall'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
}
else
{

mysql_query("INSERT INTO enquiry(date,time,clientid,repid,typeofenquiry,productid,descrption,requestqty,neededdate,neededtime,cdate,ctime,enquirystage)VALUES('".$_REQUEST['sdate']."','".$_REQUEST['stime']."','$clientid','".$_REQUEST['repid']."','$typeofcall','$productrequested','$complaints','$amount','$comingdate','$comingtime','".$_REQUEST['sdate']."','".$_REQUEST['stime']."','$enquirystage')")or die(mysql_error());



}




?>