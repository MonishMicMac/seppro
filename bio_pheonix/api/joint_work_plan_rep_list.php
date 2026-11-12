<?php
include("../connect.php"); 

$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';

// 1. Validator: Check if the required parameters are provided
if ($id == '' || $date == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Manager ID and Date are required parameters.",
        "data" => (object)array()
    ));
    exit;
}

try {
    // Fetch all representatives assigned to this manager
    $strSQL = $je->prepare("SELECT representative.id, representative.rep_name, representative.designation, representative.mobile FROM representative, assigningreptomanager WHERE assigningreptomanager.managerid = :manager_id AND representative.id = assigningreptomanager.repid ORDER BY representative.rep_name ASC");
    $strSQL->execute(array(':manager_id' => $id));
    $representatives = $strSQL->fetchAll();
    
    $resultData = array();

    foreach($representatives as $link)
    {
        $repidd  = $link['id'];
        $repname = $link['rep_name'];
        $repdesignation = $link['designation'];
        $repmobile = $link['mobile'];

        // Count work plans for this representative matching the date and manager context
        $a = $je->prepare("SELECT COUNT(*) FROM managerjoinworkplans WHERE date = :work_date AND repid = :rep_id AND managerid = :manager_id");
        $a->execute(array(
            ':work_date'  => $date,
            ':rep_id'     => $repidd,
            ':manager_id' => $id
        ));
        $planCount = $a->fetchColumn();

        // Map the array records directly using the representative's ID as the key instead of 0, 1, 2...
        $resultData[$repidd] = array(
            "rep_id"      => $repidd,
            "rep_name"    => $repname,
            "designation" => $repdesignation,
            "mobile"      => $repmobile,
            "total"       => $planCount
        );
    }

    // 2. Wrap output with dynamic JSON status & message envelope framework
    if (count($resultData) > 0) {
        $response = array(
            "status" => true,
            "message" => "Team work plan reps retrieved successfully.",
            "data" => (object)$resultData // Cast to object to force key-value JSON syntax
        );
    } else {
        $response = array(
            "status" => false,
            "message" => "No representatives found assigned to this manager.",
            "data" => (object)array()
        );
    }

} catch (Exception $e) {
    // Safe error exception wrapper handling layout issues gracefully
    $response = array(
        "status" => false,
        "message" => "Database operation exception: " . $e->getMessage(),
        "data" => (object)array()
    );
}

echo json_encode($response);
?>