<?php

include("connect1.php");

$pid=$_REQUEST['pid'];







$strSQL = "SELECT doc_pin_id,doc_pincode FROM doctors WHERE rep_assign='$pid' AND doc_pin_id!='0' GROUP BY doc_pin_id";



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
$arrCol['area_name']=$arrCol['doc_pincode'];

		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>