<?php

include("connect.php"); 

$repid=$_REQUEST['repid'];

$dat=$_REQUEST['dat'];

/*$date_arr= explode("-", $dat);
$date= $date_arr[0];
$time= $date_arr[1];
 $ff= $date.'-'.$time;*/

/*echo "SELECT c.doctor_name,a.rep_id,a.id,a.shop_name,a.owner_name,a.landlineno,b.cdatee,b.ctimee FROM patientvisit b left join tbl_customer_master a on b.chemist_id=a.id left join doctors c on c.id=b.doctor_id WHERE b.rep_id='$rep_id' and b.cdatee like '%".$dat."%'"; */
$strSQL = $je->prepare("SELECT c.doctor_name,a.rep_id,a.id,a.shop_name,a.owner_name,a.landlineno,b.cdatee,b.ctimee FROM patientvisit b left join tbl_customer_master a on b.chemist_id=a.id left join doctors c on c.id=b.doctor_id WHERE b.rep_id='$repid' and b.cdatee like '%".$dat."%'");

$strSQL->execute();


$array = $strSQL->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
	
?>