<?php

include("connect23.php"); 

date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-m-d');
$wp_rep_id=$_REQUEST['wp_rep_id'];
$attendancestatus=$_REQUEST['attendancestatus'];



$strSQL = "SELECT doctors.id,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode,doctors.doctor_addrs,doctors.doc_hospital_clinic_name,doctors.approvedby,doctors.managerlat,doctors.managerlong,doctors.dr_latitude,doctors.dr_longitude,doctors.c_date,doctors.c_time FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_date = '$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='$attendancestatus' AND tbl_work_plan.wp_rep_id ='$wp_rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND doctors.favourite='1'";



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