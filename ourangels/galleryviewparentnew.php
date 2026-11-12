<?php
// include("connectsms.php");

$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
mysql_select_db($_REQUEST['db'],$con);
date_default_timezone_set('Asia/Calcutta');

ini_set('max_execution_time', 600);


$strSQL= "SELECT count(*) as tot_img,g_galname,g_heading FROM gallery  where g_galname != ''  GROUP BY g_heading ";
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