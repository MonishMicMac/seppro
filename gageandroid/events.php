<?php

include("../includes/connect_db.php");

$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$meet_id=$_REQUEST['meet_id'];



$strSQL = "SELECT * FROM  management_add_meeting where standard_id='$standard_id' and section_id='$section_id' and meet_id>'$meet_id'";

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