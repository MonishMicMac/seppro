<?php

include("connect2.php"); 

$pid=$_REQUEST['pid'];



date_default_timezone_set("Asia/Kolkata"); 

$cdate = date('Y-m-d');



$strSQL = "SELECT IFNULL((select GROUP_CONCAT(intimestatus,outtimestatus) from sampletimeinandout where clientid=doctors.id AND scheduledate='$cdate' order by id asc limit 1),'00') as intime,id,doctor_name,doc_specilist_id,doc_contact_no,doctor_addrs,doc_pincode,rep_id FROM doctors WHERE rep_id='$pid'";



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