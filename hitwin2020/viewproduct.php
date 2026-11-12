<?php
include('connect.php');

$strSQL = "SELECT  product.id,product.pro_name FROM client_product_list,product WHERE client_product_list.clientid='".$_REQUEST['customerid']."' and product.id=client_product_list.product_id";
	
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