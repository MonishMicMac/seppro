<?php
include("connectsms.php");
$strSQL= "SELECT holiday_date,reserved_holiday_title,status FROM calendar WHERE holiday_date LIKE '%".$_REQUEST['dat']."%' ORDER BY holiday_date";
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
	
	
	echo json_encode($resultArray);
?>