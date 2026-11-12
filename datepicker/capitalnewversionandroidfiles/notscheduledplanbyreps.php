<?php
include("connect23.php"); 
 

$doctorid=$_REQUEST['doctorid'];

$strSQL = "SELECT rep_name FROM representative WHERE id NOT IN (SELECT wp_rep_id FROM tbl_work_plan WHERE c_date='$doctorid' AND UP='P')";










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