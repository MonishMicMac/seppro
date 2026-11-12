<?php
include('connect.php');


$id=$_REQUEST['repid'];
$lattt=$_REQUEST['lattt'];
$longgg=$_REQUEST['longgg'];

$sql121 = mysql_query("SELECT out_time FROM attendancetable where  repid='$id' and date='".date('Y-m-d')."'");
	$row121=mysql_fetch_array($sql121);	

if($row121['out_time']=='')
{
mysql_query("UPDATE attendancetable SET out_time='".date('H:i:s')."',out_lat='$lattt',out_longg='$longgg' WHERE repid='$id' and date='".date('Y-m-d')."'")or die(mysql_error());
}


?>