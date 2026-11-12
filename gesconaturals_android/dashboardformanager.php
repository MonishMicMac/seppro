<?php
include("connect.php"); 
date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');

global $count,$count1,$count4,$count2,$count3;

$a = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND UP='P'")or die(mysql_error());
$a->execute();
$count = $a->fetchColumn();
//$array = $a->fetchAll(PDO::FETCH_NUM);


$b =  $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date'  AND latitude!='' AND longitude!='' AND UP='P'")or die(mysql_error());

$b->execute();
$count1 = $b->fetchColumn();
//$array1 = $b->fetchAll(PDO::FETCH_NUM);


$e =  $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date'  AND latitude!='' AND longitude!='' AND UP='U'")or die(mysql_error());
$e->execute();
$count2 = $e->fetchColumn();
//$array2 = $e->fetchAll(PDO::FETCH_NUM);


$c =  $je->prepare("SELECT COUNT(*) FROM doctors WHERE doc_status='1' AND rep_id!='0'")or die(mysql_error());
$c->execute();
$count3 = $c->fetchColumn();
//$array3 = $c->fetchAll(PDO::FETCH_NUM);


$d =  $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND UP='U'")or die(mysql_error());
$d->execute();
$count4 = $d->fetchColumn();
//$array4 = $d->fetchAll(PDO::FETCH_NUM);
echo '[{"PLANNED":"'.$count.'","UNPLANNED":"'.$count4.'","VISITEDPLANNED":"'.$count1.'","VISITEDUNPLANNED":"'.$count2.'","DOCTOR":"'.$count3.'"}]';

?>
