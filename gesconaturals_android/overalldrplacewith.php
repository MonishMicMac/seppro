<?php

include("connect1.php");

$pid=$_REQUEST['pid'];




// echo "SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_pin_id,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,concat((select name from beadname where id=doctors.beatid),,,(select doctor_name from doctors1 where id=doctors.stockist_id)) AS beatname FROM doctors WHERE rep_assign='$pid'";


$strSQL = "SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_pin_id,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,CONCAT((select name from beadname where id=doctors.beatid),'(',(select doctor_name from doctors1 where id=doctors.stockist_id),')') AS beat_dis FROM doctors WHERE rep_assign='$pid'";



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


 //$sqls1=mysql_query("SELECT area_name  FROM pincode_list WHERE pin_id =".$arrCol['doc_pin_id']."");
		//$rows1=mysql_fetch_array($sqls1);
		$arrCol['area_name']='no area name';


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>