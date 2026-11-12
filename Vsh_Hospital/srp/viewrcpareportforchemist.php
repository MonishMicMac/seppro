<?php
include("connect2.php"); 



 

$wp_id=$_REQUEST['wp_id'];
$dc_id=$_REQUEST['dc_id'];




$strSQL = "SELECT * FROM tbl_rcpa WHERE wp_id='$wp_id' AND dc_id='$dc_id'";





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