<?php

include("connect2.php"); 



 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];
date_default_timezone_set("Asia/Kolkata");
$event_date=date('Y-m-d');
$c_time=date("h:i:s A");
$dateOneMonthAdded = strtotime(date("Y-m-d", strtotime($event_date)) . " -7 days");
$end_date=date("Y-m-d",$dateOneMonthAdded);


 $strSQL = "SELECT  * FROM doctors WHERE rep_id= '$rep_id' AND c_date BETWEEN '$end_date' AND '$event_date'  ORDER BY id";

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