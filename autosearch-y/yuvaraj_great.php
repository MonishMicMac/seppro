<?php
/*====================== Database Connection Code Start Here ======================= */
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

/*====================== Database Connection Code End Here ========================== */

// Here, we will get user input data and trim it, if any space in that user input data
//echo $_GET["our_cust_id"];

$y = explode("Y",$_GET["dist_cust_id"]);

mysql_query("UPDATE distributor_customer SET our_cust_id = ".$_GET["our_cust_id"]." WHERE id = $y[1]");

$SQL=mysql_query("SELECT state_id,district_id,pin_id,rep_id,area_id FROM tbl_customer_master WHERE id=".$_GET["our_cust_id"]."");
$RS=mysql_fetch_object($SQL);

mysql_query("UPDATE areawise_temp SET our_cust_id = '".$_GET["our_cust_id"]."', state_id='".$RS->state_id."',district_id='".$RS->district_id."',pin_id='".$RS->pin_id."',rep_id='".$RS->rep_id."',area_id='".$RS->area_id."' WHERE dist_cust_id = '".$y[1]."'");
?>