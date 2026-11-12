<?php

include("connect1.php"); 
date_default_timezone_set("Asia/Kolkata"); 
$status=$_REQUEST['status'];
$rep_id=$_REQUEST['rep_id'];
$date=date('Y-m-d');

if($status=='1') {

	$strSQL="SELECT doctors.id,doctors.specialistid,doctors.doc_classification,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_addrs,IFNULL((select reportstatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as reportstatus,IFNULL((select attendancestatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as attendancestatus FROM doctors WHERE rep_assign='$rep_id' AND doctors.id NOT IN (select wp_dc_id from tbl_work_plan where wp_rep_id='$rep_id' and wp_date='$date' and ((attendancestatus='1' and drunavailable='1') or (attendancestatus='1' and drunavailable='0')))";

} elseif($status=='2') {

	$strSQL="SELECT doctors.id,doctors.specialistid,doctors.doc_classification,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_addrs,IFNULL((select reportstatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as reportstatus,IFNULL((select attendancestatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as attendancestatus FROM doctors WHERE rep_assign='$rep_id' AND doctors.id IN (select wp_dc_id from tbl_work_plan where wp_rep_id='$rep_id' and wp_date='$date' and attendancestatus='1' and drunavailable='1')";

} elseif($status=='3') {

	$strSQL="SELECT doctors.id,doctors.specialistid,doctors.doc_classification,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_addrs,IFNULL((select reportstatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as reportstatus,IFNULL((select attendancestatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as attendancestatus FROM doctors WHERE rep_assign='$rep_id' AND doctors.id IN (select wp_dc_id from tbl_work_plan where wp_rep_id='$rep_id' and wp_date='$date' and attendancestatus='1' and drunavailable='0')";

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
	
	mysql_close($con);
	
	
	echo json_encode($resultArray);
	
	
	
	
	
	
	
	
?>