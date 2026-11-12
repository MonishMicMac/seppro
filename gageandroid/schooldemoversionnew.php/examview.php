<?php
include("../../includes/connect_db.php");

 $jjassign = "SELECT  student_profile.stu_id,student_profile.student_id,student_profile.Standard_id,student_profile.Section_id,exam_schedule.exam_date,exam_schedule.subject_name,mst_examname.exam_name,mst_subexamname.subexamname FROM student_profile,exam_schedule,mst_examname,mst_subexamname WHERE student_profile.stu_id='".$_REQUEST['stuid']."' AND exam_schedule.exam_date='".date('Y-m-d',strtotime($_REQUEST['exdate']))."'  AND student_profile.Standard_id=exam_schedule.std_id AND student_profile.Section_id =exam_schedule.sec_id AND exam_schedule.exam_type=mst_examname.en_id AND exam_schedule.exam_category=mst_subexamname.senid ORDER BY exam_schedule.exam_id DESC";

$objQuery = mysql_query($jjassign);
//echo $row= mysql_num_rows($objQuery);die();
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