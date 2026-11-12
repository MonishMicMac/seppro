<?php

include("connect.php"); 


$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$date=$year.'-'.$month;
$repid=$_REQUEST['repid'];
$status=$_REQUEST['status'];


$a = $je->prepare("SELECT group_concat(wp_dc_id) wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$repid'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0'")or die(mysql_error());
$a->execute();
$wp_dc_id = $a->fetchColumn();

$strSQL = "SELECT id,favourite,doc_specilist_id,doc_qualification,doc_pincode,doctor_name,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='' then group_concat(DATE_FORMAT(wp_date,'%d')) else 'Not Met' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and wp_rep_id='$repid' and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$date' and attendancestatus='1' and drunavailable='$status' and wp_dc='D') as days FROM doctors WHERE rep_id='$repid' and id not in ($wp_dc_id)  ORDER BY days ASC ";





$objQuery = $je->prepare($strSQL);

$objQuery ->execute();

$array = $objQuery ->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($array);
?>