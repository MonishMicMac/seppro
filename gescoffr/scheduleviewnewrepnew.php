<?php

include("connect1.php"); 
date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');
$rep_id=$_REQUEST['rep_id'];
$wpdate=$_REQUEST['wpdate'];




$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_classification,doctors.specialistid,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$wpdate' and   tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";





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
	
	
	
	
	
	
	
	
?>