<?php
include("connect2.php"); 


$rep_id=$_REQUEST['rep_id'];
$contactt;

$year = date('Y');
$i='0';




$jjreprmgr = mysql_query("SELECT rep_id FROM representative WHERE id='".$_REQUEST['rep_id']."'")or die(mysql_error()); 
$jjreprmgr_res = mysql_fetch_array($jjreprmgr);



if($jjreprmgr_res['rep_id']!='0')
{
 

$strSQL = mysql_query("SELECT expenses,leaveapplieddate FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%'")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1'");
$date_res = mysql_fetch_array($datecount);

$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1'");
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

$strSQL = mysql_query("SELECT expenses,leaveapplieddate FROM  repgivenasleave  WHERE repid='$rep_id' AND leaveapplieddate like '$year%'")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1'");
$date_res = mysql_fetch_array($datecount);

$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1'");
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