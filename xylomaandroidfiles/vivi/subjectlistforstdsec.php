<?php

include("connectsms.php");

$strSQL= "SELECT (select sub_name from mst_sub where sub_id=time_table.subject) as subject,subject as SID FROM time_table WHERE section_id='".$_REQUEST['sec']."' AND standard_id='".$_REQUEST['std']."' GROUP BY time_table.subject ";

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