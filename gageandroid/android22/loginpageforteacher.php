<?php

/*$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";*/

include("../../includes/connect_db.php");

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$Staff_id=$_REQUEST['Staff_id'];
$Phone_no=$_REQUEST['Phone_no'];
$imeino=$_REQUEST['imeino'];


$strSQL = "SELECT * FROM staff_profile where Staff_id='$Staff_id' AND Phone_no='$Phone_no' AND imeino='$imeino'";

$objQuery = mysql_query($strSQL);
echo mysql_error();
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