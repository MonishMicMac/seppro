<?php
include("../includes/connect_db.php");

$studid = $_REQUEST['studid'];

$jjstudview = mysql_query("SELECT * FROM student_profile WHERE stu_id='$studid'");
$jjcount = mysql_num_rows($jjstudview);
if($jjcount > 0)
{
$jjstud_res = mysql_fetch_array($jjstudview);

 //echo $jjexam = "SELECT Examtype FROM exam_schedule WHERE Standard_id='".$jjstud_res['Standard_id']."' AND Examtype !=''   GROUP BY Examtype ORDER BY exam_schedule.exam_id DESC";

 $jjexam = "SELECT exam_name AS Examtype,en_id FROM exam_schedule,mst_examname WHERE std_id='".$jjstud_res['Standard_id']."' AND exam_type!='' AND mst_examname.en_id=exam_schedule.exam_type   GROUP BY exam_type ORDER BY exam_schedule.exam_id DESC";

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