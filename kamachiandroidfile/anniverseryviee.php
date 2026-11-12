<?php

include("connect2.php");

$pid=$_REQUEST['pid'];

$strSQL="SELECT * FROM doctors WHERE rep_assign='$pid' AND  anniversary LIKE '".date('%-m-d')."'";
$objQuery = mysql_query($strSQL) or die(mysql_error());
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