<?php

include("../includes/connect_db.php");
$busno=$_REQUEST['busno'];
$shift=$_REQUEST['shift'];
$pd=$_REQUEST['pd'];

$strSQL = "SELECT areaname,id,busno,shift,lat,lon,pd FROM  stopofbus where busno='$busno' and shift='$shift' GROUP BY areaname";

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