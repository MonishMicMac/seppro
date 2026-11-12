<?php
include("../connect23.php"); 

mysql_select_db("bio_pheonix");

$repid = isset($_REQUEST['repid']) ? $_REQUEST['repid'] : '';
$feedbackdate = isset($_REQUEST['feedbackdate']) ? $_REQUEST['feedbackdate'] : '';
$reason = isset($_REQUEST['reason']) ? $_REQUEST['reason'] : '';

// 1. Validator: Ensure mandatory input parameters are provided
if ($repid == '' || $feedbackdate == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID and Feedback Date are required parameters.",
       // "data" => (object)array()
    ));
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$c_date = date('Y-m-d');
$c_time = date("H:i:s");

// Check if feedback already exists for the specific day
$antony = mysql_query("SELECT * FROM dayfeedback WHERE repid= '$repid' AND feedbackdate= '$feedbackdate'") or die(mysql_error());
$antony_count = mysql_num_rows($antony);

if ($antony_count > 0) {
    // Action Case A: Update existing transaction record
    mysql_query("UPDATE dayfeedback SET reason='$reason', cdate='$c_date', ctime='$c_time' WHERE repid='$repid' AND feedbackdate='$feedbackdate'") or die(mysql_error());
    
    $response = array(
        "status" => true,
        "message" => "Day feedback updated successfully.",
       // "data" => (object)array()
    );
} else {
    // Action Case B: Insert new transaction tracking record
    mysql_query("INSERT INTO dayfeedback(repid, reason, feedbackdate, cdate, ctime) VALUES ('$repid', '$reason', '$feedbackdate', '$c_date', '$c_time')") or die(mysql_error());
    
    $response = array(
        "status" => true,
        "message" => "Day feedback submitted successfully.",
      //  "data" => (object)array()
    );
}

// 2. Structured Output Execution Presentation Layer Block
echo json_encode($response);
?>