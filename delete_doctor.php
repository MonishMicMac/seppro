<?php
// Start session to access session variables if needed
session_start();

// Include database connection
include("include/connect.php");

// Check if d_id is provided in the URL
if (!isset($_GET['d_id']) || empty($_GET['d_id'])) {
    echo "<script>alert('Invalid Doctor ID');window.location='../view_doctor_bio_pheonix.php';</script>";
    exit();
}

// Sanitize the d_id to prevent SQL injection (basic sanitization; consider using prepared statements with mysqli/PDO)
$d_id = intval($_GET['d_id']);

// Delete query
$delete_query = "DELETE FROM doctors WHERE id = '$d_id'";
$result = mysql_query($delete_query);

if ($result) {
    // Success: Record deleted
    echo "<script>alert('Doctor Deleted Successfully');window.location='../view_doctor_bio_pheonix.php';</script>";
} else {
    // Error: Display MySQL error for debugging
    echo "<script>alert('Error Deleting Doctor: " . mysql_error() . "');window.location='../view_doctor_bio_pheonix.php';</script>";
}

// Close the database connection (optional, depending on your connect.php)
mysql_close();
