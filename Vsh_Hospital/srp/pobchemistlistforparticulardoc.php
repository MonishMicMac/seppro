<?php
include("connect2.php"); 

 

$rep_id=$_REQUEST['rep_id'];
$doctor_id=$_REQUEST['doctor_id'];


$strSQL = "SELECT * 
FROM tbl_customer_master
WHERE rep_id='$rep_id' AND doctor_id='$doctor_id'";





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