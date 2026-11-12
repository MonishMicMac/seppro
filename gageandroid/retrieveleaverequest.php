<?php

include("../includes/connect_db.php");

$teacherid=$_REQUEST['teacherid'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];



//$teacherid='GP520B1';
//$month='Feb';
//$year='2015';



$strSQL = "SELECT * FROM  leaverequest where teacherid='$teacherid' and month='$month' and year='$year'";

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