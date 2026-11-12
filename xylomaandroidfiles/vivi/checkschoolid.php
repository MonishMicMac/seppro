<?php

include("connect5.php");
$lasid=$_REQUEST['lasid'];




  $strSQL = "SELECT school_id,school_name,school_logo,school_admin from ymst_school where school_id>'$lasid' ORDER BY school_id ASC";



$objQuery = mysql_query($strSQL) or die(mysql_error());
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