<?php

include("connect.php"); 

$rep_id=$_REQUEST['rep_id'];
$doctor_id=$_REQUEST['doctor_id'];
$dat=$_REQUEST['dat'];


$strSQL = $je->prepare("SELECT c.doctor_name,a.rep_id,a.id,a.shop_name,a.owner_name,a.landlineno,b.cdatee,b.ctimee FROM patientvisit b left join tbl_customer_master a on b.chemist_id=a.id left join doctors c on c.id=b.doctor_id WHERE b.rep_id='$rep_id' and b.cdatee='$dat' and b.doctor_id='$doctor_id'");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>