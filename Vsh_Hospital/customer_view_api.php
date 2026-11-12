<?php
include("connect23.php"); 


$rep_id = $_REQUEST['rep_id'];



$strSQL = mysql_query("SELECT company_name FROM `company` WHERE `rep_id`='$rep_id'
");

$intNumField = mysql_num_fields($strSQL);
$resultArray = array();
while ($obResult = mysql_fetch_array($strSQL)) {
    // print_r($obResult);exit();

    $arrCol = array();
    for ($i = 0; $i < $intNumField; $i++) {
        $arrCol[mysql_field_name($strSQL, $i)] = $obResult[$i];
    }
    array_push($resultArray, $arrCol);
}
mysql_close($con);
	
	echo json_encode($resultArray);
// if (($intNumField) > 0) {
//     $output_data = array(
//         'status' => 'true',
//         'data' => $resultArray
//     );
//     echo json_encode($output_data);
// } else {
//     $output_data = array(
//         'status' => 'failed',
//         'data' => []
//     );
//     echo json_encode($output_data);
// }
