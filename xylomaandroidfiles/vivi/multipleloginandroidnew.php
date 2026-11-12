<?php

include("connectsms.php");
$multiple = "SELECT * FROM student_profile WHERE (Phone_no LIKE '%".$_REQUEST['phone']."%' OR Father_phone_no LIKE '%".$_REQUEST['phone']."%' OR Mother_phone_no LIKE '%".$_REQUEST['phone']."%')";


$objQuery = mysql_query($multiple);
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