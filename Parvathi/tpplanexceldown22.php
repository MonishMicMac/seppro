<?php
include("connect1.php");

$rep_id=$_REQUEST['rep_id'];
$contactt;

$year = $_REQUEST['year'];
$i='0';

$strSQL = mysql_query("SELECT expenses,leaveapplieddate,reasonforlessdr FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%' order by leaveapplieddate asc")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id'");
$date_res = mysql_fetch_array($datecount);

$pendingcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$pending_res = mysql_fetch_array($pendingcount);

$unavcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='1'");
$unav_res = mysql_fetch_array($unavcount);

$pencount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='0'");
$pen_res = mysql_fetch_array($pencount);


$contactt='[{"expenses":"'.$res['expenses'].'","'.reason.'":"'.$res['reasonforlessdr'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","planned":"'.$date_res['COUNT(wp_date)'].''.'","visited":"'.$pending_res['COUNT(wp_date)'].'","pending":"'.$pen_res['COUNT(wp_date)'].'","unav":"'.$unav_res['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id'");
$date_res = mysql_fetch_array($datecount);

$pendingcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$pending_res = mysql_fetch_array($pendingcount);

$unavcount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='1'");
$unav_res = mysql_fetch_array($unavcount);

$pencount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='0'");
$pen_res = mysql_fetch_array($pencount);



$contactt.='{"expenses":"'.$res['expenses'].'","'.reason.'":"'.$res['reasonforlessdr'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","planned":"'.$date_res['COUNT(wp_date)'].''.'","visited":"'.$pending_res['COUNT(wp_date)'].'","pending":"'.$pen_res['COUNT(wp_date)'].'","unav":"'.$unav_res['COUNT(wp_date)'].'"},';
}





}


$contactt;

$opt = substr($contactt,0,-1);
$optlen = strlen($opt);
if($optlen < 5)
{
echo '[]';
}
else
{
echo $opt.']';
}
?>