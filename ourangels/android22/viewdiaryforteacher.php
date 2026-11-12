<?php

$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');






$strSQL = "SELECT * FROM dairyupdate WHERE standard_id='".$_REQUEST["standard_id"]."' AND section_id='".$_REQUEST["section_id"]."'";


if(@$_REQUEST["date"]=="0000-00-00"){
   $strSQL.=" AND date = (SELECT date FROM dairyupdate WHERE standard_id='".$_REQUEST["standard_id"]."' AND section_id='".$_REQUEST["section_id"]."' ORDER BY id DESC LIMIT 1) ";
}

if(@$_REQUEST["prevdate"]!=""){
   $strSQL.=" AND date = (SELECT date FROM dairyupdate WHERE standard_id='".$_REQUEST["standard_id"]."' AND section_id='".$_REQUEST["section_id"]."' AND date <'".$_REQUEST["prevdate"]."' ORDER BY id DESC LIMIT 1)";
}

if(@$_REQUEST["nextdate"]!=""){
   $strSQL.=" AND date = (SELECT date FROM dairyupdate WHERE standard_id='".$_REQUEST["standard_id"]."' AND section_id='".$_REQUEST["section_id"]."' AND date >'".$_REQUEST["nextdate"]."' ORDER BY id DESC LIMIT 1)";
}

$strSQL.=" ORDER BY date DESC";



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