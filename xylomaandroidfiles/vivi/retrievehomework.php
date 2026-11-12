<?php

include("../includes/connect_db.php");

$staff_id=$_REQUEST['staff_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$assignment_date=$_REQUEST['assignment_date'];





$strSQL = "SELECT * FROM  assignment where staff_id='$staff_id' and standard_id='$standard_id' and section_id='$section_id' and assignment_date='$assignment_date'";

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