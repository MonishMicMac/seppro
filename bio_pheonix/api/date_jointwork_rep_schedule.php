<?php
include("../connect23.php"); 

mysql_select_db("bio_pheonix");

date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');

$repid = isset($_REQUEST['repid']) ? $_REQUEST['repid'] : '';
$managerid = isset($_REQUEST['managerid']) ? $_REQUEST['managerid'] : '';
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : '';

if ($repid == '' || $managerid == '' || $date == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID(s), Manager ID, and Date are required parameters.",
        "data" => (object)array()
    ));
    exit;
}

$inserted_count = 0;
$skipped_count = 0;

if (strpos($repid, ',') !== FALSE) {
    $exp = explode(',', $repid);
    $count = count($exp);

    for ($i = 0; $i < $count; $i++) {
        $current_rep = trim($exp[$i]);
        if ($current_rep == '') continue;

        $jj = mysql_query("SELECT * FROM managerjoinworkplans WHERE repid= '$current_rep' AND managerid= '$managerid' AND date= '$date'") or die(mysql_error());
        $jj_count = mysql_num_rows($jj);

        if ($jj_count > 0) {
            $skipped_count++;
        } else {
            mysql_query("INSERT INTO managerjoinworkplans(repid,managerid,date,cdate) VALUES ('$current_rep','$managerid','$date','$cdate')") or die(mysql_error());
            $inserted_count++;
        }
    }
} else {
    $jj = mysql_query("SELECT * FROM managerjoinworkplans WHERE repid= '$repid' AND managerid= '$managerid' AND date= '$date'") or die(mysql_error());
    $jj_count = mysql_num_rows($jj);

    if ($jj_count > 0) {
        $skipped_count++;
    } else {
        mysql_query("INSERT INTO managerjoinworkplans(repid,managerid,date,cdate) VALUES ('$repid','$managerid','$date','$cdate')") or die(mysql_error());
        $inserted_count++;
    }
}

if ($inserted_count > 0) {
    $message = "Work plans saved successfully. Saved: $inserted_count record(s).";
    if ($skipped_count > 0) {
        $message .= " Skipped $skipped_count existing duplicate entry(ies).";
    }
    
    $response = array(
        "status" => true,
        "message" => $message,
        "data" => (object)array()
    );
} else {
    $response = array(
        "status" => true, 
        "message" => "Work plans already exists for the given criteria. Skipped: $skipped_count entry(ies).",
        "data" => (object)array()
    );
}

echo json_encode($response);
?>