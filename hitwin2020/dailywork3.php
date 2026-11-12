<?php
include("connect2.php"); 
include('connect.php');
  date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); //Returns IST 
    $wp_rep_id= $_REQUEST['wp_rep_id'];

$year = date('Y-m-');

global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep,$total2;

$a = $je->prepare("SELECT COUNT(*) FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id'")or die(mysql_error());
$a->execute();
 $planned = $a->fetchColumn();


$ach = $je->prepare("SELECT COUNT(*) FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id' AND attendance='0'")or die(mysql_error());
$ach->execute();
$pending = $ach->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id' AND attendance='1'")or die(mysql_error());
$ach->execute();
$visited = $ach->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM clinetcreation where repid='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$total = $ach->fetchColumn();

$ach2 = $je->prepare("SELECT area FROM attendancetable where repid='$wp_rep_id' and date='$date'")or die(mysql_error());
$ach2->execute();
$total2 = $ach2->fetchColumn();


$ach11 = $je->prepare("SELECT COUNT(*) FROM attendancetable where repid='$wp_rep_id' AND date='$date' AND time >= 10")or die(mysql_error());
$ach11->execute();
$total11 = $ach11->fetchColumn();


$amounttoday = $je->prepare("SELECT SUM(amountcollected) FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id' AND attendance='1' AND amountcollected!='0'")or die(mysql_error());
$amounttoday->execute();
$amounttodaycol = $amounttoday->fetchColumn();

if($amounttodaycol=='')
{
$amounttodaycol='0';
}


$amounttodaytill = $je->prepare("SELECT SUM(amountcollected) FROM reorting WHERE tdate like '$year%' AND repid='$wp_rep_id' AND attendance='1' AND amountcollected!='0'")or die(mysql_error());
$amounttodaytill->execute();
$amounttodaycoltill = $amounttodaytill->fetchColumn();

if($amounttodaycoltill=='')
{
$amounttodaycoltill='0';
}


$amounttodaytilltot = $je->prepare("SELECT GROUP_CONCAT(id) FROM clinetcreation")or die(mysql_error());
$amounttodaytilltot->execute();
$amounttodaycoltilltot = $amounttodaytilltot->fetchColumn();


$amounttodaytill2 = $je->prepare("SELECT SUM(amount) FROM collection WHERE clientid IN($amounttodaycoltilltot)")or die(mysql_error());
$amounttodaytill2->execute();
$amounttodaycoltill2 = $amounttodaytill2->fetchColumn();
if($amounttodaycoltill2=='')
{
$amounttodaycoltill2='0';
}

$collach = $je->prepare("SELECT COUNT(*) FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id' AND attendance='1' AND amountcollected!='0'")or die(mysql_error());
$collach->execute();
$collvisited = $collach->fetchColumn();

$normalach = $je->prepare("SELECT COUNT(*) FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id' AND attendance='1' AND amountcollected='0'")or die(mysql_error());
$normalach->execute();
$normalvisited = $normalach->fetchColumn();

$chkall=mysql_query("SELECT * FROM attendancetable WHERE repid='$wp_rep_id' AND date='$date'")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{	
		// if(date('H:i') < '10:00')
		// {
		// 	 $statustime="1";
		// }
		// else
		// {
		// 	 $statustime="0";
		// }	
		$statustime="21";
}
else
{
	$statustime="20";
}
$rep_s=mysql_query("SELECT schedule_status FROM representative WHERE id='$wp_rep_id'")or die(mysql_error());


$obResult1 = mysql_fetch_array($rep_s);
if($obResult1["schedule_status"]==0)
{
	$schedule=mysql_query("SELECT * FROM reorting WHERE tdate='$date' AND repid='$wp_rep_id'")or die(mysql_error());

	if(mysql_num_rows($schedule)==0)
	{	
		
	$scheduleq=mysql_num_rows($schedule);	
	}
	else
	{
	$scheduleq=mysql_num_rows($schedule);		
}
}
else
{
	$scheduleq="1";
}


echo '[{"planned":"'.$planned.'","pending":"'.$pending.'","normalcall":"'.$normalvisited.'","collcall":"'.$collvisited.'","Visited":"'.$visited.'","totalout":"'.'10'.'","amounttodaycol":"'.$visited.'","amounttodaycoltill":"'.$visited.'","total":"'.$total.'","att":"'.$statustime.'","schedulee":"'.$scheduleq.'","todaywork":"'.$total2.'"}]';

?>