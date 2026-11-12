<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];
$status=$_REQUEST['status'];

global $missedcount,$notvisitedcount;

$totalvistedwithoutrepeatedcount='0';

$full_date=date("Y-m-d",strtotime($date));



if($status==1){

$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,doctors.drorchemist,doctors.doctor_addrs FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";

}

if($status==2){

$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,doctors.drorchemist,doctors.doctor_addrs FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='0'";


}

if($status==3){

$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,doctors.drorchemist,doctors.doctor_addrs FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'";

}



// echo "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,tbl_work_plan.drorchemist,tbl_work_plan.doctor_addrs FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";



/*$strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,doctors.drorchemist,doctors.doctor_addrs FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$full_date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";
*/



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

	$sql = mysql_query("SELECT wp_date FROM `tbl_work_plan` WHERE wp_dc_id='".$obResult['wp_dc_id']."'  AND wp_id=(select max(wp_id) from tbl_work_plan where attendancestatus='1'  AND wp_dc_id='".$obResult['wp_dc_id']."')");
	$row=mysql_fetch_array($sql);

	if($row['wp_date']!='')
	{
		$arrCol['lastdate'] = $row['wp_date'];
	}
	else
	{
		$arrCol['lastdate'] ='Nill';
	}

	

	array_push($resultArray,$arrCol);
}

mysql_close($con);


echo json_encode($resultArray);	







?>