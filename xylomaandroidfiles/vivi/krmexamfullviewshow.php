<?php
include("../includes/connect_db.php");

$studid = $_REQUEST['studid'];
$exam = $_REQUEST['exam'];
$year= $_REQUEST['year'];
$month= $_REQUEST['month'];


$jjstudview = mysql_query("SELECT * FROM student_profile WHERE stu_id='$studid'");
$jjcount = mysql_num_rows($jjstudview);
if($jjcount > 0)
{
$jjstud_res = mysql_fetch_array($jjstudview);

$jjexam = "SELECT exam_schedule.Exam_date,exam_schedule.Subject_id,exam_schedule.Subject_id,exam_schedule.Portion,exam_schedule.Time,exam_schedule.givendate,exam_schedule.Total_marks,exam_schedule.Duration,staff_profile.Name FROM exam_schedule,staff_profile WHERE exam_schedule.Standard_id='".$jjstud_res['Standard_id']."' AND exam_schedule.Examtype='$exam' AND exam_schedule.year='$year' AND exam_schedule.month='$month' AND staff_profile.s_id = exam_schedule.staff_id ORDER BY exam_schedule.exam_id DESC";


$objQuery = mysql_query($jjexam);
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
?>