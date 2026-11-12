<?php
include("../connect.php"); 
mysql_select_db("bio_pheonix");

date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d'); //Returns IST 
$wp_rep_id = $_REQUEST['wp_rep_id'];
$oldversion = $_REQUEST['oldversion'];
global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep;

// The version update logic is preserved as per request, but excluded from the API's JSON output
$upppp = $je->prepare("UPDATE representative SET oldversionusing='$oldversion' WHERE id='$wp_rep_id'")or die(mysql_error());
$upppp ->execute();

$a = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();

$anew = $je->prepare("SELECT COUNT(*) FROM unapprovedtbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$anew->execute();
$totalunapprovednew = $anew->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$totalch = $ach->fetchColumn();

$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());
$b->execute();
$visited= $b->fetchColumn();

$bnew = $je->prepare("SELECT COUNT(*) FROM unapprovedtbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());
$bnew ->execute();
$visitedapprovednew= $bnew ->fetchColumn();

$bch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate!=''")or die(mysql_error());
$bch->execute();
$visitedch= $bch->fetchColumn();

$c = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());
$c->execute();
$pending= $c->fetchColumn();

$cnew = $je->prepare("SELECT COUNT(*) FROM unapprovedtbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());
$cnew ->execute();
$pendingunapprovednew= $cnew ->fetchColumn();

$cch = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id' AND reporteddate=''")or die(mysql_error());
$cch->execute();
$pendingch= $cch->fetchColumn();

$d = $je->prepare("SELECT COUNT(*) FROM doctors WHERE c_date='$date' AND rep_id='$wp_rep_id'")or die(mysql_error());
$d->execute();
$doctor= $d->fetchColumn();

$df = $je->prepare("SELECT COUNT(*) FROM doctors WHERE rep_assign='$wp_rep_id'")or die(mysql_error());
$df->execute();
$approveddocotr= $df->fetchColumn();

$dfd = $je->prepare("SELECT COUNT(*) FROM unapproveddoctors WHERE rep_assign='$wp_rep_id'")or die(mysql_error());
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

$favdocvisit= $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.`wp_date`='$date'")or die(mysql_error());
$favdocvisit->execute();
$favdocvisitcnt = $favdocvisit->fetchColumn();

$favdocpending= $je->prepare("SELECT COUNT(*) FROM `tbl_work_plan`,doctors WHERE `wp_date` = '$date' AND `wp_dc` LIKE 'D' AND attendancestatus='0' AND `favourite`='1' AND `wp_rep_id` ='$wp_rep_id' AND tbl_work_plan.wp_dc_id=doctors.id")or die(mysql_error());
$favdocpending->execute();
$favdocpendingcnt=$favdocpending->fetchColumn();

$updatechemistrep= '0';
$unapprovedchemistrep= '0';

// Built dashboard array object excluding target elements
$dashboardData = array(
    "Total" => $total,
    "Totalchemist" => $totalch,
    "Visited" => $visited,
    "Visitedch" => $visitedch,
    "Pending" => $pending,
    "Pendingch" => $pendingch,
    "approveddoctor" => $approveddocotr,
    "unapproveddoctor" => $unapproveddocotr,
    "Doctor" => $doctor,
    "PENDINGPOB" => $pendingpob,
    "APPROVEDPOB" => $approvedpob,
    "deliveredpob" => $deliveredpob,
    "expensesswe" => $expensescalculation,
    "totalchemistrep" => $totalchemistrep,
    "updatechemistrep" => $updatechemistrep,
    "unapprovedchemistrep" => $unapprovedchemistrep,
    "cudate" => $date,
    "favdoc" => $totalfavdoccnt,
    "favdocvisit" => $favdocvisitcnt,
    "favdocpending" => $favdocpendingcnt,
    "unapprovednewvisited" => $visitedapprovednew,
    "unapprovednewpending" => $pendingunapprovednew,
    "unapprovednewtotal" => $totalunapprovednew
);

// Wrapped structural footprint to use status and message flags
$response = array(
    "status" => true,
    "message" => "Data retrieved successfully",
    "data" => array($dashboardData)
);

header('Content-Type: application/json');
echo json_encode($response);
?>