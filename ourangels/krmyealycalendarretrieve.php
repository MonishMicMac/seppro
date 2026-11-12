<?php

include("../includes/connect_db.php");


$holiday_month=$_REQUEST['holiday_month'];
$holiday_year=$_REQUEST['holiday_year'];


$strSQL = "SELECT * FROM  calendar where holiday_month='$holiday_month' and holiday_year='$holiday_year'";

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