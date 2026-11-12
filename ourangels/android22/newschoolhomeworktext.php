<?php

/*$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";*/

include("../../includes/connect_db.php");

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');
$staff_id=$_REQUEST['staff_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];



$strSQL = "SELECT * FROM assignment where staff_id='$staff_id' and month='$month' and year='$year'";

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