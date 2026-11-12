<?php

include("connect2.php"); 
 

$date=$_REQUEST['date'];
$repid=$_REQUEST['repid'];




$strSQL = "SELECT * 
FROM allowancecal
WHERE billdate=  '$date' AND repid='$repid'";




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