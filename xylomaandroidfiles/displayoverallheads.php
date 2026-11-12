<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
	mysql_select_db("xyloma");







 	$strSQL = "SELECT * FROM representative WHERE rep_id !=0";

$objQuery = mysql_query($strSQL);
echo mysql_error();
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
	
	//mysql_close($con);
	
	echo json_encode($resultArray);
?>