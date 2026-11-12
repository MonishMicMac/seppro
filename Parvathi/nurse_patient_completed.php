<?php


include("connect1.php");

// $id=$_REQUEST['id'];
$id=$_REQUEST['id'];

// $sql=mysql_query("SELECT incharge.*,telecaller_assign_manager.incharge_id
// FROM `incharge` 
// JOIN telecaller_assign_manager on incharge.id=telecaller_assign_manager.incharge_id
// WHERE incharge.id='$incharge_id'");


$sql=mysql_query("SELECT nurse_assign.*,patient_details.id,patient_details.contact_person,patient_details.phone_no,patient_details.address,patient_details.location,patient_details.patient_name
FROM `nurse_assign` 
LEFT JOIN patient_details on patient_details.id=nurse_assign.patient_id
-- LEFT JOIN inouttime_nurse on inouttime_nurse.nurse_id=nurse_assign.nurse_id
Where nurse_assign.nurse_id='$id' AND nurse_assign.is_completed = '1' AND  nurse_assign.re_assign = '0'
");
// $obResult = mysql_fetch_array($sql);

// print_r($obResult);exit();

$intNumField = mysql_num_fields($sql);
$resultArray = array();
while($obResult = mysql_fetch_array($sql))
{
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{
		$arrCol[mysql_field_name($sql,$i)] = $obResult[$i];
	}
	array_push($resultArray,$arrCol);
}


if(count($resultArray)>0){
    $output_data = array(
        'status' => 'true',
        'data' => $resultArray
        );
  echo json_encode($output_data);
 } else {
    $output_data = array(
        'status' => 'failed',
        'data' => []
        );
        echo json_encode($output_data);

 }


?>