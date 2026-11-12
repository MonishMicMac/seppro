<?php
include("connect23.php"); 

$wp_rep_id=$_REQUEST['rep_id'];
// print_r($wp_rep_id);exit();

$strSQL = "SELECT * FROM doctors WHERE rep_assign='$wp_rep_id' order by doctor_name ASC";
// print_r($strSQL);exit();

$objQuery = mysql_query($strSQL);
// print_r($objQuery);exit();

	$intNumField = mysql_num_fields($objQuery);
// print_r($intNumField);exit();

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
// print_r($obResult);exit();

		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
// print_r($arrCol);exit();

		array_push($resultArray,$arrCol);
	}
// print_r($resultArray);exit();
	
	mysql_close($con);
	
	echo json_encode($resultArray);

//    echo print_r($resultArray);exit();

?>