<?php
// Use mysqli instead of the deprecated mysql extension
$con = mysqli_connect("localhost", "root", "$3pp60@2016", "bio_pheonix");

// Check if the connection is successful
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$pid = $_REQUEST['pid'];

$strSQL = "SELECT id, doc_contact_no, doctor_name, doc_pincode, dr_latitude, dr_longitude, doc_qualification, doc_specilist_id, 
                doc_hospital_clinic_name, visitcardclinicphoto, doc_specific, time_specific, dob, anniversary, doc_gender, 
                applyforedit, onetimeallowforrep, c_date, c_time, managerapprovestatus, dob, doctor_addrs, favourite, 
                swid, territory 
           FROM doctors 
           WHERE rep_assign='$pid' 
           ORDER BY doctors.doctor_name ASC";

$objQuery = mysqli_query($con, $strSQL);

// Check if query executed successfully
if (!$objQuery) {
    die("Query failed: " . mysqli_error($con));
}

$intNumField = mysqli_num_fields($objQuery);
$resultArray = array();

// Fetch data and build the result array
while ($obResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
    // Convert each value in the row to UTF-8 if not already
    array_walk($obResult, function (&$value) {
        // Convert value to UTF-8 if it's not already UTF-8
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    });
    $resultArray[] = $obResult;
}

// Close the connection
mysqli_close($con);

// Convert to JSON and handle errors
$jsonResult = json_encode($resultArray, JSON_UNESCAPED_UNICODE);

// Check if encoding was successful
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON encoding failed: " . json_last_error_msg());
}

// Output JSON data
echo $jsonResult;
?>
