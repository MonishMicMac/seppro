<?php

include("../../includes/connect_db.php");

 $strSQL = "SELECT * FROM student_profile WHERE Phone_no='".$_REQUEST['mobile']."' || Father_phone_no='".$_REQUEST['mobile']."' || Mother_phone_no='".$_REQUEST['mobile']."' ORDER BY stu_id ASC LIMIT 1";

$objQuery = mysql_query($strSQL);
$row = mysql_num_rows($objQuery);
if($row > 0)
{
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