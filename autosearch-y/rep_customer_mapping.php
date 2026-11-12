<?php
/*====================== Database Connection Code Start Here ======================= */
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

if(isset($_GET["rep_id"])){
	mysql_query("UPDATE areawise_temp SET rep_id = '".$_GET["rep_id"]."' WHERE pin_id = '".$_GET["pin_id"]."' AND rep_id=0");
	mysql_query("UPDATE tbl_customer_master SET rep_id = '".$_GET["rep_id"]."' WHERE pin_id = '".$_GET["pin_id"]."' AND rep_id=0");
}
if(isset($_GET["rep_id1"])){
	mysql_query("UPDATE areawise_temp SET rep_id = 0 WHERE pin_id = '".$_GET["pin_id"]."' AND rep_id=".$_GET["rep_id1"]."");
	mysql_query("UPDATE tbl_customer_master SET rep_id = 0 WHERE pin_id = '".$_GET["pin_id"]."' AND rep_id=".$_GET["rep_id1"]."");
}
if(isset($_GET["our_cust_id"])){
	$CUSTID = explode("Y",$_GET["cust_id"]);
	mysql_query("UPDATE areawise_temp SET rep_id = ".$_GET["our_cust_id"]." WHERE our_cust_id = '".$CUSTID[1]."'");
	mysql_query("UPDATE tbl_customer_master SET rep_id = ".$_GET["our_cust_id"]." WHERE id = '".$CUSTID[1]."'");
}

if(isset($_GET["repid"])){
	$rep = explode(",",$_GET["repid"]);
	$S = mysql_query("SELECT pin_id,district_id FROM master_pincode WHERE pincode = '".$_GET["pincode"]."'");
	$R = mysql_fetch_object($S);
	foreach($rep as $repId){
		mysql_query("INSERT INTO rep_area(pin_id,rep_id,district_id,c_date,c_time) VALUES('".$R->pin_id."','".$repId."','".$R->district_id."','".date("Y-m-d")."','".date("H:i:s")."')");
	}
}

?>