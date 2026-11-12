<?php

include("connect2.php"); 


$reporteddate=$_REQUEST['reporteddate'];
$reportedtime=$_REQUEST['reportedtime'];
$str = substr("$reportedtime",0,2);
$str1 = substr("$reportedtime",2);

$wp_rep_id=$_REQUEST['wp_rep_id'];



$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.wp_rep_id='$wp_rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND reportedtime LIKE '%$str1' AND reportedtime LIKE '$str%'";



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