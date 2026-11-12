<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];


global $missedcount,$notvisitedcount;

$totalvistedwithoutrepeatedcount='0';

$full_date=date("Y-m-d",strtotime($date));










$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.dob,doctors.drorchemist,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";




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
		$arrCol['missedvalue'] = "0";
		$arrCol['visitedvalue'] = "0";
		$arrCol['notvisitedvalue'] = "0";
		$arrCol['extra'] = "0";
		$arrCol['count'] = "1";
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	if(strlen(json_encode($resultArray))<=2)
	{
	
	echo '[{"missedvalue":"'.$missedcount.'","visitedvalue":"'.$totalvistedwithoutrepeatedcount.'","notvisitedvalue":"'.$notvisited.'"'.',"extra":"'.$extra.'"'.',"count":"0"'.'}]';
	}
	else
	{
	echo json_encode($resultArray);
	}
	
	
	
	
	
	
	
	
?>