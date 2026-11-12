<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

$cust_id=$_REQUEST['cust_id'];
$rep_id=$_REQUEST['rep_id'];
$from=date('Y/m/d', strtotime($_REQUEST["from_date"]));
$to=date('Y/m/d', strtotime($_REQUEST["to_date"]));


$strSQL = "SELECT concat(product.pro_name,'(',(SELECT dis_name FROM distributor WHERE dis_id=areawise_temp.dist_id),')') AS pro_name, SUM(areawise_temp.quantity) AS Q, SUM(areawise_temp.replace_quantity) AS R, SUM(areawise_temp.free_quantity) AS F,ROUND(SUM(areawise_temp.quantity*product.ptr),2) AS PTR, ROUND(SUM(areawise_temp.quantity*product.pts),2) AS PTS FROM areawise_temp,product WHERE areawise_temp.rep_id = '$rep_id' AND areawise_temp.our_cust_id<>'' AND areawise_temp.our_product_id<>'' AND (areawise_temp.bill_date BETWEEN '$from' AND '$to')  AND areawise_temp.our_cust_id='$cust_id' AND product.id=areawise_temp.our_product_id GROUP BY our_product_id";
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