<?php
$user="root";
$pass="$3pp60@2016";
$database="andesron";
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');

$imeino=$_REQUEST['rep_imeino'];




$strSQL = "SELECT id,rep_name,welcomewishes,welcomeurl,welcomeclose,dateoftourplan,supportnumber,version,blockopeningmonth,playurl,(select count(*) from representative where rep_id>0) as count FROM representative where rep_imeino='$imeino'";

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