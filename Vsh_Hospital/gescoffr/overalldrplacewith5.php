<?php

include("connect1.php");

$pid=$_REQUEST['pid'];



$strSQL = "SELECT id,doc_contact_no,doctor_name,doc_pincode,com_name,doc_classification,doc_qualification,doc_specilist_id,specialistid,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite FROM doctors WHERE rep_assign='$pid'";



$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		if($obResult['com_name']!='')
		{
		$jj5 = mysql_query("SELECT GROUP_CONCAT(com_name) AS comptor FROM comepetitors WHERE c_id IN (".$obResult['com_name'].") ")or die(mysql_error());
$jj_res5 = mysql_fetch_array($jj5);
$arrCol['compitator'] = $jj_res5['comptor'];
}
else
{
	$arrCol['compitator'] = "No competitor";
}
//echo "SELECT *  FROM tbl_work_plan WHERE wp_date like '%".date('Y-m-')."%' AND wp_rep_id='$pid' AND attendancestatus='1' AND wp_dc_id='".$obResult['id']."'";

$jj10 = mysql_query("SELECT *  FROM tbl_work_plan WHERE wp_date like '%".date('Y-m-')."%' AND wp_rep_id='$pid' AND attendancestatus='1' AND wp_dc_id='".$obResult['id']."'")or die(mysql_error());
$jj_res10 = mysql_num_rows($jj10);
if($jj_res10==0)
{
	$arrCol['status'] = "0";
}
else
{
	$arrCol['status'] = "1";
}

		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>