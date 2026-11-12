<?php
include("../connect.php"); 

$repid = isset($_REQUEST['repid']) ? $_REQUEST['repid'] : '';
$managerid = isset($_REQUEST['managerid']) ? $_REQUEST['managerid'] : '';
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';

if ($repid == '' || $managerid == '' || $date == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID, Manager ID, and Date are required parameters.",
       // "data" => (object)array()
    ));
    exit;
}

try {
    $c = $je->prepare("DELETE FROM managerjoinworkplans WHERE repid = :rep_id AND managerid = :manager_id AND date = :work_date");
    
    $result = $c->execute(array(
        ':rep_id'     => $repid,
        ':manager_id' => $managerid,
        ':work_date'  => $date
    ));
    
    if ($result) {
        $response = array(
            "status" => true,
            "message" => "Manager joint work plan deleted successfully.",
           // "data" => (object)array()
        );
    } else {
        $response = array(
            "status" => false,
            "message" => "Failed to delete the specified joint work plan.",
          //  "data" => (object)array()
        );
    }
    
} catch (Exception $e) {
    $response = array(
        "status" => false,
        "message" => "Database operation exception: " . $e->getMessage(),
       // "data" => (object)array()
    );
}

echo json_encode($response);
?>