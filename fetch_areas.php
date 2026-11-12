<?php
include("include/connect.php");

if(isset($_GET['dist_id'])) {
    $dist_id = $_GET['dist_id'];
    
    // Output the select dropdown
    echo '<select name="area_id" id="area_id" required>';
    echo '<option value="">--Select Area--</option>';
    
    // Fetch areas based on the selected district
    $query = mysql_query("SELECT id, area_name FROM pincode_list WHERE dist_id = '$dist_id'") or die(mysql_error());
    
    if(mysql_num_rows($query) > 0) {
        while($row = mysql_fetch_array($query)) {
            echo '<option value="'.$row['id'].'">'.$row['area_name'].'</option>';
        }
    } else {
        echo '<option value="">No areas found</option>';
    }
    echo '</select>';
}
?>