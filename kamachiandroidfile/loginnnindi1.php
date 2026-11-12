<?php


	
	
	$user="root";
$pass="$3pp60@2016";
$database="kamachitmt";
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");


$rep_id=$_REQUEST['rep_id'];
$succesdays=$_REQUEST['succesdays'];
$rep_idjk='0';

$strSQL = "SELECT rep_id,id,rep_name,mobile,rep_imeino,dateoftourplan,adminon,('$c_date')as hdate  FROM representative where rep_imeino='$rep_id'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
$rep_idjk='1';
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);




?>