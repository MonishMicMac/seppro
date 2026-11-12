<?php

include("connect.php"); 

$productid=$_REQUEST['productid'];
$repid=$_REQUEST['repid'];




$strSQL = $je->prepare("SELECT mst_pob.cdate,mst_pob.ctime,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_pincode,doctors.prescriber,mst_pob.pob_product_qty,mst_pob.pob_free_qty FROM mst_pob,doctors WHERE mst_pob.pob_product='$productid' AND mst_pob.repid='$repid' AND doctors.id=mst_pob.dc_id");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>