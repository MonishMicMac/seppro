<?php
// Include the database connection file
include("connect24.php"); 

// Get the rep_id from the request (make sure to sanitize the input)
$wp_rep_id = $_REQUEST['rep_id'];

// Sanitize the input to avoid SQL injection (example using mysqli_real_escape_string)
$wp_rep_id = mysqli_real_escape_string($con, $wp_rep_id);

// SQL query to fetch data
$strSQL = "SELECT * FROM doctors WHERE rep_assign='$wp_rep_id' ORDER BY doctor_name ASC";

// Execute the query
$objQuery = mysqli_query($con, $strSQL);

// Check if the query was successful
if (!$objQuery) {
    die('Error executing query: ' . mysqli_error($con));
}

// Initialize an empty array to hold the results
$resultArray = array();

// Fetch the results as an associative array and convert each field to UTF-8
while ($obResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
    // Convert each value in the associative array to UTF-8
    foreach ($obResult as $key => $value) {
        $obResult[$key] = utf8_encode($value);
    }
    
    // Add the result to the array
    $resultArray[] = $obResult; 
}

// Close the connection
mysqli_close($con);

// Ensure the content type is set to JSON
header('Content-Type: application/json');

// Check if there's any issue with JSON encoding
if (json_last_error() != JSON_ERROR_NONE) {
    echo "JSON encoding error: " . json_last_error_msg();
} else {
    // Encode the result array as JSON and send it to the client
    echo json_encode($resultArray);
}
?>
