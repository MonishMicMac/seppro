<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;
$rest;
$jjres;
$strSQL = $je->prepare("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE representative.rep_id!='0' AND assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");

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

$a = $je->prepare("SELECT COUNT(*) FROM managerjoinworkplans WHERE date='$date' AND managerid='$wp_rep_id'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();

$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_rep_id='$wp_rep_id' AND wp_dc='D' AND attendancestatus='1'")or die(mysql_error());
$b->execute();
$totalb = $b->fetchColumn();

$h = $je->prepare("SELECT COUNT(*) FROM unapprovedtbl_work_plan WHERE wp_date='$date' AND wp_rep_id='$wp_rep_id' AND wp_dc='D' AND attendancestatus='1'")or die(mysql_error());
$h->execute();
$totalbu = $h->fetchColumn();

$c = $je->prepare("SELECT group_concat(rep_name) FROM managerjoinworkplans,representative WHERE managerjoinworkplans.date='$date' AND managerjoinworkplans.managerid='$wp_rep_id' AND representative.id=managerjoinworkplans.repid")or die(mysql_error());
$c->execute();
$totalc = $c->fetchColumn();


$d = $je->prepare("SELECT group_concat(representative.id) FROM managerjoinworkplans,representative WHERE managerjoinworkplans.date='$date' AND managerjoinworkplans.managerid='$wp_rep_id' AND representative.id=managerjoinworkplans.repid")or die(mysql_error());
$d->execute();
$totald = $d->fetchColumn();

$myString = $totald;
$myArray = explode(',', $myString);

$rest='';

for($yu=0;$yu<count($myArray);$yu++)
{
$byu = $je->prepare("SELECT COUNT(wp_id) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND doctors.id=tbl_work_plan.wp_dc_id AND doctors.rep_assign=$myArray[$yu]")or die(mysql_error());
$byu->execute();
$totalb1 = $byu->fetchColumn();


$rpnme=$je->prepare("SELECT rep_name FROM representative WHERE id='$myArray[$yu]'");
$rpnme->execute();
$rname = $rpnme->fetchColumn();

$rest.=$rname."-".$totalb1.",";
}

if($rest=='')
{
}
else
{
$rs=substr($rest,0,-1);
}































$rest2='';

for($yu2=0;$yu2<count($myArray);$yu2++)
{
$byu2 = $je->prepare("SELECT COUNT(wp_id) FROM unapprovedtbl_work_plan,unapproveddoctors WHERE unapprovedtbl_work_plan.wp_date='$date' AND unapprovedtbl_work_plan.wp_rep_id='$wp_rep_id' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.attendancestatus='1' AND unapproveddoctors.id=unapprovedtbl_work_plan.wp_dc_id AND unapproveddoctors.rep_assign=$myArray[$yu2]")or die(mysql_error());
$byu2->execute();
$totalb12 = $byu2->fetchColumn();


$rpnme2=$je->prepare("SELECT rep_name FROM representative WHERE id='$myArray[$yu2]'");
$rpnme2->execute();
$rname2 = $rpnme2->fetchColumn();

$rest2.=$rname2."-".$totalb12.",";
}

if($rest2=='')
{
}
else
{
$rs2=substr($rest2,0,-1);
}
























$rest1='';


for($yu1=0;$yu1<count($myArray);$yu1++)
{

$byu1 = $je->prepare("SELECT COUNT(wp_id) FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$myArray[$yu1]' AND FIND_IN_SET('$wp_rep_id', tbl_work_plan.jointworkby) AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND doctors.id=tbl_work_plan.wp_dc_id AND doctors.rep_assign=$myArray[$yu1]")or die(mysql_error());
$byu1->execute();
$totalb11 = $byu1->fetchColumn();
$rpnme1=$je->prepare("SELECT rep_name FROM representative WHERE id='$myArray[$yu1]'");
$rpnme1->execute();
$rname1 = $rpnme1->fetchColumn();

$rest1.=$rname1."-".$totalb11.",";
}

if($rest1=='')
{
}
else
{
$rs1=substr($rest1,0,-1);
}



$outpu='{"REPID":"'.$repidd.'","REPNAME":"'.$repname.'","joinvst":"'.$rs1.'","DRVISITED":"'.$totalb.'","UNAPPROVEDRVISITED":"'.$totalbu.'","VSTWITHREP":"'.$rs.'","NAMES":"'.$totalc.'","REP":"'.$total.'","UNVSTWITHREP":"'.$rs2.'"},';


$outpu1.=$outpu;
}


$finaloutput= substr($outpu1, 0, -1);

echo "[".$finaloutput."]";

?>