<?php

include("connectsms.php");




$staffid=$_REQUEST['staffid'];



 $strSQL= "SELECT day,(select sub_name from mst_sub where sub_id=time_table.subject) as subject,hours FROM time_table WHERE staff_id='$staffid'";

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