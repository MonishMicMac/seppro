<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');




$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$assign_id=$_REQUEST['assign_id'];



$strSQL = "SELECT * FROM assignment ";

if($assign_id==0){ $strSQL.= " where standard_id='$standard_id' AND section_id='$section_id' ORDER BY assign_id DESC LIMIT 0, 5";}

if($assign_id>0){ $strSQL.= " where standard_id='$standard_id' AND section_id='$section_id' AND assign_id<$assign_id ORDER BY assign_id DESC LIMIT 0, 5"; }


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