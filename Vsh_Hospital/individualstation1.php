<?php
include("connect23.php"); 


$repid=$_REQUEST['repid'];

$ladate=$_REQUEST['month1'];






echo '[{';


global $str;

$individual = mysql_query("SELECT  * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate LIKE '$ladate%' order by leaveapplieddate desc")or die(mysql_error());

while($individual_res = mysql_fetch_array($individual))
{

$tbl = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());


$tbl_res = mysql_fetch_array($tbl);

$tbl2 = mysql_query("SELECT GROUP_CONCAT(jointworkby) AS jointworkby FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());


$tbl_res2 = mysql_fetch_array($tbl2);



$tbl1 = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM unapprovedtbl_work_plan WHERE wp_dc='D' AND wp_rep_id='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());


$tbl_res1 = mysql_fetch_array($tbl1);

$df=$tbl_res['CNT']+$tbl_res1['CNT'];




$str.='"count":"'.$df.'","expenses":"'.$individual_res['expenses'].'","jointworkby":"'.$tbl_res2['jointworkby'].'","jjvisdate":"'.$individual_res['leaveapplieddate'].'"},{';
}



echo substr($str,0,-2).']';


?>