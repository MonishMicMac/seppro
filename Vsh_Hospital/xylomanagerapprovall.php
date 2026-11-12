<?php
include("connect23.php"); 


$wp_rep_id=$_REQUEST['wp_rep_id'];

$strSQL = "SELECT * FROM tbl_work_plan,doctors,representative WHERE FIND_IN_SET('$wp_rep_id', tbl_work_plan.jointworkby) AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.jointworkapproval='0' AND tbl_work_plan.wp_dc_id=doctors.id AND representative.id=tbl_work_plan.wp_rep_id ORDER BY doctors.doctor_name ASC";
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