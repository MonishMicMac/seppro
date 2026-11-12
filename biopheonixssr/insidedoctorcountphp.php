<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);




 define('WP_MEMORY_LIMIT', '512M');


$strSQL = "SELECT SUM(quantity) Q,SUM(free_quantity) F,SUM(replace_quantity) R, ROUND(SUM(areawise_temp.quantity*product.ptr),2) AS PTR,ROUND(SUM(areawise_temp.quantity*product.pts),2) PTS , product.pro_name FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".$_REQUEST["to_date"]."') AND areawise_temp.our_cust_id = '".$_REQUEST["cust_id"]."' and areawise_temp.our_product_id=product.id GROUP BY areawise_temp.our_product_id";
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