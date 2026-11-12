<?php
include("include/connect.php");

if(@$_REQUEST['condition']=="fetch_data"){
	$id=$_REQUEST['batch_id'];
	$array=array();

	$sql=mysql_query("SELECT batch, (SELECT pro_name FROM product where id=mst_batchdetails.product_id) product, batch_mrp, batch_pts, batch_ptr, batch_nrv, batch_mfrdate, batch_expdate FROM mst_batchdetails WHERE batch_id='$id'");
	$row=mysql_fetch_array($sql);

	$array['batch']=$row['batch'];
	$array['product']=$row['product'];
	$array['batch_mrp']=$row['batch_mrp'];
	$array['batch_pts']=$row['batch_pts'];
	$array['batch_ptr']=$row['batch_ptr'];
	$array['batch_nrv']=$row['batch_nrv'];
	$array['batch_mfrdate']=$row['batch_mfrdate'];
	$array['batch_expdate']=$row['batch_expdate'];

	echo json_encode($array);
}


if(@$_REQUEST['condition']=="check_duplicate"){
	$batch=$_REQUEST['batch_no'];
	$sql=mysql_query("SELECT count(*) as cnt FROM mst_batchdetails WHERE batch='$batch'");
	$row=mysql_fetch_array($sql);

	if($row['cnt']>0){
		echo json_encode(array('status' => 'failed'));
	} else {
		echo json_encode(array('status' => 'success'));
	}
}
?>