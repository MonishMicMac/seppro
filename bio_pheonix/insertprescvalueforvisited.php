<?php
include("connect.php"); 

$wp_id               = $_REQUEST['wp_id'];
$latitude            = $_REQUEST['latitude'];
$longitude           = $_REQUEST['longitude'];
$drunavailable       = $_REQUEST['drunavailable'];
$reportstatus        = $_REQUEST['reportstatus']; // Note: unused in standard logic, but passed to reportstatus below
$jointworkby         = $_REQUEST['jointworkby'];
$drunavailablereason = $_REQUEST['drunavailablereason'];
$prescriptionvalue   = $_REQUEST['prescriptionvalue'];
$address             = isset($_REQUEST['address']) ? $_REQUEST['address'] : ''; // Added to prevent undefined variable error

// Validate Latitude & Longitude
if (
    $latitude === '' || $longitude === '' ||
    !is_numeric($latitude) || !is_numeric($longitude) ||
    (float)$latitude == 0.0 || (float)$longitude == 0.0
) {
    echo json_encode([
        "status" => false,
        "message" => "Invalid latitude or longitude."
    ]);
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$c_date = date('Y-m-d');
$c_time = date("h:i:s A");

// 1. Update the Work Plan (using parameterized queries for security)
$strSQL = $je->prepare("UPDATE tbl_work_plan SET 
    attendancestatus = '1', 
    latitude = ?, 
    longitude = ?, 
    areaname = ?, 
    reporteddate = ?, 
    reportedtime = ?, 
    drunavailable = ?, 
    reportstatus = ?, 
    drunavailablereason = ?, 
    jointworkby = ?, 
    prescriptionvalue = ? 
    WHERE wp_id = ?");

$strSQL->execute([
    $latitude, $longitude, $address, $c_date, $c_time, 
    $drunavailable, $drunavailable, $drunavailablereason, 
    $jointworkby, $prescriptionvalue, $wp_id
]);

// 2. Fetch the target ID and Type (Doctor or Chemist)
$sql = $je->prepare("SELECT wp_dc_id, wp_dc FROM tbl_work_plan WHERE wp_id = ?");
$sql->execute([$wp_id]);
$planInfo = $sql->fetch(PDO::FETCH_ASSOC);

if ($planInfo) {
    $dr_id = $planInfo['wp_dc_id'];
    $wp_dc = $planInfo['wp_dc']; 

    // 3. Logic to update Doctor's coordinates if missing/0.0
    if ($wp_dc === 'D') { // Ensure this is a doctor visit
        $checkDrLoc = $je->prepare("SELECT dr_latitude, dr_longitude FROM doctors WHERE id = ?");
        $checkDrLoc->execute([$dr_id]);
        $drLoc = $checkDrLoc->fetch(PDO::FETCH_ASSOC);

        if ($drLoc) {
            $dr_lat = (float)$drLoc['dr_latitude'];
            $dr_lng = (float)$drLoc['dr_longitude'];

            // Check if coordinates are empty or exactly 0.0
            if (empty($drLoc['dr_latitude']) || empty($drLoc['dr_longitude']) || $dr_lat == 0.0 || $dr_lng == 0.0) {
                $updateDr = $je->prepare("UPDATE doctors SET dr_latitude = ?, dr_longitude = ? WHERE id = ?");
                $updateDr->execute([$latitude, $longitude, $dr_id]);
            }
        }
    }

    // 4. Update dropenforschedule if doctor was available
    if ($drunavailable == 0) {
        $strSQL2 = $je->prepare("UPDATE dropenforschedule SET status = '1' WHERE drid = ?");
        $strSQL2->execute([$dr_id]);
    }
}
?>