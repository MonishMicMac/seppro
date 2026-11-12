<?php

include("../../includes/connect_db.php");

$edate = $_REQUEST['edate'];

 $strSQL = "SELECT exam_date,exam_name FROM exam_schedule,mst_examname WHERE exam_date LIKE '$edate%' AND exam_schedule.exam_type=mst_examname.en_id";

$objQuery = mysql_query($strSQL);
$row = mysql_num_rows($objQuery);
if($row > 0)
{
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
}