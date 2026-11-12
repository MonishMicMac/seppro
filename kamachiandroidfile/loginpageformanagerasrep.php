<?php

include("connect2.php"); 
$rep_id=$_REQUEST['rep_id'];





$strSQL = mysql_query("SELECT * FROM representative WHERE rep_imeino='$rep_id'")or die(mysql_error());
$alpha = mysql_fetch_array($strSQL); 
$id =  $alpha['id'];

$beta = mysql_query("SELECT * FROM representative WHERE id ='".$alpha['id']."' ")or die(mysql_error());
$beta_res= mysql_fetch_array($beta); 

$rep_id = $beta_res['rep_id'];

$res = mysql_query("SELECT * FROM representative WHERE id ='".$beta_res['rep_id']."' ")or die(mysql_error());
$res_res= mysql_fetch_array($res);
$rep_name = $res_res['rep_name'];

echo '[{"id":"'.$id.'",'.'"rep_id":"'.$rep_id.'",'.'"rep_name":"'.$rep_name.'"}]';


?>