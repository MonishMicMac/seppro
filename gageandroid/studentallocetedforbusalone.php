<?php

include("../includes/connect_db.php");

$busid=$_REQUEST['busid'];
$shift=$_REQUEST['shift'];

$strSQL = "SELECT student_profile.pd,student_profile.stu_id,student_profile.Name,student_profile.standard_name,student_profile.section_name FROM  studentallocatedtobus,student_profile where studentallocatedtobus.busid='$busid' and studentallocatedtobus.shift='$shift' AND studentallocatedtobus.studentid=student_profile.stu_id";

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