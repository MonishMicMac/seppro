<?php

/*$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";*/

include("../../includes/connect_db.php");

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$strSQL = mysql_query("SELECT * FROM tbl_stc_stn_assign_sec
 WHERE sn_id='".$_REQUEST["sec_standard_id"]."'")or die(mysql_error());

$jjsecall = mysql_fetch_array($strSQL);

$sec = $jjsecall['sec_id'];

$jjsec = "SELECT * FROM mst_sec 
 WHERE sec_id IN($sec) ";

$objQuery = mysql_query($jjsec);
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