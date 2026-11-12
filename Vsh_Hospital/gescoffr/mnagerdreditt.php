<?php

include("connect.php"); 



$drid=$_REQUEST['drid'];

$strSQL = $je->prepare("SELECT *,(select hos_name from Hospitalname WHERE Hospitalname.id=doctors.doc_hospital_clinic_name) AS  hospital_id  FROM doctors WHERE id='$drid'");
$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>