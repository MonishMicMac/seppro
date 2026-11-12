<?php

include("connect23.php"); 

$repid=$_REQUEST['repid'];;

$ladate=$_REQUEST['ladate'];;

$strSQLs = "SELECT * FROM targetamount where repid='$repid'";


$objQuerys = mysql_query($strSQLs);
	$intNumField = mysql_num_fields($objQuerys);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuerys))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuerys,$i)] = $obResult[$i];
		}


	    $objQuery = mysql_query($strSQL);
	    $obResult = mysql_fetch_array($objQuery);
	

		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


?>