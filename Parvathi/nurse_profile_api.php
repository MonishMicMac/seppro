<?php


include("connect1.php");

// $id=$_REQUEST['id'];
$id=$_REQUEST['id'];

// $sql=mysql_query("SELECT incharge.*,telecaller_assign_manager.incharge_id
// FROM `incharge` 
// JOIN telecaller_assign_manager on incharge.id=telecaller_assign_manager.incharge_id
// WHERE incharge.id='$incharge_id'");


$sql=mysql_query("SELECT *
FROM `nurse_details` 
Where id='$id'
");



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


if(($intNumField)>0){
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