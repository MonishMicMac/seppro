<?php
include("../includes/connect_db.php"); 

$stuid = $_REQUEST['studid'];

$jjstudent = "SELECT * FROM student_profile WHERE Phone_no IN (SELECT Phone_no FROM student_profile WHERE student_id='$stuid')";
  
$objQuery = mysql_query($jjstudent);
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