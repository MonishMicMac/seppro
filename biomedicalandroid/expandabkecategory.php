<?php

include("connect2.php"); 

 
$outpu;
$outpu1;





$strSQL = $je->prepare("SELECT representative.id,representative.rep_name,representative.rep_id FROM representative");

$strSQL->execute();
$total = $strSQL->fetchAll();
foreach($total as $row => $link)
{
$repname=$link['rep_name'];
$repidd=$link['id'];
$rep_id=$link['rep_id'];
$outpu='{"status":"'.$rep_id.'","repname":"'.$repname.'","repid":"'.$repidd.'"},';
$outpu1.=$outpu;
}
$finaloutput= substr($outpu1, 0, -1);





$strSQL1 = $je->prepare("SELECT catid,catname FROM category");

$strSQL1->execute();
$total1 = $strSQL1->fetchAll();
foreach($total1 as $row => $link)
{
$repname1=$link['catname'];


$repname1s=$link['catid'];

$outpu12='{"status":"'.'0'.'","repname":"'.$repname1.'","repid":"'.$repname1s.'"},';
$outpu11.=$outpu12;
}



$finaloutput1= substr($outpu11, 0, -1);


echo "[".$finaloutput.','.$finaloutput1."]";



?>