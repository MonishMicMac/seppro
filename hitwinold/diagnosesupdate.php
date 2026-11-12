<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$id=$_REQUEST['id'];
$productid=rtrim($_REQUEST['productid'],",");
$date=$_REQUEST['date'];
$feedback=$_REQUEST['feedback'];

$chk=mysql_query("SELECT collect_product_id FROM diagnoses_add WHERE id='".$_REQUEST['id']."'")or die(mysql_error());
$chk_res=mysql_fetch_array($chk);
$cprid=$chk_res['collect_product_id'];


	$expcoll=explode(",",$cprid);
	$expproduct=explode(",",$productid);
	$result = array_diff($expproduct,$expcoll);
	
	if($cprid=='')
	{
		$newcproid=implode(",",$result);
	}
	else
	{
		//print_r($result);exit;
		$newcproid=$cprid.",".implode(",",$result);
	}

	mysql_query("UPDATE diagnoses_add SET collect_product_id='$newcproid',collect_date='$date',collect_feedback='$feedback' WHERE id='$id'")or die(mysql_error());
	$getstat=mysql_query("SELECT * FROM diagnoses_add WHERE id='$id'")or die(mysql_error());
	$getstat_res=mysql_fetch_array($getstat);
	$xxx = explode(",", trim($getstat_res['product_id']));
	$yyy = explode(",", $getstat_res['collect_product_id']);
	sort($xxx);
	sort($yyy);
	if($xxx===$yyy)
	{
		$status="1";
	}
	else
	{
		$status="0";
	}
	mysql_query("UPDATE diagnoses_add SET status='$status' WHERE id='$id'")or die(mysql_error());

	mysql_query("INSERT INTO diagnoses_collect_history(addid,repid,clientid,productid,coll_date,coll_feedback)VALUES('$id','".$getstat_res['rep_id']."','".$getstat_res['client_id']."','$productid','$date','$feedback')")or die(mysql_error());
?>