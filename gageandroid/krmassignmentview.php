<?php
include("connectsms.php");
error_reporting(E_ALL);
$studid = $_REQUEST['stuid'];

$jjassign = "SELECT student_profile.student_id,student_profile.Standard_id,student_profile.Section_id,staff_profile.s_id,staff_profile.Name,assignment.staff_id,assignment.assignment_date,assignment.subject,assignment.description,assignment.deadline_date,assignment.status FROM student_profile,staff_profile,assignment WHERE student_profile.stu_id='$studid' AND student_profile.Standard_id=assignment.standard_id AND student_profile.Section_id =assignment.section_id AND staff_profile.s_id = assignment.staff_id AND assignment.status='0' ORDER BY assignment.assign_id DESC LIMIT 200";

//,assignment.standard_id,assignment.section_id
/*$jjchk = mysql_query($jjassign)or die(mysql_error());
$jjassigncount = mysql_num_rows($jjassign);

if($jjassigncount > 0)
{*/
    

$objQuery = mysql_query($jjassign);
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
/*}
else
{
 echo "No records found";
}*/
?>