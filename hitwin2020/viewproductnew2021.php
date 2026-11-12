<?php
include('connect.php');
//$status = $_REQUEST['status'];

$client_id =	$_REQUEST['customerid'];
$status_q= mysql_query("SELECT clientOrenquiry,sales_type FROM clinetcreation WHERE id='".$client_id."'");
$status_arr =	mysql_fetch_array($status_q);
$status = $status_arr['clientOrenquiry'];
$call_type =	$status_arr['sales_type'];

if($status=='1')
{
    
	// $strSQL = "SELECT product.id,product.pro_name FROM client_enquiry_product_list,product WHERE client_enquiry_product_list.clientid='".$_REQUEST['customerid']."' and product.id=client_enquiry_product_list.product_id";
	if($call_type == 'Sales' || $call_type == 'Service'){
		$strSQL = "SELECT client_enquiry_product_list.model_no,client_enquiry_product_list.sl_no,client_enquiry_product_list.purchase_date,product.id,product.pro_name FROM client_enquiry_product_list,product WHERE client_enquiry_product_list.clientid='".$_REQUEST['customerid']."' and product.pro_id=client_enquiry_product_list.product_id";
	}else{
		$strSQL = "SELECT client_enquiry_product_list.model_no,client_enquiry_product_list.sl_no,client_enquiry_product_list.purchase_date,product_rental.id,product_rental.pro_name FROM client_enquiry_product_list,product_rental WHERE client_enquiry_product_list.clientid='".$_REQUEST['customerid']."' and product_rental.pro_id=client_enquiry_product_list.product_id";
	}
}
else if($status=='2')
{
    if($call_type == 'Sales' || $call_type == 'Service'){
		$strSQL = "SELECT client_product_list.model_no,client_product_list.sl_no,client_product_list.purchase_date,product.id,product.pro_name FROM client_product_list,product WHERE client_product_list.clientid='".$_REQUEST['customerid']."' and product.pro_id=client_product_list.product_id";
	}else{
		$strSQL = "SELECT client_product_list.model_no,client_product_list.sl_no,client_product_list.purchase_date,product_rental.id,product_rental.pro_name FROM client_product_list,product_rental WHERE client_product_list.clientid='".$_REQUEST['customerid']."' and product_rental.pro_id=client_product_list.product_id";
	}

}	
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