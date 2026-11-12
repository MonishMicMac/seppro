<?php
include("connect1.php");


// $jj_res = mysql_fetch_array($jj);
$rep_id = $_REQUEST['rep_id'];


$strSQL = "SELECT * FROM  doctors WHERE rep_id='$rep_id' AND beatid IN (".$_REQUEST['beatid'].")";
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