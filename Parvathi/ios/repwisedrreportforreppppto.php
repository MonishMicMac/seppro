<?php
include("connect1.php");
$wp_rep_id=$_REQUEST['wp_rep_id'];

date_default_timezone_set("Asia/Kolkata");
$reporteddate = date('Y-m-d');
$jj = mysql_query("SELECT * FROM representative  WHERE id='$wp_rep_id'")or die(mysql_error());

$jj_res = mysql_fetch_array($jj);
$rep_id = $jj_res['rep_id'];



$strSQL = "SELECT tbl_work_plan.wp_id,tbl_work_plan.drunavailable,tbl_work_plan.drunavailablereason,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,doctors.doctor_name,doctors.doc_pincode,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.drorchemist,doctors.dr_longitude,doctors.doc_contact_no,doctors.doc_specilist_id,doctors.doc_qualification,doctors.doctor_addrs,tbl_work_plan.jointworkby FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$wp_rep_id' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc_id=doctors.id ORDER BY tbl_work_plan.reportedtime";

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


?>