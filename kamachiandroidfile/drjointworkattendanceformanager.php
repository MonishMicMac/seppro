<?php


include("connect2.php"); 
$wp_rep_id=$_REQUEST['wp_rep_id'];
$reporteddate=$_REQUEST['reporteddate'];



$strSQL = "SELECT * FROM tbl_work_plan,doctors,representative WHERE tbl_work_plan.attendancestatus='1' AND tbl_work_plan.jointworkby='$wp_rep_id' AND tbl_work_plan.reporteddate='$reporteddate' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_dc='D' AND representative.id=tbl_work_plan.wp_rep_id";
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