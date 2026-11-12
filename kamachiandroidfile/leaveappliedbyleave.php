<?php
include("connect2.php"); 
$doctorid=$_REQUEST['doctorid'];


$strSQL = "SELECT DISTINCT representative.id,representative.rep_name,repgivenasleave.time
FROM repgivenasleave,representative
WHERE repgivenasleave.date='$doctorid' AND repgivenasleave.repid=representative.id GROUP BY representative.id";





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