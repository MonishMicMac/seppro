<?php
include('connect.php');
$clientid = $_REQUEST['clientid'];

$strSQL = "SELECT id,product_id,remarks_cus,status,created_at,updated_at FROM service_req_clients_from_mble where clientid='$clientid'";
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
        
        $objProduct = mysql_query("SELECT pro_name FROM product where id IN (".$obResult['product_id'].")");
        $arrCol1='';
     	while($rows=mysql_fetch_array($objProduct))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
        $arrCol['pro_name']=$arrCol1;
	array_push($resultArray,$arrCol);
}

echo json_encode($resultArray);

?>