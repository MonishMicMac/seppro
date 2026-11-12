<?php
include("connect1.php");


$manager_id=$_REQUEST['manager_id'];




$strSQL = "SELECT managerid,(select rep_name from representative where id=assigningreptomanager.managerid) manager_name,repid,(select rep_name from representative where id=assigningreptomanager.repid) rep_name FROM assigningreptomanager,representative WHERE managerid IN (select repid from assigningreptomanager,representative where assigningreptomanager.managerid=representative.id and managerid='$manager_id' and representative.adminstatus='1') AND assigningreptomanager.managerid=representative.id AND representative.rep_id!='0' AND managerid!='$manager_id'";

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