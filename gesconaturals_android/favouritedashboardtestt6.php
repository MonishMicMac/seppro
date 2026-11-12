<?php
include("connect.php"); 

  date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); //Returns IST 
$wp_rep_id= $_REQUEST['wp_rep_id'];
$oldversion= $_REQUEST['oldversion'];
global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep;



$upppp = $je->prepare("UPDATE representative SET oldversionusing='$oldversion' WHERE id='$wp_rep_id'")or die(mysql_error());
$upppp ->execute();




$a = $je->prepare("SELECT dt_planned FROM representative WHERE id='$wp_rep_id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$totalch = $ach->fetchColumn();

// echo "SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1'";

$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1'")or die(mysql_error());

$b->execute();
$visited= $b->fetchColumn();

$bch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate!=''")or die(mysql_error());

$bch->execute();
$visitedch= $bch->fetchColumn();


$c = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());

$c->execute();
// $pending= $c->fetchColumn();

$pending=$total-$visited;

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


$updchem = $je->prepare("SELECT COUNT(DISTINCT id) FROM tbl_customer_master WHERE rep_id='$wp_rep_id' AND c_date='$date'")or die(mysql_error());
$updchem ->execute();


$favdoccnt= $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_id='$wp_rep_id' AND favourite='1'")or die(mysql_error());
$favdoccnt->execute();
$totalfavdoccnt = $favdoccnt->fetchColumn();

$pobqty= $je->prepare("SELECT sum(qty) AS qty FROM pobbooking WHERE repid='$wp_rep_id' AND cdate LIKE '".date('Y-m-d')."'")or die(mysql_error());
$pobqty->execute();
$totalpobqty = $pobqty->fetchColumn();

$pobqty1= $je->prepare("SELECT count(DISTINCT client_id) AS client_id FROM pobbooking WHERE repid='$wp_rep_id' AND cdate LIKE '".date('Y-m-d')."'")or die(mysql_error());
$pobqty1->execute();
$totalclient = $pobqty1->fetchColumn();

// echo "SELECT sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt,((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt FROM `pobbooking` WHERE `repid`='$wp_rep_id' AND cdate LIKE '%".date('Y-m')."%' GROUP BY productid";

$monthpobtotal= $je->prepare("SELECT ((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt,sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt FROM `pobbooking` WHERE `repid`='$wp_rep_id' AND cdate LIKE '%".date('Y-m')."%' GROUP BY productid")or die(mysql_error());
$monthpobtotal->execute();
while($monthpobtotal_row = $monthpobtotal->fetch(PDO::FETCH_ASSOC))
{
	$monthpobtotal_rownew+=$monthpobtotal_row['totamt'];
}
// echo $monthpobtotal_rownew;

$datepobtotal= $je->prepare("SELECT ((sum(qty))*(select ptr from product where id=pobbooking.productid)) AS totamt,sum(qty) AS qty,productid,(select ptr from product where id=pobbooking.productid) AS amt FROM `pobbooking` WHERE `repid`='$wp_rep_id' AND cdate LIKE '%".date('Y-m-d')."%' GROUP BY productid")or die(mysql_error());
$datepobtotal->execute();
while($datepobtotal_row = $datepobtotal->fetch(PDO::FETCH_ASSOC))
{
	$datepobtotal_rownew+=$datepobtotal_row['totamt'];
}

if($datepobtotal_rownew=='')
{
	$datepobtotal_rownew1s='0';
}
else
{
	$datepobtotal_rownew1s=$datepobtotal_rownew;
}





$favdocvisit= $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.`wp_date`='$date'")or die(mysql_error());

$favdocvisit->execute();
$favdocvisitcnt = $favdocvisit->fetchColumn();



$favdocpending= $je->prepare("SELECT COUNT(*) FROM `tbl_work_plan`,doctors WHERE `wp_date` = '$date' AND `wp_dc` LIKE 'D' AND attendancestatus='0' AND `favourite`='1' AND `wp_rep_id` ='$wp_rep_id' AND tbl_work_plan.wp_dc_id=doctors.id")or die(mysql_error());

$favdocpending->execute();
$favdocpendingcnt=$favdocpending->fetchColumn();




$updatechemistrep= '0';


$unapprovedchemistrep= '0';

echo '[{"Total":"'.$total.'","Totalchemist":"'.$totalch.'","Visited":"'.$visited.'","Visitedch":"'.$visitedch.'","Pending":"'.$pending.'","Pendingch":"'.$pendingch.'","approveddoctor":"'.$approveddocotr.'","unapproveddoctor":"'.$unapproveddocotr.'","Doctor":"'.$doctor.'","PENDINGPOB":"'.$pendingpob.'","APPROVEDPOB":"'.$approvedpob.'","deliveredpob":"'.$deliveredpob.'","expensesswe":"'.$expensescalculation.'","totalchemistrep":"'.$totalchemistrep.'","updatechemistrep":"'.$updatechemistrep.'","unapprovedchemistrep":"'.$unapprovedchemistrep.'","cudate":"'.$date.'","favdoc":"'.$totalfavdoccnt.'","favdocvisit":"'.$favdocvisitcnt.'","favdocpending":"'.$favdocpendingcnt.'","totalpobqty":"'.$totalpobqty.'","totalclient":"'.$totalclient.'","primarytotaldatepob":"0","primarytotalmonthpob":"0","totalmonthpob":"'.$monthpobtotal_rownew.'","totaldatepob":"'.$datepobtotal_rownew1s.'"}]';

?>