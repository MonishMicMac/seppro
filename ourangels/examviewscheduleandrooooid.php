<?php
include("../includes/connect_db.php");

$jjstu = mysql_query("SELECT * FROM student_profile WHERE stu_id='".$_REQUEST['studid']."'")or die(mysql_error());
$jjstu_count = mysql_num_rows($jjstu);
if($jjstu_count > 0)
{
$jjstu_res = mysql_fetch_array($jjstu);


$jjexam= "SELECT * FROM exam_schedule,mst_examname,mst_subexamname WHERE std_id='".$jjstu_res['Standard_id']."' AND sec_id='".$jjstu_res['Section_id']."' AND exam_schedule.exam_type=mst_examname.en_id AND exam_schedule.exam_category=mst_subexamname.senid ORDER BY exam_id DESC";


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