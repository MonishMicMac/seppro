<?php

include("connect1.php"); 

$status=$_REQUEST['status'];
$rep_id=$_REQUEST['rep_id'];
$date=date('Y-m-d');


$sa =  mysql_query("SELECT Group_concat(repid) as rep FROM managerjoinworkplans WHERE date='$date' and managerid=$rep_id")or die(mysql_error());
$data = mysql_fetch_array($sa);
$group_rep=$data['rep'];

if($status=='1') {

	$strSQL="SELECT doctors.id,doctors.doctor_addrs,doctors.doc_classification,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,IFNULL((select reportstatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as reportstatus,IFNULL((select attendancestatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as attendancestatus FROM doctors WHERE rep_assign IN (".$group_rep.") AND doctors.id NOT IN (select wp_dc_id from tbl_work_plan where wp_rep_id IN (".$group_rep.") and wp_date='$date' and ((attendancestatus='1' and drunavailable='1') or (attendancestatus='1' and drunavailable='0')))";

} elseif($status=='2') {

	$strSQL="SELECT doctors.id,doctors.doctor_addrs,doctors.doc_classification,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,IFNULL((select reportstatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as reportstatus,IFNULL((select attendancestatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as attendancestatus FROM doctors WHERE rep_assign IN (".$group_rep.") AND doctors.id IN (select wp_dc_id from tbl_work_plan where wp_rep_id IN (".$group_rep.") and wp_date='$date' and attendancestatus='1' and drunavailable='1')";

} elseif($status=='3') {

	$strSQL="SELECT doctors.id,doctors.doctor_addrs,doctors.doc_classification,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,IFNULL((select reportstatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as reportstatus,IFNULL((select attendancestatus from tbl_work_plan where wp_dc_id=doctors.id and wp_date='$date' order by wp_id asc limit 1),'0') as attendancestatus FROM doctors WHERE rep_assign IN (".$group_rep.") AND doctors.id IN (select wp_dc_id from tbl_work_plan where wp_rep_id IN (".$group_rep.") and wp_date='$date' and attendancestatus='1' and drunavailable='0')";

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