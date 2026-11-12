<?php
include("connectsms.php");

$eventview = "SELECT holiday_date,holiday_year,holiday_month,holiday_day,reserved_holiday_title,status,event_image,event_descp FROM calendar ORDER BY holiday_date LIMIT 40 ";

$objQuery = mysql_query($eventview);
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