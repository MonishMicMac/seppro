<?php
include("../connect23.php"); 

mysql_select_db("bio_pheonix");

// if (isset($_REQUEST['repid']) && $_REQUEST['repid'] != '') {
//     $repid = $_REQUEST['repid'];
// } else

if (isset($_REQUEST['rep_id']) && $_REQUEST['rep_id'] != '') {
    $repid = $_REQUEST['rep_id'];
} else {
    $repid = '';
}

$leaveapplieddate = isset($_REQUEST['leaveapplieddate']) ? $_REQUEST['leaveapplieddate'] : '';
$reason = isset($_REQUEST['reason']) ? $_REQUEST['reason'] : '';
$expenses = isset($_REQUEST['expenses']) ? $_REQUEST['expenses'] : '';

if ($repid == '' || $leaveapplieddate == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID and Leave Applied Date are required parameters.",
        "data" => (object)array()
    ));
    exit;
}

date_default_timezone_set("Asia/Kolkata");
$c_date = date('Y-m-d');
$c_time = date("H:i:s");

$antony = mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'") or die(mysql_error());
$antony_count = mysql_num_rows($antony);

if ($antony_count > 0) {
    mysql_query("UPDATE repgivenasleave SET reason='$reason', expenses='$expenses', date='$c_date', time='$c_time' WHERE repid= '$repid' AND leaveapplieddate='$leaveapplieddate'") or die(mysql_error());
    
    $response = array(
        "status" => true,
        "message" => "Application record updated successfully.",
        //"data" => (object)array()
    );
} else {
    mysql_query("INSERT INTO repgivenasleave(repid, leaveapplieddate, reason, expenses, date, time) VALUES ('$repid', '$leaveapplieddate', '$reason', '$expenses', '$c_date', '$c_time')") or die(mysql_error());

    $response = array(
        "status" => true,
        "message" => "Application submitted successfully.",
       // "data" => (object)array()
    );

    if ($expenses == 'leave') {
        $jjrepname = mysql_query("SELECT rep_name FROM representative WHERE id = '$repid'") or die(mysql_error());
        $jjrename_res = mysql_fetch_array($jjrepname);

        $leaverepid = $repid;
        $repname = isset($jjrename_res['rep_name']) ? $jjrename_res['rep_name'] : '';
        $leavedate = $leaveapplieddate;
        $leavereason = 'leave';

        $a = mysql_query("SELECT assigningreptomanager.`managerid`, gcm_users.gcm_regid, gcm_users.name FROM `assigningreptomanager`, gcm_users WHERE assigningreptomanager.`repid`='$repid' AND `assigningreptomanager`.managerid=gcm_users.name") or die(mysql_error());

        while ($jj = mysql_fetch_array($a)) {
            $gcmlen = strlen($jj['gcm_regid']);
            if ($gcmlen >= 5) {
                $regId = $jj['gcm_regid'];
                $message_str = $leaverepid . "," . $leavedate . "," . $leavereason . "," . $repname;
                 
                if (file_exists('./GCM.php')) {
                    include_once './GCM.php';
                } else {
                    include_once '../GCM.php';
                }
                 
                if (class_exists('GCM')) {
                    $gcm = new GCM();
                    $registatoin_ids = array($regId);
                    $message_payload = array("price" => $message_str);
                    
                    @$gcm->send_notification($registatoin_ids, $message_payload);
                }
            }
        }
    }
}

echo json_encode($response);
?>