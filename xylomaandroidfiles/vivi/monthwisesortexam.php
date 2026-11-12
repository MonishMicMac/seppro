<?php

include("../includes/connect_db.php");



$Standard_id= $_REQUEST['Standard_id'];
$Section_id= $_REQUEST['Section_id'];

$strSQL = "SELECT distinct month,year,Standard_id,Section_id FROM exam_schedule where Standard_id='$Standard_id' and Section_id='$Section_id'";

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