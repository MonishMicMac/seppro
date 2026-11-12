<?php

include("connect2.php"); 

$pid=$_REQUEST['pid'];







$strSQL = "SELECT representative.mobile FROM assigningreptomanager,representative WHERE  assigningreptomanager.repid='$pid' AND representative.id=assigningreptomanager.managerid";





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