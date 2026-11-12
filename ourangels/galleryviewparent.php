<?php
include("connectsms.php");
ini_set('max_execution_time', 600);


$strSQL= "SELECT count(*) as tot_img,(SELECT `gallery_filename` FROM `gallery_slave` WHERE `gs_id`=g_galname) as g_galname,g_heading FROM gallery  where g_galname != '' AND  g_type = '0' AND g_status='1' AND g_std='".$_REQUEST['std']."' AND g_sec='".$_REQUEST['sec']."' GROUP BY g_heading ";
// $strSQL= "SELECT g_img FROM gallery where g_id = '23'";
$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			if(mysql_field_name($objQuery,$i)=='g_img'):
			$arrCol[mysql_field_name($objQuery,$i)] =base64_encode($obResult[$i]);
			else :
			$arrCol[mysql_field_name($objQuery,$i)] =$obResult[$i];
			endif;
			
		}
		array_push($resultArray,$arrCol);
	}
	
	//print_r($resultArray);
// 	foreach ($resultArray as $image) {
//   echo '<img src="data:image/png;base64,'. $image['g_img'] .'" />';
// }
echo json_encode($resultArray);  
?>