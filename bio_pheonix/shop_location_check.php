<?php
$user="root";
$pass="$3pp60@2016";
$database="bio_pheonix";
$con=mysql_connect("localhost", $user, $pass)
or die ('Couldnt connect to server');
mysql_select_db($database,$con)
or die('could not connect to db');

// Check database connection
if (!$con) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysql_error()]));
}

// Get parameters and escape them for safety
$rep_id = mysql_real_escape_string($_REQUEST['rep_id']);
$shop_id = mysql_real_escape_string($_REQUEST['shop_id']);
$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];


if (!$rep_id || !$shop_id || !$lat || !$long) {
    die(json_encode(["status" => "error", "message" => "Missing required parameters."]));
}

// Convert lat & long to float
$lat = floatval($lat);
$long = floatval($long);

// FIX: Added parentheses around the OR condition. Changed doctors_test to doctors.
$query = "SELECT dr_latitude, dr_longitude FROM doctors WHERE id = '$shop_id' AND (rep_assign='$rep_id' OR rep_id='$rep_id') ORDER BY id DESC LIMIT 1";
$result = mysql_query($query, $con);

if (!$result || mysql_num_rows($result) == 0) {
    die(json_encode(["status" => "error", "message" => "Invalid shop_id or you are not assigned to this shop."]));
} else {
    $shop_data = mysql_fetch_assoc($result);
    $expected_lat = floatval($shop_data['dr_latitude']);
    $expected_long = floatval($shop_data['dr_longitude']);
    
    // Case 1: Shop has no location set yet. Capture current location and allow check-in.
    if (empty($shop_data['dr_latitude']) || is_null($shop_data['dr_latitude']) || empty($shop_data['dr_longitude']) || is_null($shop_data['dr_longitude']) || $expected_lat == 0 || $expected_long == 0) {

        // FIX: Added parentheses to the UPDATE query's WHERE clause
        $updatelatlong_query = "UPDATE doctors SET dr_latitude = '$lat', dr_longitude = '$long' WHERE id = '$shop_id' AND (rep_assign='$rep_id' OR rep_id='$rep_id')";
        $updateresult = mysql_query($updatelatlong_query, $con);
        
        echo json_encode(["status" => "true", "message" => "User is at the correct shop location. Check-in allowed"]);
    
    } else {
        // Case 2: Shop has a location. Check distance.
        function haversineDistance($lat1, $lon1, $lat2, $lon2)
        {
            $earth_radius = 6371000; // Earth's radius in meters

            $lat_diff = deg2rad($lat2 - $lat1);
            $long_diff = deg2rad($lon2 - $lon1);

            $a = sin($lat_diff / 2) * sin($lat_diff / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($long_diff / 2) * sin($long_diff / 2);

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            return $earth_radius * $c; // Distance in meters
        }
        
        $distance = haversineDistance($lat, $long, $expected_lat, $expected_long);

        if ($distance > 50) {
            die(json_encode([
                "status" => "false",
                "message" => "You are " . round($distance, 2) . " meters away from the shop. Please move closer to check in."
            ]));
        } else {
            echo json_encode(["status" => "true", "message" => "User is at the correct shop location. Check-in allowed"]);
        }
    }
}

// Close connection
mysql_close($con);
?>