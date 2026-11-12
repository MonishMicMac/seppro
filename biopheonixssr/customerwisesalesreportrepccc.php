<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);

$rep_id=$_REQUEST['rep_id'];
$from=date('Y/m/d', strtotime($_REQUEST["from_date"]));
$to=date('Y/m/d', strtotime($_REQUEST["to_date"]));


$strSQL = "SELECT areawise_temp.pincode,areawise_temp.pincode,areawise_temp.our_cust_id,concat(areawise_temp.pincode,'-',trim(areawise_temp.cust_name),'-',(select area_name from pincode_list where id=areawise_temp.area_id)) as cust_name,ROUND(SUM(areawise_temp.quantity*product.ptr),2) AS PTR,ROUND(SUM(areawise_temp.quantity*product.pts),2) PTS FROM areawise_temp,product WHERE areawise_temp.our_product_id=product.id AND (areawise_temp.bill_date BETWEEN '$from' AND '$to') AND areawise_temp.rep_id='$rep_id' GROUP BY areawise_temp.our_cust_id";
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