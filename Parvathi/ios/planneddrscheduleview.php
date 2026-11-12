<?php

include("connect1.php");


$repid=$_REQUEST['repid'];
date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');

$erql = mysql_query("SELECT rep_id FROM representative where id='$repid'");
$row=mysql_fetch_array($erql);
$reid=$row['rep_id'];




 $strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.drorchemist,doctors.doc_pincode,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,doctors.favourite FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id";

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
	echo '{"title":{"episodes":'.json_encode($resultArray).',"year": 2016} }';
	
//	echo json_encode($resultArray);

?>