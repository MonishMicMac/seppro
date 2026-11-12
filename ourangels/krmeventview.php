<?php
include("../includes/connect_db.php");

$eventview = "SELECT holiday_date,reserved_holiday_title,event_image,event_descp FROM calendar WHERE holiday_date BETWEEN CURDATE() AND CURDATE()+6 AND status ='1'";

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