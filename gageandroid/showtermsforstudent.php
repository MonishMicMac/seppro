<?php
include("connectsms.php");


$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];


$strSQL= "SELECT * FROM tbl_exam_schedule WHERE exam_schedule_standard='$standard_id' and exam_schedule_section='$section_id'";

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