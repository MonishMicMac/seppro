<?php
// Database connection parameters
$servername = "localhost";    // MySQL server address
$username = "root";  // Database username
$password = "$3pp60@2016";  // Database password
$dbname = "bio_pheonix";    // Database name

// Create a connection using mysqli
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
