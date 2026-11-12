<?php
include("connect.php");

$name= $_REQUEST['name'];

//$alpha = "SELECT //position.serverTime,position.deviceTime,position.fixTime,position.latitude,position.longitude,position.speed,device.name,device.uniqueId,user.time FROM //position,device,user_device,user WHERE device.name='$name' AND device.id = position.deviceId AND position.id = device.positionId AND user_device.deviceId //= device.id AND user_device.userId = user.id";

$alpha="SELECT * 
FROM positions,devices
WHERE devices.name =  '$name'
AND devices.id = positions.deviceId ORDER BY positions.id DESC LIMIT 1";


$objQuery = mysql_query($alpha);
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