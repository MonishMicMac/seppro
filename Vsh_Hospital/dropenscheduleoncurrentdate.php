<?php

include("connect23.php"); 

$pid=$_REQUEST['pid'];


$date=$_REQUEST['date'];

$managerid=$_REQUEST['managerid'];




$strSQL = "SELECT id,doc_contact_no,doctor_name,doc_pincode,doc_qualification,doc_specilist_id,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name,IFNULL((select drid from dropenforschedule where drid=doctors.id AND managerid='$managerid' AND dateopen='$date'),'0') as status FROM doctors WHERE rep_assign='$pid'";



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