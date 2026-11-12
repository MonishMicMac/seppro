<?php
include("../connect.php"); 

$rep_id = isset($_REQUEST['rep_id']) ? $_REQUEST['rep_id'] : '';

if ($rep_id == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID is required.",
        "data" => (object)array()
    ));
    exit;
}

try {
    $start_of_month = date('Y-m-') . '01';

    $strSQL = "SELECT `wp_date` AS WP_DATE, `wp_dc` AS DC, COUNT(*) AS CNT 
               FROM `tbl_work_plan` 
               WHERE wp_rep_id = :rep_id 
                 AND wp_dc = 'D' 
                 AND wp_date >= :start_date 
               GROUP BY `wp_date`, `wp_dc`";

    $objQuery = $je->prepare($strSQL);
    $objQuery->execute(array(
        ':rep_id'     => $rep_id,
        ':start_date' => $start_of_month
    ));
    
    $rows = $objQuery->fetchAll(PDO::FETCH_ASSOC);
    $resultData = array();

    foreach ($rows as $row) {
        $wp_date = $row['WP_DATE'];
        $resultData[$wp_date] = array(
            "WP_DATE" => $wp_date,
            "DC"      => $row['DC'],
            "CNT"     => $row['CNT']
        );
    }

    if (count($resultData) > 0) {
        ksort($resultData);

        $response = array(
            "status" => true,
            "message" => "Doctor call logs for the current month retrieved successfully.",
            "data" => (object)$resultData 
        );
    } else {
        $response = array(
            "status" => false,
            "message" => "No work plan call records found for this representative this month.",
            "data" => (object)array()
        );
    }

} catch (Exception $e) {

$response = array(
        "status" => false,
        "message" => "Database operation exception: " . $e->getMessage(),
        "data" => (object)array()
    );
    
}

echo json_encode($response);
?>