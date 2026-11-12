<?php

include("connect23.php"); 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];






echo '[';

$strSQL = "SELECT tbl_work_plan.mtp,tbl_work_plan.wp_id,tbl_work_plan.attendancestatus,tbl_work_plan.reportstatus,tbl_work_plan.wp_dc_id,tbl_work_plan.c_time,doctors.dr_latitude,doctors.dr_longitude,doctors.doctor_name,doctors.doc_hospital_clinic_name,doctors.doc_pincode,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_qualification,doctors.favourite FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_rep_id='$repid' AND doctors.id=tbl_work_plan.wp_dc_id";

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
                $arrCol['count'] = "0";
		array_push($resultArray,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray))<='2')
{
}
else
{
 

echo $rest = substr(json_encode($resultArray), 1, -1);
}







$strSQL1 = "SELECT unapprovedtbl_work_plan.wp_id,unapprovedtbl_work_plan.attendancestatus,unapprovedtbl_work_plan.reportstatus,unapprovedtbl_work_plan.wp_dc_id,unapprovedtbl_work_plan.c_time,unapproveddoctors.dr_latitude,unapproveddoctors.dr_longitude,unapproveddoctors.doctor_name,unapproveddoctors.doc_hospital_clinic_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_contact_no,unapproveddoctors.doctor_addrs,unapproveddoctors.doc_specilist_id,unapproveddoctors.doc_qualification,unapproveddoctors.favourite FROM unapprovedtbl_work_plan,unapproveddoctors WHERE unapprovedtbl_work_plan.wp_dc='D' AND unapprovedtbl_work_plan.wp_date='$date' AND unapprovedtbl_work_plan.wp_rep_id='$repid' AND unapproveddoctors.id=unapprovedtbl_work_plan.wp_dc_id";

$objQuery1 = mysql_query($strSQL1);
	$intNumField = mysql_num_fields($objQuery1);
	$resultArray1 = array();
	while($obResult1 = mysql_fetch_array($objQuery1))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		 $arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
		}
                 $arrCol['count'] = "1";

		array_push($resultArray1,$arrCol);
	}
	
		
	

if(strlen(json_encode($resultArray1))<='2')
{
echo ']';
}
else
{
 if(strlen(json_encode($resultArray))<='2')
{
}
else
{
echo ',';
}

echo $rest = substr(json_encode($resultArray1), 1, -1).']';
}


?>