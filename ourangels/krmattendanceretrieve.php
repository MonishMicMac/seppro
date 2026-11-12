<?php

include("../includes/connect_db.php");

$student_id=$_REQUEST['student_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];


$strSQL = "SELECT * FROM  student_attendance where student_id='$student_id' and month='$month' and year='$year' AND c_date >= '2016-03-01'";

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