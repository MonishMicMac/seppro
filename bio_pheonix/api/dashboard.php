<?php
$user = "root";
$pass = "$3pp60@2016";
$database = "bio_pheonix";
$con = mysql_connect("localhost", $user, $pass) or die('Couldnt connect to server');
mysql_select_db($database, $con) or die('could not connect to db');

$rep_id = isset($_REQUEST['rep_id']) ? $_REQUEST['rep_id'] : '';

if ($rep_id == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID is required.",
        "data" => (object)array()
    ));
    mysql_close($con);
    exit;
}

$strSQL = "SELECT * FROM representative WHERE id='$rep_id'";
$objQuery = mysql_query($strSQL);

if (!$objQuery) {
    echo json_encode(array(
        "status" => false,
        "message" => "Database error: " . mysql_error(),
        "data" => (object)array()
    ));
    mysql_close($con);
    exit;
}

$intNumField = mysql_num_fields($objQuery);
$resultData = (object)array();
$userFound = false;

if ($obResult = mysql_fetch_array($objQuery)) {
    $userFound = true;
    $arrCol = array();
    for ($i = 0; $i < $intNumField; $i++) {
        $arrCol[mysql_field_name($objQuery, $i)] = $obResult[$i];
    }
    
    // 1. Inject Performance tracking object metrics
    $arrCol['performance'] = array(
        "overall" => 50,
        "scheduled" => 35,
        "missed" => 20
    );
    
    // 2. Inject Approved Doctor Call Reports tracking
    $arrCol['today_approved_dr_call_report'] = array(
        "planned" => 30,
        "pending" => 20,
        "visited" => 10
    );
    
    // 3. Inject Chemist Call Reports tracking
    $arrCol['today_chemist_call_report'] = array(
        "planned" => 30,
        "pending" => 20,
        "visited" => 10
    );
    
    // 4. Inject BPO Operations management metrics
    $arrCol['bpo_operations'] = array(
        "todays_plan" => 30,
        "achivement" => "20%",
        "coverage" => 10
    );
    
    // 5. Inject BPM Operations management metrics
    $arrCol['bpm_operations'] = array(
        "todays_plan" => 30,
        "achivement" => "20%",
        "coverage" => 10
    );

    $resultData = (object)$arrCol;
}

mysql_close($con);

if ($userFound) {
    $response = array(
        "status" => true,
        "message" => "Representative data retrieved successfully",
        "data" => $resultData
    );
} else {
    $response = array(
        "status" => false,
        "message" => "Representative not found",
        "data" => (object)array()
    );
}

echo json_encode($response);
?>