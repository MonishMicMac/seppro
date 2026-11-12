<?php

include("../connect23.php");

mysql_select_db("bio_pheonix");


$imeino = isset($_REQUEST['rep_imeino']) ? $_REQUEST['rep_imeino'] : '';
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';


if ($imeino == '' || $password == '') {
    echo json_encode(array(
        "status" => false, 
        "message" => "IMEI number and password are required.",
        //"data" => (object)array()
    ));
    mysql_close($con);
    exit;
}

// Fetch id, password AND rep_id to check status
$check_user_sql = mysql_query("SELECT id, rep_id, password FROM representative WHERE rep_imeino='$imeino'");
$user_row = mysql_fetch_array($check_user_sql);

if (!$user_row) {
    echo json_encode(array(
        "status" => false, 
        "message" => "User not found.",
        //"data" => (object)array()
    ));
    mysql_close($con);
    exit;
}

//  Verify Password
if ($user_row['password'] !== $password) {
    echo json_encode(array(
        "status" => false, 
        "message" => "Password wrong.",
       // "data" => (object)array()
    ));
    mysql_close($con);
    exit;
}

// --- NEW VALIDATION: Allow ONLY if rep_id column is 0 ---
if ((int)$user_row['rep_id'] !== 0) {
    echo json_encode(array(
        "status" => false, 
        "message" => "Access denied. Only representatives are allowed.",
    ));
    mysql_close($con);
    exit;
}
// --------------------------------------------------------

// Proceed with your original logic if login is successful
$rep_id = $user_row['id'];

date_default_timezone_set("Asia/Kolkata");
$date = date('Y-m-d');
$full_date = date("Y-m-d", strtotime($date));
$dt = explode("-", $full_date);
$datr = $dt[0] . "-" . $dt[1] . "-";

$jj = mysql_query("SELECT * FROM visitsplit WHERE repid= '$rep_id' AND v1first LIKE '%" . $datr . "%' AND v2first LIKE '%" . $datr . "%' AND v1last LIKE '%" . $datr . "%'") or die(mysql_error());
$jj_count = mysql_num_rows($jj);

if ($jj_count > 0) {
    $row = mysql_fetch_array($jj);
    $v1_first = $row['v1first'];
    $v1_last = $row['v1last'];
    $v2_first = $row['v2first'];
    $v2_last = $row['v2last'];
} else {
    $no_of_days = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($full_date)), date("Y", strtotime($full_date)));
    $date_prefix = date("Y-m", strtotime($full_date));

    $i = 1;
    $j = 0;
    while ($i <= 31) {
        $day = date("l", strtotime($date_prefix . '-' . $i));
        if ($j <= $no_of_days && $day != 'Sunday') {
            $auto_date = date("Y-m-d", strtotime($date_prefix . '-' . $i));
            $jj_check = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$rep_id' AND expenses = 'others'") or die(mysql_error());
            if (mysql_num_rows($jj_check) == 0) {
                $month1 = date("m", strtotime($date_prefix . '-' . $i));
                $month2 = date("m", strtotime($full_date));
                if ($month1 == $month2) {
                    $j++;
                }
            }
        }
        $i++;
    }

    if ($j % 2 == 0) {
        $total = $j;
    } else {
        $total = $j - 1;
    }

    $tot1 = $total / 2;

    $i1 = 1;
    $j1 = 1;
    while ($i1 <= 31) {
        $day1 = date("l", strtotime($date_prefix . '-' . $i1));
        if ($j1 <= $tot1 && $day1 != 'Sunday') {
            $auto_date1 = date("Y-m-d", strtotime($date_prefix . '-' . $i1));
            $jj1 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date1' AND repid= '$rep_id' AND expenses = 'others'") or die(mysql_error());
            if (mysql_num_rows($jj1) == 0) {
                $v1_date = $auto_date1;
                $j1++;
            }
        }
        $i1++;
    }

    $i2 = date('d', strtotime($v1_date . ' +1 day'));
    $j2 = 1;
    while ($i2 <= 31) {
        $day2 = date("l", strtotime($date_prefix . '-' . $i2));
        if ($j2 <= $tot1 + 1 && $day2 != 'Sunday') {
            $auto_date2 = date("Y-m-d", strtotime($date_prefix . '-' . $i2));
            $jj2 = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date2' AND repid= '$rep_id' AND expenses = 'others'") or die(mysql_error());
            if (mysql_num_rows($jj2) == 0) {
                $v2_date = $auto_date2;
                $j2++;
            }
        }
        $i2++;
    }

    $v1_first = date('Y-m', strtotime($full_date)) . '-01';
    $v1_last = $v1_date;
    $v2_first = date('Y-m-d', strtotime($v1_last . ' +1 day'));
    $v2_last = $v2_date;

    mysql_query("INSERT INTO visitsplit(v1first,v1last,v2first,v2last,repid) VALUES ('$v1_first','$v1_last','$v2_first','$v2_last','$rep_id')") or die(mysql_error());
}

$sqsl = mysql_query("SELECT GROUP_CONCAT(managerid) DID FROM managerjoinworkplans WHERE repid='$rep_id' AND date='" . date('Y-m-d') . "'");
$row = mysql_fetch_array($sqsl);
$bfgrt = $row['DID'];

if (!empty($bfgrt)) {
    $sqsl1 = mysql_query("SELECT GROUP_CONCAT(rep_name) DIDss FROM representative WHERE `id` IN ($bfgrt)");
    $row1 = mysql_fetch_array($sqsl1);
    $bfgrt1 = $row1['DIDss'];
} else {
    $bfgrt1 = 'INDIVIDUAL WORK';
}

if (strlen($bfgrt1) == '0' || empty($bfgrt1)) {
    $bfgrt1 = 'INDIVIDUAL WORK';
}

$sqsl1ss = mysql_query("SELECT GROUP_CONCAT(managerid) DIDssss FROM assigningreptomanager WHERE repid='$rep_id'");
$row1ss = mysql_fetch_array($sqsl1ss);
$bfgrt1ss = ',' . $row1ss['DIDssss'] . ',';

if (strlen($bfgrt1ss) == '2' || $bfgrt1ss == ',,') {
    $bfgrt1ss = ',0,';
}

// Full query block matching column structure
$strSQL = "SELECT 
    `id`, `mark_id`, `rep_id`, `rep_pwd`, `rep_name`, `rep_imeino`, `rep_imeino1`, `rep_loginstatus`, 
    `father_name`, `id_proof`, `sex`, `id_proof_num`, `address`, `doj`, `dob`, `blood_group`, 
    `mobile`, `alternate_no`, `email`, `district_id`, `area_id`, `image`, `status`, `reporting_manager`, 
    `rep_hq_wages`, `rep_ex_wages`, `rep_out_wages`, `c_date`, `c_time`, `rep_lat`, `rep_long`, 
    `lastdate`, `lasttime`, `waiting`, `repcurrentstatus`, `rep_activatedeactivate`, `manorrep`, 
    `dateoftourplan`, `admincontral`, `adminon`, `supportnumber`, `version`, `playurl`, `manager_version`, 
    `manager_playurl`, `stateid`, `completedmstteritory`, `oldversionusing`, `blockopeningmonth`, 
    `welcomewishes`, `welcomeclose`, `welcomeurl`, `smsreportingnumber`, `extravisitallowed`, 
    `deleteopen`, `managertourplanopen`, `managermoth`, `manageryear`, `emailidtosend`, `opendrdelte`, 
    `imei_no`, `manager_or_not`, `division_id`, `emp_code`, `headquarter_id`, `sales_credit`, 
    `sales_store`, `rdist_id`, `temp_password`, `cc1`, `reset_date_time`, `r_status`, `tertiary_id`, 
    `pin_id`, `rep_teritary_kms`, `rep_teritary_fare`, `rep_teritary_allowance`, `pin_amt`, `hq_id`, 
    `user_group_id`, `rep_grade`, `session_limit`, `rep_order`, `designation`, `login_status`, `password` 
FROM `representative` WHERE rep_imeino='$imeino'";

$objQuery = mysql_query($strSQL);
$intNumField = mysql_num_fields($objQuery);

$resultData = (object)array();

// Get the single profile object directly instead of running a multi-row loop array
if ($obResult = mysql_fetch_array($objQuery)) {
    $arrCol = array();
    for ($i = 0; $i < $intNumField; $i++) {
        $arrCol[mysql_field_name($objQuery, $i)] = $obResult[$i];
    }
    
    // Inject custom properties directly into the profile row
    $arrCol['v1'] = $v1_first;
    $arrCol['v2'] = $v2_first;
    $arrCol['names'] = $bfgrt1;
    $arrCol['jw'] = $bfgrt1ss;
    
    $resultData = (object)$arrCol;
}

mysql_close($con);

// Encapsulate structure with data directly matching an object mapping
$response = array(
    "status" => true,
    "message" => "Login successful",
    "data" => $resultData
);

echo json_encode($response);
?>