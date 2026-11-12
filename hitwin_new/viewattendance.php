<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];


 date_default_timezone_set("Asia/Kolkata");
    $date =date('Y-'); //Returns IST 

$strSQL = "SELECT date,lattt,longg,expenses,area FROM attendancetable WHERE repid='$pid' AND date LIKE '$date%' ";




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