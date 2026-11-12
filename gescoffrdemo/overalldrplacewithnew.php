<?php

include("connect1.php");

$pid=$_REQUEST['pid'];
$date=date('Y-m-d');

$sa =  mysql_query("SELECT Group_concat(repid) as rep FROM managerjoinworkplans WHERE date='$date' and managerid=$pid")or die(mysql_error());
$data = mysql_fetch_array($sa);
$group_rep=$data['rep'];

$strSQL = "SELECT id,doc_contact_no,doctor_name,doc_pincode,doc_classification,doc_qualification,doc_specilist_id,specialistid,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors WHERE rep_assign IN (".$group_rep.")";



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