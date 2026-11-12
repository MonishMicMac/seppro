<?php

include("connect1.php");
$pid=$_REQUEST['rep_id'];


$date=$_REQUEST['date'];






 $strSQL = "SELECT doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$pid' AND tbl_work_plan.wp_dc_id=doctors.id";



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