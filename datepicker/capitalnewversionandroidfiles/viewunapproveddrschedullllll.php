<?php

include("connect23.php"); 


$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];



$strSQL = "SELECT unapprovedtbl_work_plan.wp_dc_id,unapproveddoctors.id,unapproveddoctors.doc_contact_no,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_qualification,unapproveddoctors.doc_specilist_id,unapproveddoctors.favourite,unapprovedtbl_work_plan.wp_id,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapprovedtbl_work_plan.reportstatus,unapprovedtbl_work_plan.attendancestatus FROM unapproveddoctors,unapprovedtbl_work_plan where unapprovedtbl_work_plan.wp_date='$date' AND unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.wp_rep_id='$rep_id' AND unapprovedtbl_work_plan.wp_dc_id=unapproveddoctors.id";


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