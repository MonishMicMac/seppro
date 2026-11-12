<?php
include("connectsms.php");

$term_name=$_REQUEST['term_name'];
$exam_name=$_REQUEST['exam_name'];


$strSQL= "SELECT markentry_id,exam_schedule_subject,(select mark_obtained from tbl_mark_entry where exam_id=tbl_exam_schedule.exam_schedule_id) marks FROM tbl_exam_schedule WHERE exam_schedule_term='$term_name' and exam_schedule_exam_name='$exam_name'";

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