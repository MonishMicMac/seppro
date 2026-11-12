<?php

include("connect2.php"); 

$repid=$_REQUEST['repid'];
$c_date=$_REQUEST['c_date'];




$strSQL = "SELECT doctors.id,doctors.doctor_name,doctors.rep_id,doctors.doc_specilist_id,doctors.doc_pincode,doctors.doc_contact_no,doctors.doctor_addrs,sampletimeinandout.feedback,sampletimeinandout.latitude_in,sampletimeinandout.longitude_in,sampletimeinandout.outfeedback,sampletimeinandout.latitude_out,sampletimeinandout.longitude_out,sampletimeinandout.intime,sampletimeinandout.outtime,sampletimeinandout.c_date,sampletimeinandout.intime,sampletimeinandout.outtime,sampletimeinandout.timediff FROM sampletimeinandout,doctors where doctors.id=sampletimeinandout.clientid and sampletimeinandout.repid='$repid' and sampletimeinandout.c_date='$c_date'";



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