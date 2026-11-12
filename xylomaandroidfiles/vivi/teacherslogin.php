<?php

include("../includes/connect_db.php");
$Name= $_POST['Name'];
$Phone_no= $_POST['Phone_no'];



$strSQL = "SELECT * FROM  staff_profile where Name= '".$Name."' AND Phone_no= '".$Phone_no. "'";

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