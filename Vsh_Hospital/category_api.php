<?php
include("connect23.php"); 

$user_id=$_REQUEST['user_id'];







$strSQL = "SELECT * FROM category ORDER BY id ASC";



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
	

	// print_r($resultArray);
	// exit();
	mysql_close($con);
	
	echo json_encode($resultArray);
?>