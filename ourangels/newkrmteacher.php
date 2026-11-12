<?php

include("connectsms.php");

$phonenumber = $_REQUEST['phonenumber'];




$jjxx = "SELECT * FROM staff_profile WHERE Staff_id= '$phonenumber'";


$objQuery = mysql_query($jjxx);
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