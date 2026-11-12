<?php
include("connect1.php"); 

$pid=$_REQUEST['pid'];







$strSQL = "SELECT id,doc_contact_no,doctor_addrs,doctor_name,doc_pincode,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors WHERE rep_assign='$pid'";



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