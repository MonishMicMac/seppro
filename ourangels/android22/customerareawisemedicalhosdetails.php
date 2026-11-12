<?php
$hostname="localhost";
$username="kaligigr_krmpsp";
$password="school@123";
$database="kaligigr_krmpsp";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');

$cust_name=$_REQUEST["cust_name"];
$pincode=$_REQUEST["pincode"];

$from_date=$_REQUEST["from_date"];
$to_date=$_REQUEST["to_date"];

$strSQL = "SELECT A.area_name,A.our_cust_id,A.cust_name,A.our_product_id,A.pro_name,A.quantity,A.free_quantity,A.replace_quantity,A.sale_value,A.net_amount,D.dis_name FROM areawise_temp AS A, distributor AS D where (A.bill_date BETWEEN '".$from_date."' AND '".$to_date."') AND A.cust_name= '".$cust_name."' AND A.pincode=".$pincode." GROUP BY pro_name";
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