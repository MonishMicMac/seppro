<?php
include("../includes/connect_db.php");
$Exam_date=$_REQUEST['Exam_date'];
$Standard_id=$_REQUEST['Standard_id'];
$Section_id=$_REQUEST['Section_id'];



$strSQL = "SELECT * FROM  exam_schedule where Exam_date='$Exam_date' and Standard_id='$Standard_id' and Section_id='$Section_id' ";

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