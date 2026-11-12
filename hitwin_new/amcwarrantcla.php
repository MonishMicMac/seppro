<?php
include("connect.php"); 












$strSQL = "SELECT clinetcreation.name,clinetcreation.address,clinetcreation.pincode,clinetcreation.mobileno,clinetcreation.companyname,client_product_list.product,client_product_list.clientid,client_product_list.model_no,client_product_list.purchase_date,client_product_list.brand_name,client_product_list.capacity,client_product_list.type FROM client_product_list,clinetcreation WHERE clinetcreation.id=client_product_list
.clientid";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {    
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
		array_push($resultArray,$arrCol);
	}
	echo json_encode($resultArray);





?>