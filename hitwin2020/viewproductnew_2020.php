<?php
include('connect.php');
//$status = $_REQUEST['status'];

$client_id =	$_REQUEST['customerid'];
$tracking_id = $_REQUEST['tracking_id'];

$status_q= mysql_query("SELECT clientOrenquiry,sales_type FROM clinetcreation WHERE id='".$client_id."'");

$status_arr =	mysql_fetch_array($status_q);

$status = $status_arr['clientOrenquiry'];
// $call_type =	$status_arr['sales_type'];


	if(strpos($tracking_id, 'HSAL') !== false){
		$call_type = 'Sales';
  	}else if(strpos($tracking_id, 'HREN') !== false){
		$call_type = 'Rental';
  	}else if(strpos($tracking_id, 'HSER') !== false ){
		$call_type = 'Service';
  	}else {
		$call_type = '';
  	}


if($status=='1')
{
    
	// $strSQL = "SELECT product.id,product.pro_name FROM client_enquiry_product_list,product WHERE client_enquiry_product_list.clientid='".$_REQUEST['customerid']."' and product.id=client_enquiry_product_list.product_id";

	if($call_type == 'Sales' || $call_type == 'Service'){
		$strSQL = "SELECT product.id,product.pro_name FROM client_enquiry_product_list,product WHERE client_enquiry_product_list.clientid='".$_REQUEST['customerid']."' and product.pro_id=client_enquiry_product_list.product_id and tracking_id='".$tracking_id."' and tracking_id != '' ";
	}else{
		$strSQL = "SELECT product_rental.id,product_rental.pro_name FROM client_enquiry_product_list,product_rental WHERE client_enquiry_product_list.clientid='".$_REQUEST['customerid']."' and product_rental.pro_id=client_enquiry_product_list.product_id and tracking_id='".$tracking_id."' and tracking_id != '' ";
	}
}
else if($status=='2')
{

    if($call_type == 'Sales' || $call_type == 'Service'){
		$strSQL = "SELECT product.id,product.pro_name FROM client_product_list,product WHERE client_product_list.clientid='".$_REQUEST['customerid']."' and product.pro_id=client_product_list.product_id and tracking_id='".$tracking_id."' and tracking_id != '' ";
	
		$q = mysql_fetch_array(mysql_query($strSQL));

	}else{
		$strSQL = "SELECT product_rental.id,product_rental.pro_name FROM client_product_list,product_rental WHERE client_product_list.clientid='".$_REQUEST['customerid']."' and product_rental.pro_id=client_product_list.product_id and tracking_id='".$tracking_id."' and tracking_id != '' ";
	}

}else{

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


	//http://seppro.net/hitwin2020/viewproductnew_2020.php?customerid=19&tracking_id=HSER6187

?>

