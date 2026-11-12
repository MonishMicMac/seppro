<?php

$con=mysql_connect("localhost","root","$3pp60@2016");
mysql_select_db("biophoenix",$con);


 $a = explode("/",$_REQUEST["from_date"]);
 $flen = strlen($a[1]);

if($flen != '2')
{
 $frommonth = $a[0]."/"."0".$a[1]."/".$a[2];
}
else
{
 $frommonth = $_REQUEST["from_date"];
}

$b = explode("/",$_REQUEST["to_date"]);
 $tlen = strlen($b[1]);

if($tlen != '2')
{
 $tomonth = $b[0]."/"."0".$b[1]."/".$b[2];
}
else
{
 $tomonth = $_REQUEST["to_date"];
}
 


 define('WP_MEMORY_LIMIT', '512M');

$DID = mysql_query("SELECT chemist_id FROM doctors WHERE id=".$_REQUEST["doctorid"]."");
$D = mysql_fetch_object($DID);
$strSQL = "SELECT tbl_customer_master.id,shop_name, COUNT(DISTINCT(areawise_temp.our_product_id)) AS PCNT, ROUND(SUM(areawise_temp.quantity*product.ptr),2) AS PTR,ROUND(SUM(areawise_temp.quantity*product.pts),2) PTS FROM areawise_temp,product,tbl_customer_master WHERE (areawise_temp.bill_date BETWEEN '$frommonth' AND '$tomonth') AND areawise_temp.our_cust_id IN (".$D->chemist_id.") and areawise_temp.our_product_id=product.id AND areawise_temp.our_cust_id=tbl_customer_master.id GROUP BY areawise_temp.our_cust_id";
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