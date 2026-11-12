<?php
include("../includes/connect_db.php");

$student_id=$_REQUEST['student_id'];
$Exam_id=$_REQUEST['Exam_id'];
$strSQL = "SELECT Subject_id,grade_type FROM  progress_report where student_id='$student_id' and Exam_id='$Exam_id'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		if($i==0)
		{
		$Subject_id=$obResult[$i];
		if($Subject_id!='')
		{
		$subject_name='';
		$explode_Subject_id=explode(',',$Subject_id);
		foreach($explode_Subject_id as $value)
		{
		$a=mysql_query("select Subject_name from subject where sub_id='$value'");
		$row_a=mysql_fetch_array($a);
		$subject_name.=$row_a['Subject_name'].',';
		}
		$org_subject_name=rtrim($subject_name, ",");
		$arrCol[mysql_field_name($objQuery,$i)] = $org_subject_name;
		}
		else
		{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
		}
		else
		{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
			
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	echo json_encode($resultArray);

?>