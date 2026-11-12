<?php
include("connect2.php"); 




$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];
$rep_id=$_REQUEST['rep_id'];




$strSQL = "SELECT tbl_work_plan.wp_id,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,tbl_work_plan.drunavailablereason,tbl_work_plan.leaveapprovedbymanager,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doctor_addrs FROM tbl_work_plan,doctors WHERE tbl_work_plan.jointworkby='$wp_rep_id' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id'";



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