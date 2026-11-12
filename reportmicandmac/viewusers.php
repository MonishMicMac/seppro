<?php
include("connect.php");

$u_id=$_REQUEST['u_id'];


$strSQL = "SELECT * FROM  temp_login_new where  u_id!='$u_id'";
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