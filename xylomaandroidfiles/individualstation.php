<?php
include("connect23.php"); 
$repid=$_REQUEST['repid'];

$ladate=$_REQUEST['month1'];

$sql = mysql_query("SELECT rep_id FROM representative where id='$repid'");
$row=mysql_fetch_array($sql);
$reid=$row['rep_id'];

echo '[{';

if($reid=='0')
{

global $str;

$individual = mysql_query("SELECT  * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate LIKE '$ladate%' order by leaveapplieddate desc")or die(mysql_error());

while($individual_res = mysql_fetch_array($individual))
{

$tbl = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());


$tbl_res = mysql_fetch_array($tbl);




$str.='"count":"'.$tbl_res['CNT'].'","expenses":"'.$individual_res['expenses'].'","jjvisdate":"'.$individual_res['leaveapplieddate'].'"},{';
}
}
else
{
global $str;

$individual = mysql_query("SELECT  * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate LIKE '$ladate%' order by leaveapplieddate desc")or die(mysql_error());

while($individual_res = mysql_fetch_array($individual))
{

$tbl = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='D' AND jointworkby='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());


$tbl_res = mysql_fetch_array($tbl);




$str.='"count":"'.$tbl_res['CNT'].'","expenses":"'.$individual_res['expenses'].'","jjvisdate":"'.$individual_res['leaveapplieddate'].'"},{';
}
}




echo substr($str,0,-2).']';


?>