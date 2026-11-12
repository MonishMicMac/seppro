<?php

include("connect23.php"); 

$month=$_REQUEST['month'];
$repid=$_REQUEST['repid'];
$year=$_REQUEST['year'];

$date =$year."-".$month."-"; 












$strSQL = "SELECT tbl_work_plan.reporteddate,tbl_work_plan.jointworkapproval,IFNULL((select rep_name from representative where id=tbl_work_plan.wp_rep_id order by id asc limit 1),'No name') as rep_name,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doctor_addrs,doctors.favourite,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_date LIKE '$date%' AND FIND_IN_SET('$repid', tbl_work_plan.jointworkby) AND doctors.id=tbl_work_plan.wp_dc_id order by tbl_work_plan.wp_date asc";







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