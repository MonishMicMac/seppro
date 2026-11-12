<?php
/*====================== Database Connection Code Start Here ======================= */

include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

/*====================== Database Connection Code End Here ========================== */

// Here, we will get user input data and trim it, if any space in that user input data
$user_input = trim($_REQUEST['term']);

// Define two array, one is to store output data and other is for display
$display_json = array();
$json_arr = array();
 

$user_input = preg_replace('/\s+/', ' ', $user_input);

//$query = 'SELECT distributor_customer.pincode,pincode_list.area_name FROM distributor_customer,tbl_customer_master,pincode_list WHERE distributor_customer.our_cust_id<>"" AND (distributor_customer.pincode LIKE "%'.$user_input.'%") AND distributor_customer.our_cust_id = tbl_customer_master.id AND tbl_customer_master.area_id = pincode_list.id GROUP BY distributor_customer.pincode ORDER BY distributor_customer.pincode, pincode_list.area_name';

$query = 'SELECT pincode FROM master_pincode WHERE pincode LIKE "%'.$user_input.'%"';

$recSql = mysql_query($query);
if(mysql_num_rows($recSql)>0){
while($recResult = mysql_fetch_assoc($recSql)) {
  $json_arr["id"] = "#";
  $json_arr["value"] = $recResult['pincode'];
  $json_arr["label"] = $recResult['pincode'];
  array_push($display_json, $json_arr);
}
} else {
  $json_arr["id"] = "#";
  $json_arr["value"] = "";
  $json_arr["label"] = "No Result Found !";
  array_push($display_json, $json_arr);
}
 
	
$jsonWrite = json_encode($display_json); //encode that search data
print $jsonWrite;
?>