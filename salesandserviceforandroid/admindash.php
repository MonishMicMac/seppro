<?php

include("connect2.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;





$strSQL = $je->prepare("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE representative.rep_id='0' AND assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");

$strSQL->execute();
$total = $strSQL->fetchAll();
foreach($total as $row => $link)
{
//echo $link['rep_name'];
$repname=$link['rep_name'];
$repidd=$link['id'];

date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');
$wp_rep_id= $repidd;
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

$ach = $je->prepare("SELECT COUNT(*) FROM clinetcreation WHERE repid='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$total = $ach->fetchColumn();




$outpu='{"planned":"'.$planned.'","repname":"'.$repname.'","repid":"'.$repidd.'","pending":"'.$pending.'","Visited":"'.$visited.'","total":"'.$total.'"},';



$outpu1.=$outpu;
}


$finaloutput= substr($outpu1, 0, -1);

echo "[".$finaloutput."]";

?>