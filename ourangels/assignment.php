<?php

include("../includes/connect_db.php");

$assign_id=$_REQUEST['assign_id'];
$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$assignment_date=$_REQUEST['assignment_date'];
$strSQL = "SELECT * FROM assignment where standard_id='$standard_id' and section_id='$section_id' and assignment_date='$assignment_date'";

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