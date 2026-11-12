<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');





$staff_id=$_REQUEST['staff_id'];
$exam_id=$_REQUEST['exam_id'];



$strSQL = "SELECT * FROM exam_schedule ";

if($exam_id==0){ $strSQL.= " where staff_id='$staff_id' ORDER BY exam_id DESC LIMIT 0, 5";}

if($exam_id>0){ $strSQL.= " where staff_id='$staff_id' AND exam_id<$exam_id ORDER BY exam_id DESC LIMIT 0, 5"; }


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