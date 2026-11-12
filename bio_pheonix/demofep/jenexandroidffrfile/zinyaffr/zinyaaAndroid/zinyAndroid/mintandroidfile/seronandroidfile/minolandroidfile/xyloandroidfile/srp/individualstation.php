<?php
include("connect2.php"); 


$repid=$_REQUEST['repid'];

$ladate=$_REQUEST['month1'];



echo '[{';

global $str;

$individual = mysql_query("SELECT  * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate LIKE '$ladate%'")or die(mysql_error());

while($individual_res = mysql_fetch_array($individual))
{

$tbl = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1'")or die(mysql_error());


$tbl_res = mysql_fetch_array($tbl);




$str.='"count":"'.$tbl_res['CNT'].'","expenses":"'.$individual_res['expenses'].'","jjvisdate":"'.$individual_res['leaveapplieddate'].'"},{';
}

echo substr($str,0,-2).']';
?>