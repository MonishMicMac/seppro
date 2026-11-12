<?php
include("connect.php"); 

  date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d'); //Returns IST 
$wp_rep_id= $_REQUEST['wp_rep_id'];
$oldversion= $_REQUEST['oldversion'];
global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep;













$full_date=$date;

$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$date1=date("Y-m",strtotime($full_date));

$i=1;
$j=0;
while($i<=31){

$day=date("l",strtotime($date1.'-'.$i));

if($j<=31 && $day!='Sunday'){

$auto_date=date("Y-m-d",strtotime($date1.'-'.$i));
$jj = $je->prepare("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
$jj->execute();

if($jj->fetchColumn() == 0) {

$month1=date("m",strtotime($date1.'-'.$i));
$month2=date("m",strtotime($full_date));
if($month1==$month2){
$j++;
}

}
}
$i++;
}


if ($j % 2 == 0) {
  $total=$j;
} else {
  $total=$j-1;
}

$tot1=$total/2;

$i1=1;
$j1=1;
while($i1<=31){

$day1=date("l",strtotime($date1.'-'.$i1));

if($j1<=$tot1 && $day1!='Sunday'){

$auto_date1=date("Y-m-d",strtotime($date1.'-'.$i1));
$jj1 = $je->prepare("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date1' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
$jj1->execute();

if($jj1->fetchColumn() == 0) {
$v1_date=$auto_date1;
$j1++;
}
}
$i1++;
}


$i2=date('d', strtotime($v1_date.' +1 day'));
$j2=1;
while($i2<=31){

$day2=date("l",strtotime($date1.'-'.$i2));

if($j2<=$tot1+1 && $day2!='Sunday'){

$auto_date2=date("Y-m-d",strtotime($date1.'-'.$i2));
$jj2 = $je->prepare("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date2' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
$jj2->execute();

if($jj2->fetchColumn() == 0) {
$v2_date=$auto_date2;
$j2++;
}
}
$i2++;
}




$v1_first=date('Y-m', strtotime($full_date)).'-01';
$v1_last=$v1_date;

$v2_first=date('Y-m-d', strtotime($v1_last.' +1 day'));
$v2_last=$v2_date;


$cnt=$je->prepare("select COUNT(*) from doctors where rep_assign='$wp_rep_id'");
$cnt->execute();
$total_cnt= $cnt->fetchColumn();


if (($full_date >= $v1_first) && ($full_date <= $v1_last)) {

$v1=$je->prepare("select COUNT(*) from doctors where id in (select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$wp_rep_id' and date(wp_date) between '$v1_first' and '$full_date' and attendancestatus='1' and drunavailable='0')");
$v1->execute();
$v1_dr_list= $v1->fetchColumn();

$dr_full_cnt=$total_cnt-$v1_dr_list;

} elseif (($full_date >= $v2_first) && ($full_date <= $v2_last)) {

$v2=$je->prepare("select COUNT(*) from doctors where id in (select wp_dc_id from tbl_work_plan where wp_dc='D' and wp_rep_id='$wp_rep_id' and date(wp_date) between '$v2_first' and '$full_date' and attendancestatus='1' and drunavailable='0')");
$v2->execute();
$v2_dr_list= $v2->fetchColumn();

$dr_full_cnt=$total_cnt-$v2_dr_list;
}





















$upppp = $je->prepare("UPDATE representative SET oldversionusing='$oldversion' WHERE id='$wp_rep_id'")or die(mysql_error());
$upppp ->execute();




$a = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();

$ach = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='C' AND wp_rep_id='$wp_rep_id'")or die(mysql_error());
$ach->execute();
$totalch = $ach->fetchColumn();



$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());

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


$favdocvisit= $je->prepare("SELECT COUNT(*) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.`wp_date`='$date'")or die(mysql_error());

$favdocvisit->execute();
$favdocvisitcnt = $favdocvisit->fetchColumn();



$favdocpending= $je->prepare("SELECT COUNT(*) FROM `tbl_work_plan`,doctors WHERE `wp_date` = '$date' AND `wp_dc` LIKE 'D' AND attendancestatus='0' AND `favourite`='1' AND `wp_rep_id` ='$wp_rep_id' AND tbl_work_plan.wp_dc_id=doctors.id")or die(mysql_error());

$favdocpending->execute();
$favdocpendingcnt=$favdocpending->fetchColumn();




$updatechemistrep= '0';


$unapprovedchemistrep= '0';

echo '[{"Total":"'.$total.'","Totalchemist":"'.$totalch.'","Visited":"'.$visited.'","Visitedch":"'.$visitedch.'","Pending":"'.$pending.'","Pendingch":"'.$pendingch.'","approveddoctor":"'.$approveddocotr.'","unapproveddoctor":"'.$unapproveddocotr.'","Doctor":"'.$doctor.'","PENDINGPOB":"'.$pendingpob.'","APPROVEDPOB":"'.$approvedpob.'","deliveredpob":"'.$deliveredpob.'","expensesswe":"'.$expensescalculation.'","totalchemistrep":"'.$totalchemistrep.'","updatechemistrep":"'.$updatechemistrep.'","unapprovedchemistrep":"'.$unapprovedchemistrep.'","cudate":"'.$date.'","favdoc":"'.$totalfavdoccnt.'","favdocvisit":"'.$favdocvisitcnt.'","favdocpending":"'.$favdocpendingcnt.'","dr_full_cnt":"'.$dr_full_cnt.'"}]';

?>