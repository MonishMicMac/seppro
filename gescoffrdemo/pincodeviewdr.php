<?php
include("connect1.php"); 
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);


 //$strSQL = "SELECT pin_id,pincode,IFNULL((select area_name from pincode_list where pincode=master_pincode.pincode AND state_id IN(1,4,5,6,7,8,9,14,17,25) order by id asc limit 1),'No area name') as area_name FROM master_pincode ";
 $strSQL = "SELECT `pin_id`,`pincode` FROM `master_pincode` WHERE `state_id` IN (1,4,5,6,7,8,9,14,17,25)";

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