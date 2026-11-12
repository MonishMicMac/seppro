<?php
include("connect23.php"); 

$rep_id=$_REQUEST['rep_id'];

if($_REQUEST['holiday']=='holiday')
{
$selectrep = mysql_query("SELECT id AS rep_id1 FROM representative")or die(mysql_error()); 
while($selectrep_res = mysql_fetch_array($selectrep))
{
	// echo "insert into repgivenasleave(assign_rep,repid,leaveapplieddate,date,time,reason,expenses)values('".$rep_id."','".$selectrep_res['rep_id1']."','".$_REQUEST['leavedate']."','".date('Y-m-d')."','".date('H:i:s')."','".$_REQUEST['holiday']."','".$_REQUEST['holiday']."')";
	
	mysql_query("insert into repgivenasleave(assign_rep,repid,leaveapplieddate,date,time,reason,expenses)values('".$rep_id."','".$selectrep_res['rep_id1']."','".$_REQUEST['leavedate']."','".date('Y-m-d')."','".date('H:i:s')."','".$_REQUEST['holiday']."','".$_REQUEST['holiday']."')")or die(mysql_error());
}
}


?>