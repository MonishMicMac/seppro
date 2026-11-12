<?php
// include("connectsms.php");

$con=mysql_connect($_REQUEST['host'],$_REQUEST['user'],$_REQUEST['pwd']);
mysql_select_db($_REQUEST['db'],$con);
date_default_timezone_set('Asia/Calcutta');


ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);

$groupname=$_REQUEST['heading'];

$strSQL= "SELECT g_id,g_galname,g_heading FROM gallery  where g_heading = '$groupname' " ;


$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();  
		for($i=0;$i<$intNumField;$i++)
		{
				if(mysql_field_name($objQuery,$i)=='g_img'){
			$arrCol[mysql_field_name($objQuery,$i)] =base64_encode($obResult[$i]);
			}
			else{
			$arrCol[mysql_field_name($objQuery,$i)] =$obResult[$i];
			}
			
		}
		array_push($resultArray,$arrCol);
	}
	
	//print_r($resultArray);
// 	foreach ($resultArray as $image) {
//   echo '<img src="data:image/png;base64,'. $image['g_img'] .'" />';
// }
echo json_encode($resultArray);  




//   $strSQL = "SELECT  g_img FROM gallery where g_id = '20'";
//   $objQuery = mysql_query($strSQL);
//   $resultimage = array();
//   $resultArray = array();
//   while($obResult = mysql_fetch_array($objQuery))
//   {
//    $resultimage[] = "data:image/png;base64,". base64_encode($obResult['g_img']) ."" ;
//    $resultArray[] = array("img"=>"data:image/png;base64,". base64_encode($obResult['g_img']) ."") ;

//   }
  
// foreach ($resultimage as $image) {
//   echo '<img src="'. $image .'" width="250" height="250"/>';
// }


?>