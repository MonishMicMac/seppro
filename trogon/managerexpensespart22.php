<?php
include("connect23.php"); 

$rep_id=$_REQUEST['rep_id'];
$contactt;

//$year = date('Y');
$year = date('Y-m-');
// $year = '2018-11-';

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

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res = mysql_fetch_array($datecount);

$datecount1 = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='C' AND jointworkby='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res1 = mysql_fetch_array($datecount1);

$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","ch":"'.$date_res1['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res = mysql_fetch_array($datecount);

$datecount1 = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='C' AND jointworkby='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res1 = mysql_fetch_array($datecount1);


$contactt.='{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","ch":"'.$date_res1['COUNT(wp_date)'].'"},';
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

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res = mysql_fetch_array($datecount);

$datecount1 = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='C' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res1 = mysql_fetch_array($datecount1);

$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","ch":"'.$date_res1['COUNT(wp_date)'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res = mysql_fetch_array($datecount);


$datecount1 = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='C' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
$date_res1 = mysql_fetch_array($datecount1);


$contactt.='{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","ch":"'.$date_res1['COUNT(wp_date)'].'"},';
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

if($_REQUEST['holiday']=='holiday')
{
$selectrep = mysql_query("SELECT rep_id FROM representative")or die(mysql_error()); 
while($selectrep_res = mysql_fetch_array($selectrep))
{
	mysql_query("insert into repgivenasleave(repid,leaveapplieddate,date,time,reason,expenses)values('".$selectrep_res['rep_id']."','".$_REQUEST['leavedate']."','".date('Y-m-d')."','".date('H:i:s')."','".$_REQUEST['reason']."','".$_REQUEST['expense']."')")or die(mysql_error());
}
}


?>