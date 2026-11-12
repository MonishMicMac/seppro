<?php
include("../connect23.php");

mysql_select_db("bio_pheonix");

$rep_id = isset($_REQUEST['rep_id']) ? $_REQUEST['rep_id'] : '';

if ($rep_id == '') {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative ID is required.",
        "data" => (object)array()
    ));
    exit;
}

$year = date('Y-m-');

$jjreprmgr = mysql_query("SELECT rep_id FROM representative WHERE id='$rep_id'") or die(mysql_error()); 
$jjreprmgr_res = mysql_fetch_array($jjreprmgr);

if (!$jjreprmgr_res) {
    echo json_encode(array(
        "status" => false,
        "message" => "Representative not found.",
        "data" => (object)array()
    ));
    exit;
}

$resultData = array();

if ($jjreprmgr_res['rep_id'] != '0') {
    // MANAGER BRANCH
    $strSQL = mysql_query("SELECT expenses, leaveapplieddate FROM repgivenasleave WHERE repid='$rep_id' AND leaveapplieddate LIKE '$year%'") or die(mysql_error());
    while ($res = mysql_fetch_array($strSQL)) {
        $leave_date = $res['leaveapplieddate'];

        $datecount = mysql_query("SELECT COUNT(wp_date) as total FROM tbl_work_plan WHERE wp_date='$leave_date' AND wp_dc='D' AND jointworkby='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
        $date_res = mysql_fetch_array($datecount);

        $datecount1 = mysql_query("SELECT COUNT(wp_date) as total FROM tbl_work_plan WHERE wp_date='$leave_date' AND wp_dc='C' AND jointworkby='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
        $date_res1 = mysql_fetch_array($datecount1);

        // Group explicitly by date string key mapping instead of standard numeric indexes (0, 1, 2)
        $resultData[$leave_date] = array(
            "expenses" => $res['expenses'],
            "leaveapplieddate" => $leave_date,
            "dr" => isset($date_res['total']) ? $date_res['total'] : "0",
            "ch" => isset($date_res1['total']) ? $date_res1['total'] : "0"
        );
    }
} else {
    // STANDARD REPRESENTATIVE BRANCH
    $strSQL = mysql_query("SELECT expenses, leaveapplieddate FROM repgivenasleave WHERE repid='$rep_id' AND leaveapplieddate LIKE '$year%'") or die(mysql_error());
    while ($res = mysql_fetch_array($strSQL)) {
        $leave_date = $res['leaveapplieddate'];

        $datecount = mysql_query("SELECT COUNT(wp_date) as total FROM tbl_work_plan WHERE wp_date='$leave_date' AND wp_dc='D' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
        $date_res = mysql_fetch_array($datecount);

        $datecount1 = mysql_query("SELECT COUNT(wp_date) as total FROM tbl_work_plan WHERE wp_date='$leave_date' AND wp_dc='C' AND wp_rep_id='$rep_id' AND attendancestatus='1' AND drunavailable='0'");
        $date_res1 = mysql_fetch_array($datecount1);

        $resultData[$leave_date] = array(
            "expenses" => $res['expenses'],
            "leaveapplieddate" => $leave_date,
            "dr" => isset($date_res['total']) ? $date_res['total'] : "0",
            "ch" => isset($date_res1['total']) ? $date_res1['total'] : "0"
        );
    }
}

if (count($resultData) > 0) {
    ksort($resultData);

    $response = array(
        "status" => true,
        "message" => "Data retrieved successfully",
        "data" => (object)$resultData 
    );
} else {
    $response = array(
        "status" => false,
        "message" => "No record tracking data available for this month",
        "data" => (object)array()
    );
}

echo json_encode($response);
?>