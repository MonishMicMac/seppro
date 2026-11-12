<?php
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

$PTR = mysql_query("SELECT * FROM pincode_list WHERE pin_id=".$_GET["pin"]." GROUP BY pin_id");
$A = mysql_fetch_object($PTR);

mysql_query("INSERT INTO  tbl_customer_master(pin_id,shop_name,customer_name,mobile_no,drug_lincense_no1,drug_lincense_no2,customer_address,chemist_latitude,chemist_longtitude,rep_id,state_id,district_id,pincode,area_id) VALUES('".$_GET["pin"]."','".$_GET["sname"]."','".$_GET["cname"]."','".$_GET["cno"]."','".$_GET["drug"]."','".$_GET["drug1"]."','".$_GET["address1"]."','".$_GET["latitude1"]."','".$_GET["longitude1"]."','0','".$A->state_id."','".$A->dist_id."','".$A->pincode."','".$A->id."')");

echo "NEW CHEMIST ADDED!!!";

?>