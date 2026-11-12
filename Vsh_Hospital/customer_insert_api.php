<?php

include("connect23.php"); 


$rep_id = $_REQUEST['rep_id'];
$shop_name = $_REQUEST['company_name'];


$jjsdzz = mysql_query("INSERT INTO `company`(`company_name`, `rep_id`)
     VALUES ('$shop_name','$rep_id')") or die(mysql_error());
// print_r($jjsdzz);exit();



if ($jjsdzz) {
    $output_data = array(
        'status' => 'true',
        'data' => 'Data Insert Sucessfully!'
    );
    echo json_encode($output_data);
} else {
    $output_data = array(
        'status' => 'failed',
        'data' => []
    );
    echo json_encode($output_data);
}
