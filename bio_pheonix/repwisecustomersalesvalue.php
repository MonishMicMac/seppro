<?php

include("connect23.php"); 

 
$idg = $_REQUEST['id']; 
$d = $_REQUEST['datee'];
$date=date_create($d);
$salesdate= date_format($date,"F Y");

//echo "SELECT a.our_cust_id,b.shop_name,sum(a.quantity*a.pts) as total,a.pro_name,a.mrp FROM areawise_temp a LEFT JOIN tbl_customer_master b ON a.our_cust_id = b.id  where a.bill_string = '$salesdate' and a.rep_id ='$idg' and a.our_cust_id = '1878' ";exit();

 $strSQL = "SELECT a.our_cust_id,b.shop_name,sum(a.quantity*a.pts) as total FROM areawise_temp a LEFT JOIN tbl_customer_master b ON a.our_cust_id = b.id  where a.bill_string = '$salesdate' and a.rep_id ='$idg' GROUP BY a.our_cust_id";

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