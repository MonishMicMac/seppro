<?php
include("connect.php"); 

  date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); //Returns IST 


   
$c_time=date("h:i:s A");
$dateOneMonthAdded = strtotime(date("Y-m-d", strtotime($date)) . " -7 days");
$end_date=date("Y-m-d",$dateOneMonthAdded);

$c_time=date("h:i:s A");
$dateOneMonthAdded1 = strtotime(date("Y-m-d", strtotime($date)) . " -30 days");
$end_date1=date("Y-m-d",$dateOneMonthAdded1);

$wp_rep_id= $_REQUEST['wp_rep_id'];
global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep;

$a = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$totalch = $ach->fetchColumn();



$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND reporteddate!=''")or die(mysql_error());

$b->execute();
$visited= $b->fetchColumn();

$bch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate!=''")or die(mysql_error());

$bch->execute();
$visitedch= $bch->fetchColumn();


$c = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());

$c->execute();
$pending= $c->fetchColumn();

$cch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());

$cch->execute();
$pendingch= $cch->fetchColumn();


$d = $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_assign='$wp_rep_id' and c_date BETWEEN '$end_date1' AND '$date'")or die(mysql_error());

$d->execute();
$doctor= $d->fetchColumn();


$df = $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_assign='$wp_rep_id'")or die(mysql_error());

$df->execute();
$approveddocotr= $df->fetchColumn();



$dfd = $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_assign='$wp_rep_id' and c_date BETWEEN '$end_date' AND '$date'")or die(mysql_error());

$dfd ->execute();
$unapproveddocotr= $dfd ->fetchColumn();


$penpob = $je->prepare("SELECT COUNT(*) FROM newlead WHERE repid='$wp_rep_id' and ordercheck='0'")or die(mysql_error());
$penpob->execute();
$pendingpob= $penpob->fetchColumn();

$apppob = $je->prepare("SELECT COUNT(*) FROM newlead WHERE repid='$wp_rep_id' and ordercheck='1'")or die(mysql_error());
$apppob->execute();
$approvedpob= $apppob->fetchColumn();

$delpob = $je->prepare("SELECT COUNT(*) FROM newlead WHERE repid='$wp_rep_id' and ordercheck='2'")or die(mysql_error());
$delpob->execute();
$deliveredpob= $delpob->fetchColumn();


$expensecal = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id' and reporteddate='$date'")or die(mysql_error());
$expensecal ->execute();
$expensescalculation= $expensecal ->fetchColumn();


$totchem = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id' and c_date BETWEEN '$end_date' AND '$date'")or die(mysql_error());
$totchem ->execute();
$totalchemistrep= $totchem ->fetchColumn();


$updchem = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id' and c_date BETWEEN '$end_date1' AND '$date'")or die(mysql_error());
$updchem ->execute();
$updatechemistrep= $updchem ->fetchColumn();


$unapprovedchemistrep= '0';

echo '[{"Total":"'.$total.'","Totalchemist":"'.$totalch.'","Visited":"'.$visited.'","Visitedch":"'.$visitedch.'","Pending":"'.$pending.'","Pendingch":"'.$pendingch.'","approveddoctor":"'.$approveddocotr.'","unapproveddoctor":"'.$unapproveddocotr.'","Doctor":"'.$doctor.'","NEWLEAD":"'.$pendingpob.'","DEAL":"'.$approvedpob.'","ORDER":"'.$deliveredpob.'","DAYWISE":"'.$expensescalculation.'","WEEKWISE":"'.$totalchemistrep.'","MONTHWISE":"'.$updatechemistrep.'","unapprovedchemistrep":"'.$unapprovedchemistrep.'","cudate":"'.$date.'"}]';

?>