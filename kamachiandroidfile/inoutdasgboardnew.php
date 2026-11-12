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

$repid= $_REQUEST['repid'];
global $total,$visited,$pending,$doctor,$approveddocotr,$unapproveddocotr,$approvedpob,$pendingpob,$deliveredpob,$expensescalculation,$totalchemistrep,$updatechemistrep,$unapprovedchemistrep,$td;

$a = $je->prepare("SELECT COUNT(*) FROM sampletimeinandout WHERE scheduledate='$date'  AND repid='$repid'")or die(mysql_error());
$a->execute();
$total = $a->fetchColumn();


$b = $je->prepare("SELECT COUNT(*) FROM sampletimeinandout WHERE scheduledate='$date' AND repid='$repid' AND feedback!='' AND outfeedback!=''")or die(mysql_error());

$b->execute();
$visited= $b->fetchColumn();




$c = $je->prepare("SELECT COUNT(*) FROM sampletimeinandout WHERE scheduledate='$date'  AND repid='$repid' AND feedback=''")or die(mysql_error());

$c->execute();
$pending= $c->fetchColumn();

$total1=array();
$c =$je->prepare("SELECT timediff FROM sampletimeinandout WHERE scheduledate='$date' AND repid='$repid' AND feedback!='' AND outfeedback!=''")or die(mysql_error());
$c->execute();
$total1= $c->fetchAll(PDO::FETCH_COLUMN);
 $sum = strtotime('00:00:00');
 $sum2=0;  
 foreach ($total1 as $v){

        $sum1=strtotime($v)-$sum;

        $sum2 = $sum2+$sum1;
    }

    $sum3=$sum+$sum2;
    $td= date("H:i:s",$sum3);

echo '[{"Total":"'.$total.'","Visited":"'.$visited.'","Pending":"'.$td.'","cudate":"'.$date.'"}]';

?>