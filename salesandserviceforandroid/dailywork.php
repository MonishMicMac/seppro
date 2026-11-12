<?php
include("connect2.php"); 

  date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); //Returns IST 
    $wp_rep_id= $_REQUEST['wp_rep_id'];

$year = date('Y-m-');

global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep;

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



echo '[{"planned":"'.$planned.'","pending":"'.$pending.'","normalcall":"'.$normalvisited.'","collcall":"'.$collvisited.'","Visited":"'.$visited.'","totalout":"'.'10'.'","amounttodaycol":"'.$visited.'","amounttodaycoltill":"'.$visited.'","total":"'.$total.'"}]';

?>