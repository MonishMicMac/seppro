<?php
include("connect.php"); 
$x = $je->prepare("SELECT * FROM representative");
$x->execute();

$count = $x->rowCount();

echo "[{";
$i = 0;
$array= $x->fetchAll(PDO::FETCH_ASSOC);
foreach($array as $ps)
{
$i++;
date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');
$wp_rep_id= $ps['id'];

global $total,$visited,$pending,$doctor,$totalf;

$a = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_rep_id='$wp_rep_id' AND UP='P'")or die(mysql_error());

$a->execute();
$total= $a->fetchColumn();


$ft = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_rep_id='$wp_rep_id' AND UP='U'")or die(mysql_error());
$ft->execute();
$totalf = $ft->fetchColumn();



$b = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_rep_id='$wp_rep_id' AND latitude!='' AND longitude!=''")or die(mysql_error());
$b->execute();
$visited = $b->fetchColumn();



$c = $je->prepare("SELECT COUNT(*) FROM tbl_work_plan WHERE wp_date='$date' AND wp_rep_id='$wp_rep_id' AND latitude='' AND longitude=''")or die(mysql_error());
$c->execute();
$pending = $c->fetchColumn();



$d = $je->prepare("SELECT COUNT(*) FROM doctors WHERE c_date='$date' AND rep_id='$wp_rep_id'")or die(mysql_error());
$d->execute();
$doctor = $d->fetchColumn();

if($i ===$count)
{
echo '"repid":"'.$wp_rep_id.'","repname":"'.$ps['rep_name'].'","planned":"'.$total.'","unplanned":"'.$totalf.'","visited":"'.$visited.'","pending":"'.$pending.'","doctor":"'.$doctor.'"';

}
else
{
echo '"repid":"'.$wp_rep_id.'","repname":"'.$ps['rep_name'].'","planned":"'.$total.'","unplanned":"'.$totalf.'","visited":"'.$visited.'","pending":"'.$pending.'","doctor":"'.$doctor.'"},{';
}
}
echo "}]";

?>