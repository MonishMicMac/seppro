<?php
header('Content-Type: application/json'); 
header("Access-Control-Allow-Origin: *"); 

include("connect23.php");

$manager_id = isset($_REQUEST['manager_id']) ? intval($_REQUEST['manager_id']) : 0;

if ($manager_id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid manager_id"
    ]);
    exit;
}

// Get Manager name
$managerQuery = "SELECT rep_name FROM representative WHERE id = '$manager_id'";
$managerResult = mysql_query($managerQuery);
$managerRow = mysql_fetch_assoc($managerResult);
$manager_name = $managerRow ? $managerRow['rep_name'] : null;

// Get reps under this manager
$query = "SELECT r.id, r.rep_name 
          FROM assigningreptomanager a
          JOIN representative r ON a.repid = r.id
          WHERE a.managerid = '$manager_id'";

$result = mysql_query($query) or die(json_encode([
    "success" => false,
    "message" => mysql_error()
]));

$reps = [];
while ($row = mysql_fetch_assoc($result)) {
    $reps[] = [
        "id" => $row['id'],
        "name" => $row['rep_name']
    ];
}

// Response
if (count($reps) > 0) {
    echo json_encode([
        "success" => true,
        "manager" => [
            "id" => $manager_id,
            "name" => $manager_name
        ],
        "reps" => $reps
    ]);
} else {
    echo json_encode([
        "success" => false,
        "manager" => [
            "id" => $manager_id,
            "name" => $manager_name
        ],
        "message" => "No reps found"
    ]);
}
?>
