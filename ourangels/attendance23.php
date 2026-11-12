<?php

include("../includes/connect_db.php");

$class_type=$_REQUEST['class_type'];
$year=$_REQUEST['year'];
$month=$_REQUEST['month'];


$strSQL = "SELECT * FROM assign_leaves where class_type='$class_type' and month='$month' and year='$year'";

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