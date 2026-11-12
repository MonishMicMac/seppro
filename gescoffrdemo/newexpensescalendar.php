<?php
include("connect1.php");

$rep_id=$_REQUEST['rep_id'];


$sql = mysql_query("SELECT rep_id FROM representative where id='$rep_id'");
$row=mysql_fetch_array($sql);
$reid=$row['rep_id'];

if($reid=='0')
{

$contactt;

$year = date('Y');
$i='0';

$strSQL = mysql_query("SELECT expenses,leaveapplieddate FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%'")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' and drunavailable='0'");
$date_res = mysql_fetch_array($datecount);

$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' and drunavailable='0'");
$date_res = mysql_fetch_array($datecount);


$contactt.='{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'"},';
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
}
else
{
$contactt;

$year = date('Y');
$i='0';

$strSQL = mysql_query("SELECT expenses,leaveapplieddate FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%'")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1' and drunavailable='0'");
$date_res = mysql_fetch_array($datecount);

$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1' and drunavailable='0'");
$date_res = mysql_fetch_array($datecount);


$contactt.='{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'"},';
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
}











?>