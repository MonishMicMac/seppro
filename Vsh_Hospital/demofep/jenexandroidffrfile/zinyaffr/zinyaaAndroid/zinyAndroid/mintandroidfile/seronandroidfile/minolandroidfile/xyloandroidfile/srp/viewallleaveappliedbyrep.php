<?php
include("connect2.php"); 

 

$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];


$strSQL = "SELECT * 
FROM repgivenasleave
WHERE repid='$repid' AND leaveapplieddate='$leaveapplieddate' AND expenses='leave'";





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