<?php

include("connect.php"); 



$rep_id=$_REQUEST['rep_id'];
$hos=$_REQUEST['hos'];


$strSQL = $je->prepare("SELECT *,(select hos_name from Hospitalname WHERE Hospitalname.id=doctors.doc_hospital_clinic_name) AS  hospital_id FROM doctors WHERE rep_id='$rep_id' and doc_hospital_clinic_name='".$hos."'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>