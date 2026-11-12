<?php

include("../includes/connect_db.php");



$standard_id= $_REQUEST['standard_id'];
$section_id= $_REQUEST['section_id'];

//distinct assignment_date,month,year,standard_id,section_id

$strSQL = "SELECT assignment_date FROM assignment where standard_id='$standard_id' and section_id='$section_id' GROUP BY assignment_date";

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