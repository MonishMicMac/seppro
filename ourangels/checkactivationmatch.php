<?php

include("../includes/connect_db.php");
$student_id=$_REQUEST['student_id'];
$activationcode=$_REQUEST['activationcode'];

$strSQL = "SELECT * FROM  student_profile where student_id='$student_id' and activationcode='$activationcode'";

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