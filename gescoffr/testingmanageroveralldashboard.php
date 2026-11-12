<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;





$strSQL = $je->prepare("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");

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

$a = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();


$ttbddpp = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D'  AND doctors.favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.`wp_date`='$date'")or die(mysql_error());

$ttbddpp->execute();
$ttvisitedddpp= $ttbddpp->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$totalch = $ach->fetchColumn();



$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());

$b->execute();
$visited= $b->fetchColumn();

$bdd = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.`wp_date`='$date'")or die(mysql_error());

$bdd->execute();
$visiteddd= $bdd->fetchColumn();

$bch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate!=''")or die(mysql_error());

$bch->execute();
$visitedch= $bch->fetchColumn();


$c = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());

$c->execute();
$pending= $c->fetchColumn();


$bddpp = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.attendancestatus='0' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.`wp_date`='$date'")or die(mysql_error());

$bddpp->execute();
$visitedddpp= $bddpp->fetchColumn();

$cch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());

$cch->execute();
$pendingch= $cch->fetchColumn();


$d = $je->prepare("SELECT COUNT(*) FROM doctors WHERE c_date='$date' AND rep_id='$wp_rep_id'")or die(mysql_error());

$d->execute();
$doctor= $d->fetchColumn();


$df = $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_assign='$wp_rep_id'")or die(mysql_error());

$df->execute();
$approveddocotr= $df->fetchColumn();



$dfd = $je->prepare("SELECT COUNT(*) FROM temp_doctor_store WHERE repid='$wp_rep_id'")or die(mysql_error());

$dfd ->execute();
$unapproveddocotr= $dfd ->fetchColumn();


$penpob = $je->prepare("SELECT COUNT(DISTINCT pobbillno) FROM mst_pob WHERE cdate='$date' AND repid='$wp_rep_id' AND pobstatus='0'")or die(mysql_error());
$penpob->execute();
$pendingpob= $penpob->fetchColumn();

$apppob = $je->prepare("SELECT COUNT(DISTINCT pobbillno) FROM mst_pob WHERE cdate='$date' AND repid='$wp_rep_id' AND pobstatus='1'")or die(mysql_error());
$apppob->execute();
$approvedpob= $apppob->fetchColumn();

$delpob = $je->prepare("SELECT COUNT(DISTINCT pobbillno) FROM mst_pob WHERE cdate='$date' AND repid='$wp_rep_id' AND pobstatus='2'")or die(mysql_error());
$delpob->execute();
$deliveredpob= $delpob->fetchColumn();


$expensecal = $je->prepare("SELECT COUNT(DISTINCT id) FROM repgivenasleave WHERE leaveapplieddate='$date' AND repid='$wp_rep_id'")or die(mysql_error());
$expensecal ->execute();
$expensescalculation= $expensecal ->fetchColumn();


$totchem = $je->prepare("SELECT COUNT(DISTINCT id) FROM tbl_customer_master WHERE rep_id='$wp_rep_id'")or die(mysql_error());
$totchem ->execute();
$totalchemistrep= $totchem ->fetchColumn();


$updchem = $je->prepare("SELECT COUNT(DISTINCT id) FROM tbl_customer_master WHERE rep_id='$wp_rep_id' ANc_date='$date'")or die(mysql_error());
$updchem ->execute();
$updatechemistrep= '0';


$unapprovedchemistrep= '0';






$favdoccnt= $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_id='$wp_rep_id' AND favourite='1'")or die(mysql_error());
$favdoccnt->execute();
$totalfavdoccnt = $favdoccnt->fetchColumn();

$date1=date('Y-m');
$favdocvisit= $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_date like '%$date1%'")or die(mysql_error());

$favdocvisit->execute();
$favdocvisitcnt = $favdocvisit->fetchColumn();



/*$favdocpending= $je->prepare("SELECT COUNT(*) FROM `tbl_work_plan`,doctors WHERE `wp_date` = '$date' AND `wp_dc` LIKE 'D' AND attendancestatus='0' AND `favourite`='1' AND `wp_rep_id` ='$wp_rep_id' AND tbl_work_plan.wp_dc_id=doctors.id")or die(mysql_error());

$favdocpending->execute();
$favdocpendingcnt=$favdocpending->fetchColumn();*/


$favdocpendingcnt=$totalfavdoccnt-$favdocvisitcnt;



$outpu='{"REPID":"'.$repidd.'","REPNAME":"'.$repname.'","Total":"'.$total."(".$ttvisitedddpp.")".'","Totalchemist":"'.$totalch.'","Visited":"'.$visited."(".$visiteddd.")".'","Visitedch":"'.$visitedch.'","Pending":"'.$pending."(".$visitedddpp.")".'","Pendingch":"'.$pendingch.'","approveddoctor":"'.$approveddocotr.'","unapproveddoctor":"'.$unapproveddocotr.'","Doctor":"'.$doctor.'","PENDINGPOB":"'.$pendingpob.'","APPROVEDPOB":"'.$approvedpob.'","deliveredpob":"'.$deliveredpob.'","expensesswe":"'.$expensescalculation.'","totalchemistrep":"'.$totalchemistrep.'","updatechemistrep":"'.$updatechemistrep.'","unapprovedchemistrep":"'.$unapprovedchemistrep.'","tfv":"'.$totalfavdoccnt.'","vtfv":"'.$favdocvisitcnt.'","uvtfv":"'.$favdocpendingcnt.'"},';


$outpu1.=$outpu;
}


$finaloutput= substr($outpu1, 0, -1);

echo "[".$finaloutput."]";

?>