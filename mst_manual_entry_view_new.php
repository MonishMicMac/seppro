<?php
include("include/connect.php");

if($_REQUEST['condition']=='get_batchs'){
	$sql=mysql_query("SELECT mst_batchdetails.batch FROM mst_batchdetails,product WHERE mst_batchdetails.product_id=product.id AND pro_name='".$_REQUEST['pro_name']."'");
	echo "<option value=''>--Select--</option>";
	while($row=mysql_fetch_array($sql)){
		echo "<option value='".$row['batch']."'>".$row['batch']."</option>";
	}
}


if($_REQUEST['condition']=='get_batch_price'){
	$sql=mysql_query("SELECT mst_batchdetails.batch_ptr,mst_batchdetails.batch_pts FROM mst_batchdetails WHERE batch='".$_REQUEST['batch_id']."'");
	$row=mysql_fetch_array($sql);
	if($row['batch_ptr']!='' && $row['batch_pts']!=''){
		echo "<span style='font-weight:600;'>PTR : ".$row['batch_ptr']." - PTS : ".$row['batch_pts']."</span>";
	}
}
?>