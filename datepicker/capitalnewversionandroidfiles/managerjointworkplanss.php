

<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;

$date =$_REQUEST['date'];



$strSQL = $je->prepare("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");

$strSQL->execute();
$total = $strSQL->fetchAll();
foreach($total as $row => $link)
{
//echo $link['rep_name'];
$repname=$link['rep_name'];
$repidd=$link['id'];



$wp_rep_id= $repidd;
$total;

$a = $je->prepare("SELECT count(*) FROM managerjoinworkplans WHERE date='$date' AND repid='$wp_rep_id' AND managerid='$id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();





$outpu='{"REPID":"'.$repidd.'","REPNAME":"'.$repname.'","total":"'.$total.'"},';


$outpu1.=$outpu;
}


$finaloutput= substr($outpu1, 0, -1);

echo "[".$finaloutput."]";

?>