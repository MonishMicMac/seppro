<?php
include("connectsms.php");
ini_set('max_execution_time', 300);

$groupname=$_REQUEST['heading'];


$strSQL= "SELECT g_galname,g_heading FROM gallery  where g_heading = '$groupname' AND  g_type = '0' AND g_std='".$_REQUEST['std']."' AND g_sec='".$_REQUEST['sec']."'";


$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();  
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuery,$i)] =$obResult[$i];
			
		}
		array_push($resultArray,$arrCol);
	}
	
	//print_r($resultArray);
// 	foreach ($resultArray as $image) {
//   echo '<img src="data:image/png;base64,'. $image['g_img'] .'" />';
// }
echo json_encode($resultArray);  



?>