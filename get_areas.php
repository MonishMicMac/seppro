<?php
include("include/connect.php");

// Get the district ID sent by the AJAX request
$dist_id = isset($_GET['dist_id']) ? $_GET['dist_id'] : '';

// Always start with a blank option
echo '<option value="">--Select--</option>';

if (!empty($dist_id)) {
    // Escape the district ID to prevent basic SQL injection issues
    $dist_id = mysql_real_escape_string($dist_id);
    
    // Fetch areas that match the district ID using your pincode_list table structure
    $query = mysql_query("SELECT id, area_name FROM pincode_list WHERE dist_id = '$dist_id' ORDER BY area_name ASC");
    
    if ($query && mysql_num_rows($query) > 0) {
        while ($row = mysql_fetch_array($query)) {
            echo '<option value="' . $row['id'] . '">' . $row['area_name'] . '</option>';
        }
    }
}
?>