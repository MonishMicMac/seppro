<?php

include("connect1.php");

$pid=$_REQUEST['pid'];







$strSQL = "SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_pin_id,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,approveddr FROM doctors WHERE rep_assign='$pid'";



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



		$arrCol['area_name']='no area name';


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>