<?php
include("connect23.php"); 

$wp_rep_id=$_REQUEST['repid'];

$full_date=date("Y-m-d",strtotime($_REQUEST['date']));

$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$date=date("Y-m",strtotime($full_date));

$i=1;
$j=0;
while($i<=31){

$day=date("l",strtotime($date.'-'.$i));

if($j<=31 && $day!='Sunday'){

$auto_date=date("Y-m-d",strtotime($date.'-'.$i));
$jj = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj) == 0) {

$month1=date("m",strtotime($date.'-'.$i));
$month2=date("m",strtotime($full_date));
if($month1==$month2){
$j++;
}

}
}
$i++;
}


if ($j % 2 == 0) {
  $total=$j;
} else {
  $total=$j-1;
}

$tot1=$total/2;

$i1=1;
$j1=1;
while($i1<=31){

$day1=date("l",strtotime($date.'-'.$i1));

if($j1<=$tot1 && $day1!='Sunday'){

$auto_date1=date("Y-m-d",strtotime($date.'-'.$i1));
$jj1 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date1' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj1) == 0) {
$v1_date=$auto_date1;
//echo $v1_date.'<br>';
$j1++;
}
}
$i1++;
}


$i2=date('d', strtotime($v1_date.' +1 day'));
$j2=1;
while($i2<=31){

$day2=date("l",strtotime($date.'-'.$i2));

if($j2<=$tot1+1 && $day2!='Sunday'){

$auto_date2=date("Y-m-d",strtotime($date.'-'.$i2));
$jj2 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date2' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj2) == 0) {
$v2_date=$auto_date2;
//echo $v2_date.'<br>';
$j2++;
}
}
$i2++;
}




$v1_first=date('Y-m', strtotime($full_date)).'-01';
$v1_last=$v1_date;

$v2_first=date('Y-m-d', strtotime($v1_last.' +1 day'));
$v2_last=$v2_date;



if (($full_date >= $v1_first) && ($full_date <= $v1_last)) {
$minus_date=date("Y-m-d", strtotime($full_date.' -1 day'));

$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode,doctors.favourite FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_rep_id='$wp_rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND id not in (select wp_dc_id from tbl_work_plan where wp_rep_id='$wp_rep_id' and wp_dc='D' and date(wp_date) between '$v1_first' and '$minus_date' and attendancestatus='1' and drunavailable='0')";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
    
} elseif (($full_date >= $v2_first) && ($full_date <= $v2_last)) {

$minus_date=date("Y-m-d", strtotime($full_date.' -1 day'));

$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode,doctors.favourite FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_rep_id='$wp_rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND id not in (select wp_dc_id from tbl_work_plan where wp_rep_id='$wp_rep_id' and wp_dc='D' and date(wp_date) between '$v2_first' and '$minus_date' and attendancestatus='1' and drunavailable='0')";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

} else {
    echo '[]';
}

?>