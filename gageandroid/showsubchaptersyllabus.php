<?php
include("connectsms.php");

$sub_chapter=$_REQUEST['sub_chapter'];

$strSQL="SELECT * from tbl_syllabus_unitchapter_subchapter where syllabus_id='$sub_chapter'";
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