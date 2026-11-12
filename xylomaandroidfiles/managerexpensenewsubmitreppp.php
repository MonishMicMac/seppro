<?php
$con=mysql_connect("localhost","root","$3pp60@2016");
	mysql_select_db("xyloma");
 

$rep_id=$_REQUEST['rep_id'];
$contactt;

$year1 = 2017;
$year = date('Y');
$month = date('m');
$month3 = date('m', strtotime('-6 month'));
$i='0';




$jjreprmgr = mysql_query("SELECT rep_id FROM representative WHERE id='".$_REQUEST['rep_id']."'")or die(mysql_error()); 
$jjreprmgr_res = mysql_fetch_array($jjreprmgr);



if($jjreprmgr_res['rep_id']!='0')
{

$strSQL = mysql_query("SELECT expenses,leaveapplieddate,expenses_status FROM  repgivenasleave  WHERE repid='$rep_id' AND YEAR( `leaveapplieddate` ) ='$year' AND MONTH( `leaveapplieddate` ) BETWEEN '$month3' AND '$month'")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{





$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","expenses_status":"'.$res['expenses_status'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1'");
$date_res = mysql_fetch_array($datecount);


$contactt.='{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","expenses_status":"'.$res['expenses_status'].'"},';
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
	// echo "SELECT expenses,leaveapplieddate,expenses_status FROM  repgivenasleave  WHERE repid='$rep_id' AND  YEAR( `leaveapplieddate` ) ='$year' AND MONTH( `leaveapplieddate` ) BETWEEN '$month3' AND '$month'";


$strSQL = mysql_query("SELECT expenses,leaveapplieddate,expenses_status FROM  repgivenasleave  WHERE repid='$rep_id' AND  YEAR( `leaveapplieddate` ) ='$year' AND MONTH( `leaveapplieddate` ) BETWEEN '$month3' AND '$month'")or die(mysql_error());
while($res = mysql_fetch_array($strSQL))
{
if($i=='0')
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1'");
$date_res = mysql_fetch_array($datecount);



$datecountss = mysql_query("SELECT max(rep_area.pin_amt) as amt,rep_area.pin_id,rep_area.rep_teritary_kms as kms,rep_area.rep_teritary_fare as fare,rep_area.rep_teritary_allowance as allowance,doctors.id,tbl_work_plan.wp_date,representative.id,representative.rep_name FROM tbl_work_plan,doctors,rep_area,representative WHERE wp_date BETWEEN '".$res['leaveapplieddate']."' AND '".$res['leaveapplieddate']."' AND tbl_work_plan.wp_rep_id = '".$rep_id."' and rep_area.rep_id='".$rep_id."' AND attendancestatus='1' and doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.wp_dc='D' AND doctors.doc_pin_id=rep_area.pin_id AND representative.id='".$rep_id."'  GROUP BY tbl_work_plan.wp_date desc");

if($date_res['COUNT(wp_date)']==0)
{
	if($res['expenses']=="meeting")
	{
    $po='150';
	}
	else
	{
		$po='0';
	}
}
else
{

while($resss = mysql_fetch_array($datecountss))
{
$po=$resss['amt'];

}

}


$contactt='[{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","amt":"'.$po.'","expenses_status":"'.$res['expenses_status'].'"},';

$i++;
}
else
{

$datecount = mysql_query("SELECT COUNT(wp_date) FROM tbl_work_plan WHERE wp_date='".$res['leaveapplieddate']."' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1'");
$date_res = mysql_fetch_array($datecount);

if($date_res['COUNT(wp_date)']==0)
{
	if($res['expenses']=="meeting")
	{
    $po='150';
	}
	else
	{
		$po='0';
	}

}
else
{
$datecountss = mysql_query("SELECT max(rep_area.pin_amt) as amt,rep_area.pin_id,rep_area.rep_teritary_kms as kms,rep_area.rep_teritary_fare as fare,rep_area.rep_teritary_allowance as allowance,doctors.id,tbl_work_plan.wp_date,representative.id,representative.rep_name FROM tbl_work_plan,doctors,rep_area,representative WHERE wp_date BETWEEN '".$res['leaveapplieddate']."' AND '".$res['leaveapplieddate']."' AND tbl_work_plan.wp_rep_id = '".$rep_id."' and rep_area.rep_id='".$rep_id."' AND attendancestatus='1' and doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.wp_dc='D' AND doctors.doc_pin_id=rep_area.pin_id AND representative.id='".$rep_id."'  GROUP BY tbl_work_plan.wp_date desc");

while($resss = mysql_fetch_array($datecountss))
{
$po=$resss['amt'];

}
}

$contactt.='{"expenses":"'.$res['expenses'].'","'.leaveapplieddate.'":"'.$res['leaveapplieddate'].'","dr":"'.$date_res['COUNT(wp_date)'].'","amt":"'.$po.'","expenses_status":"'.$res['expenses_status'].'"},';
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