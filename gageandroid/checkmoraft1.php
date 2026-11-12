<?php

include("../includes/connect_db.php");

$standardid= $_POST['standardid'];
$sectionid= $_POST['sectionid'];

$day= $_POST['day'];
$month= $_POST['month'];

$year= $_POST['year'];
$afternoon= $_POST['afternoon'];



$strSQL = "SELECT * FROM  student_attendance where standardid= '".$standardid."' AND sectionid= '".$sectionid."' AND day= '".$day."' AND month= '".$month."' AND year= '".$year."' AND afternoon= '".$afternoon."'";

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