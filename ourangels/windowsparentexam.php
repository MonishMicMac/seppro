<?php

error_reporting(0);
$con=mysql_connect("localhost","adsouq_school","micandmac@123");
mysql_select_db("adsouq_school",$con);



$standard_id=$_REQUEST['standard_id'];
$section_id=$_REQUEST['section_id'];
$exam_id=$_REQUEST['exam_id'];



$strSQL = "SELECT * FROM exam_schedule";

if($exam_id==0){ $strSQL.= " where standard_id='$standard_id' AND section_id='$section_id' ORDER BY exam_id DESC";}

if($exam_id>0){ $strSQL.= " where standard_id='$standard_id' AND section_id='$section_id' AND exam_id<$exam_id ORDER BY exam_id DESC LIMIT 0, 5"; }


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
	
	echo '{"exam":'.json_encode($resultArray)."}";

?>