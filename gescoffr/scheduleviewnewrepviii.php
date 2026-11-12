<?php

include("connect1.php"); 
date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');
$rep_id=$_REQUEST['rep_id'];





//echo $strSQL = "SELECT tbl_work_plan.wp_dc_id,doctors.id,doctors.doc_classification,doctors.specialistid,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$cdate'  and doctors.rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id group by doctors.id";
echo '[';
$doclist = mysql_query("SELECT doctors.id,doctors.doc_classification,doctors.specialistid,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude FROM doctors where doctors.rep_id='$rep_id'")or die(mysql_error());
while($doclist_res=mysql_fetch_array($doclist))
{

	$status = mysql_query("SELECT * FROM tbl_work_plan where wp_dc_id='".$doclist_res['id']."' AND wp_date='".date('Y-m-d')."' AND attendancestatus='1'")or die(mysql_error());
	if(mysql_num_rows($status)>0)
	{
		$stat="1";
	}
	else
	{
		$stat="0";
	}
   //$status_res=mysql_fetch_array($status);
  $str.='{"id":"'.$doclist_res['id'].'","doc_classification:"'.$doclist_res['doc_classification'].'","specialistid":"'.$doclist_res['specialistid'].'","doc_contact_no":"'.$doclist_res['doc_contact_no'].'","doctor_name":"'.$doclist_res['doctor_name'].'","doc_pincode:"'.$doclist_res['doc_pincode'].'","doc_qualification":"'.$doclist_res['doc_qualification'].'","doc_specilist_id":"'.$doclist_res['doc_specilist_id'].'","favourite":"'.$doclist_res['favourite'].'","attendancestatus:"'.$stat.'","doc_hospital_clinic_name":"'.$doclist_res['doc_hospital_clinic_name'].'","dr_latitude:"'.$doclist_res['dr_latitude'].'","dr_longitude":"'.$doclist_res['dr_longitude'].'"},';
}

echo substr($str,0,-1).']';
/*$objQuery = mysql_query($strSQL);
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
*/	
	
	
	
	
	
	
	
?>