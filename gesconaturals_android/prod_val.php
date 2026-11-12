<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$client_id=$_REQUEST['client_id'];

// echo "SELECT (select pro_name from product where id=pobbooking.productid) pro_name,productid,SUM(qty) qty,((select ptr from product where id=pobbooking.productid)*SUM(qty)) price FROM pobbooking WHERE repid='$rep_id' AND client_id='$client_id'  AND (cdate BETWEEN DATE_SUB(DATE(cdate), INTERVAL 3 MONTH) AND DATE(CURDATE())) GROUP BY productid";

$objQuery = mysql_query("SELECT (select pro_name from product where id=pobbooking.productid) pro_name,productid,SUM(qty) qty,((select ptr from product where id=pobbooking.productid)*SUM(qty)) price FROM pobbooking WHERE repid='$rep_id' AND client_id=(select id from doctors where stockist_id='".$_REQUEST['dis']."' AND id='".$client_id."') AND (cdate BETWEEN DATE_SUB(DATE(cdate), INTERVAL 3 MONTH) AND DATE(CURDATE())) GROUP BY productid");
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