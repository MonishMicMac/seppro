<?php
include("../connect.php"); 

$repid = isset($_REQUEST['repid']) ? $_REQUEST['repid'] : '';

// 1. Validator: Check if the required representative ID parameter is provided
if ($repid == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID is required.",
       // "data" => (object)array()
    ));
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$c_date = date('Y-m-');

try {
    // Prepare the update statement
    $b = $je->prepare("UPDATE representative SET managertourplanopen='1', blockopeningmonth=:block_month WHERE id=:rep_id");
    
    // Execute with named placeholders to safeguard data structure execution
    $result = $b->execute(array(
        ':block_month' => $c_date,
        ':rep_id' => $repid
    ));
    
    // Check if the query execution was successful
    if ($result) {
        $response = array(
            "status" => true,
            "message" => "Manager tour plan layout opened successfully.",
         //   "data" => (object)array()
        );
    } else {
        $response = array(
            "status" => false,
            "message" => "Failed to update representative tour plan status.",
          //  "data" => (object)array()
        );
    }
} catch (Exception $e) {
    // Safe error wrapper encapsulation tracking system block issues
    $response = array(
        "status" => false,
        "message" => "Database operation exception: " . $e->getMessage(),
       // "data" => (object)array()
    );
}

// 2. Output Execution Presentation Layer Block
echo json_encode($response);
?>