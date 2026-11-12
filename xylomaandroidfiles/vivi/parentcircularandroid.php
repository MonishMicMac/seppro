<?php
include("../includes/connect_db.php");

$studid = $_REQUEST['studid'];


$jjcir=mysql_query("SELECT stu_id FROM student_profile WHERE student_id='$studid'")or die(mysql_error());
$jjcount = mysql_num_rows($jjcir);
if($jjcount > 0)
{
   while($jjcir_res = mysql_fetch_array($jjcir))
    {
    $studentid = $jjcir_res['stu_id'];
   

    $jjparentcir = "SELECT commonmessageparents.parentmessage,commonmessageparents.teacherimage,commonmessageparents.date,commonmessageparents.time,staff_profile.Name,staff_profile.Last_name,student_profile.stu_id FROM commonmessageparents,staff_profile,student_profile WHERE commonmessageparents.parentid ='$studentid' AND staff_profile.s_id = commonmessageparents.teachername AND student_profile.stu_id=commonmessageparents.parentid ORDER BY id DESC";



  
     
$objQuery = mysql_query($jjparentcir);
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
}
else
{
echo "NO records found";
}
?>