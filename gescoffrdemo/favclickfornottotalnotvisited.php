<?php

include("connect1.php");


date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d');
$wp_rep_id=$_REQUEST['wp_rep_id'];
$attendancestatus=$_REQUEST['attendancestatus'];

if($attendancestatus=='1')

{
$date1=date('Y-m');
$strSQL = "SELECT doctors.id,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode,doctors.doctor_addrs,doctors.doc_hospital_clinic_name,doctors.approvedby,doctors.managerlat,doctors.managerlong,doctors.dr_latitude,doctors.dr_longitude,doctors.c_date,doctors.c_time,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_date like '%$date1%' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_rep_id ='$wp_rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND doctors.favourite='1'";

}
else
{

$date1=date('Y-m');
$strSQL = "SELECT * FROM doctors WHERE rep_assign ='$wp_rep_id' AND doctors.favourite='1' AND id NOT IN (select wp_dc_id from tbl_work_plan where attendancestatus='1' AND drunavailable='0' AND wp_date like '%$date1%' AND wp_dc='D')";

}

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
	
	
	
	echo json_encode($resultArray);
?>