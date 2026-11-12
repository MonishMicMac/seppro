<?php

include("connect2.php"); 



 

$rep_id=$_REQUEST['rep_id'];
$date=substr($_REQUEST['date'],0,-2);



 $strSQL = "SELECT  tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.prescriber,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doc_pincode FROM doctors,tbl_work_plan WHERE tbl_work_plan.wp_rep_id= '$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.reporteddate LIKE '$date%'  GROUP BY wp_dc_id";

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