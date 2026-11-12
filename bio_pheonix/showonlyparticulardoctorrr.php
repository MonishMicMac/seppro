<?php
// Include the database connection file
include("connect24.php");

// Define the memory limit (this is still fine to use as is)
define('WP_MEMORY_LIMIT', '512M');

// Get the rep_id from the request
$repid = $_REQUEST['repid'];

// Sanitize input to prevent SQL injection
$repid = mysqli_real_escape_string($con, $repid);

// SQL query to fetch data
$strSQL = "SELECT * FROM doctors WHERE rep_id='$repid'";

// Execute the query using mysqli_query
$objQuery = mysqli_query($con, $strSQL);

// Check if the query was successful
if (!$objQuery) {
    die('Error executing query: ' . mysqli_error($con));
}

// Initialize an empty array to hold the results
$antony = array();

// Fetch the results as an associative array
while ($row = mysqli_fetch_assoc($objQuery)) {
    // Add each row to the result array
    $antony[] = $row;
}

// Close the database connection
mysqli_close($con);

// Set the content type to JSON
header('Content-Type: application/json');

// Debug: Check if there are any UTF-8 issues
// Loop through the array and encode each value as UTF-8 if necessary
foreach ($antony as &$item) {
    foreach ($item as &$value) {
        // Ensure the value is UTF-8 encoded
        $value = utf8_encode($value);
    }
}

// Try encoding the result array as JSON
$jsonResult = json_encode($antony);

// Check if there was a JSON encoding error
if (json_last_error() != JSON_ERROR_NONE) {
    die('JSON encoding error: ' . json_last_error_msg());
}

// Send the JSON response
echo $jsonResult;
?>
