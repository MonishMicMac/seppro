<?php

include("connect1.php");
$rep_id=$_REQUEST['rep_id'];


 date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); 


$strSQL = mysql_query("SELECT * FROM representative WHERE (rep_imeino='$rep_id' or rep_imeino1='$rep_id')")or die(mysql_error());
$alpha = mysql_fetch_array($strSQL); 
$id =  $alpha['id'];

$beta = mysql_query("SELECT * FROM representative WHERE id ='".$alpha['id']."' ")or die(mysql_error());
$beta_res= mysql_fetch_array($beta); 

$rep_id = $beta_res['rep_id'];

$res = mysql_query("SELECT * FROM representative WHERE id ='".$beta_res['rep_id']."' ")or die(mysql_error());
$res_res= mysql_fetch_array($res);
$rep_name = $res_res['rep_name'];

$expensecal = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$date' AND repid ='".$alpha['id']."'")or die(mysql_error());
$beta_res1= mysql_fetch_array($expensecal); 

if($beta_res1['repid']!='')
{
	$expenses = "1";
}
else
{
	$expenses = '0';
}


echo '[{"id":"'.$id.'",'.'"rep_id":"'.$rep_id.'",'.'"rep_name":"'.$rep_name.'",'.'"expenses":"'.$expenses.'"}]';


?>