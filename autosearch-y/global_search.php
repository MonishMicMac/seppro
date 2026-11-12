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

//$query = 'SELECT pincode,customer_name,area_id FROM  tbl_customer_master  WHERE (customer_name LIKE "%'.$user_input.'%" OR pincode LIKE "%'.$user_input.'%")';
$query = 'SELECT tbl_customer_master.shop_name, tbl_customer_master.pincode, tbl_customer_master.area_id, pincode_list.id, tbl_customer_master.id, pincode_list.area_name FROM  tbl_customer_master, pincode_list  WHERE tbl_customer_master.shop_name LIKE "%'.$user_input.'%" OR tbl_customer_master.pincode LIKE "%'.$user_input.'%" AND pincode_list.id=tbl_customer_master.area_id group by tbl_customer_master.shop_name,tbl_customer_master.pincode order by tbl_customer_master.shop_name';

$recSql = mysql_query($query);
$cout = mysql_num_rows($recSql);
if($cout > 0){
while($recResult = mysql_fetch_assoc($recSql)) {

  $json_arr["id"] = $recResult['id'];
  $json_arr["value"] = $recResult['pincode']."-".$recResult['shop_name']."-".$recResult['area_name'];
  $json_arr["label"] = $recResult['pincode']."-".$recResult['shop_name']."-".$recResult['area_name'];
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
mysql_close($link);
?>