<?php


include("connect1.php");

// $id=$_REQUEST['id'];
$id=$_REQUEST['patient_id'];

// $sql=mysql_query("SELECT incharge.*,telecaller_assign_manager.incharge_id
// FROM `incharge` 
// JOIN telecaller_assign_manager on incharge.id=telecaller_assign_manager.incharge_id
// WHERE incharge.id='$incharge_id'");


$sql=mysql_query("SELECT patient_details.*,nurse_assign.*,nurse_assign.remarks as assign_remarks
FROM `patient_details` 
LEFT JOIN nurse_assign on nurse_assign.patient_id=patient_details.id
Where patient_details.id='$id'
");
// $obResult = mysql_fetch_array($sql)



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
        'data' => $resultArray[0]
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