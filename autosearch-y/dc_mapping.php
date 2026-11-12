<?php
/*====================== Database Connection Code Start Here ======================= */

include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

if(isset($_GET["mapping"])){
	// DOCTOR ID - START
	$DID = explode("-",$_GET["doctor_id"]);
	$DR=mysql_query("SELECT id,rep_assign,chemist_id FROM doctors WHERE doctor_name ='".$DID[1]."' AND doc_pin_id = (SELECT pin_id FROM master_pincode WHERE  pincode='".$DID[0]."')");
	$D=mysql_fetch_object($DR);
	// DOCTOR ID - END
	// CHEMIST ID - START
	$CID = explode("-",$_GET["chemist_id"]);	
	$CHY=mysql_query("SELECT id,doctor_id FROM tbl_customer_master WHERE shop_name ='".$CID[1]."' AND pin_id = (SELECT pin_id FROM master_pincode WHERE  pincode='".$CID[0]."')");
	$C=mysql_fetch_object($CHY);
	// CHEMIST ID - END
	mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,rep_id,status) VALUES('".$D->id."','".$C->id."','".$D->rep_assign."',0)");
	// DOCTOR MAPPING - START
	if($D->chemist_id==""){mysql_query("UPDATE doctors SET chemist_id='".$C->id."' WHERE id='".$D->id."'");}
	if($D->chemist_id!=""){$CHYID=$D->chemist_id.",".$C->id;mysql_query("UPDATE doctors SET chemist_id='".$CHYID."' WHERE id='".$D->id."'");}
	// DOCTOR MAPPING - END
	// CHEMIST MAPPING - START
	if($C->doctor_id==""){mysql_query("UPDATE tbl_customer_master SET doctor_id='".$D->id."' WHERE id='".$C->id."'");}
	if($C->doctor_id!=""){$DRID=$C->doctor_id.",".$D->id;mysql_query("UPDATE tbl_customer_master SET doctor_id='".$DRID."' WHERE id='".$C->id."'");}
	// CHEMIST MAPPING - END
	echo mysql_error();
	echo "DOCTOR <-> CHEMIST MAPPING!!!";
}
if(isset($_GET["doctor"])){
    $PIN=mysql_query("SELECT pin_id FROM master_pincode WHERE  pincode='".$_GET["pin"]."'");
	$P=mysql_fetch_object($PIN);
	mysql_query("INSERT INTO doctors(doctor_name,doc_pin_id,doc_pincode) VALUES('".$_GET["doctor_id"]."','".$P->pin_id."','".$_GET["pin"]."')");
	echo "NEW DOCTOR ADDED!!!";
}
if(isset($_GET["chemist"])){
	$PIN=mysql_query("SELECT pin_id FROM master_pincode WHERE  pincode='".$_GET["pin"]."'");
	$P=mysql_fetch_object($PIN);
	mysql_query("INSERT INTO tbl_customer_master(shop_name,pin_id,pincode) VALUES('".$_GET["chemist_id"]."','".$P->pin_id."','".$_GET["pin"]."')");
	echo "NEW CHEMIST ADDED!!!";
}
?>