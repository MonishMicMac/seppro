<?php

include("connect.php"); 

$strSQL = "SELECT  doctors.doctor_name,product.pro_name,mst_pob.pob_product_qty,mst_pob.pob_free_qty,mst_pob.paymentterms,mst_pob.cdate FROM mst_pob,product,representative,doctors,mst_rcpa_stockist WHERE mst_pob.repid='".$_REQUEST['repid']."' AND product.id=mst_pob.pob_product AND mst_pob.repid=representative.id AND doctors.id=mst_pob.dc_id GROUP BY mst_pob.cdate";

$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	
	echo json_encode($antony);
?>