<?php
/*====================== Database Connection Code Start Here ======================= */
session_start();
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

$baba = explode("-",$_GET["dd_user_input"]);

if($_GET["bill_no"]==""){
	$D = mysql_query("SELECT dis_abb FROM distributor WHERE dis_id = '".$_GET["dist"]."' ");
	$DT = mysql_fetch_object($D);
	$_GET["bill_no"]=$DT->dis_abb.rand();
}

if($_GET["bill_date"]==""){$_GET["bill_date"]=$_GET["billdate"];}

// GETTING PIN DETAILS
$SQL = mysql_query("SELECT id,rep_id,pin_id,state_id,district_id,shop_name,area_id FROM  tbl_customer_master WHERE pincode='".$baba[0]."' AND shop_name='".$baba[1]."'"); 
$Pooja = mysql_fetch_object($SQL);

// CUSTOMER ID
$CID = mysql_query("SELECT id FROM distributor_customer WHERE pincode='".$baba[0]."' AND our_cust_id='".$Pooja->id."' AND distributor_id='".$_GET["dist"]."'");
$V = mysql_fetch_object($CID);
$CNT = mysql_num_rows($CID);
if($CNT>0){ $DISTID = $V->id; }
if($CNT==0){ 
	$DCUST = mysql_query("INSERT INTO distributor_customer(our_cust_id,distributor_id,customer_name,pincode,c_date,c_time) VALUES ('".$Pooja->id."','".$_GET["dist"]."','".$baba[1]."','".$baba[0]."','".date("d/m/Y")."','".date("H:i:s")."')");
	$DISTID = mysql_insert_id();
}

// PRODUCT ID
$product=str_replace("/","+",$_GET["dd_user_input1"]);

$RPID = mysql_query("SELECT id,pro_name FROM product WHERE pro_name='$product'");
$RP = mysql_fetch_object($RPID);

$PID = mysql_query("SELECT id,our_id FROM dist_prod WHERE our_id='".$RP->id."' AND dist_id='".$_GET["dist"]."'");
$P = mysql_fetch_object($PID);

$PCNT = mysql_num_rows($PID);
if($PCNT>0){ $DISTPID = $P->id; }
if($PCNT<=0){ 
	$DCUST = mysql_query("INSERT INTO dist_prod(dist_id,pro_name,our_id,c_date,c_time) VALUES ('".$_GET["dist"]."','".$RP->pro_name."','".$RP->id."','".date("d/m/Y")."','".date("H:i:s")."')");
	$DISTPID = mysql_insert_id();
}


if($_GET["qty"]>=0){$return_analysis='S';}
if($_GET["qty"]<0){$return_analysis='R';}


$batch=''; $ptr=''; $pts=''; $nrv='';
$batch=$_GET["batch"];
$sql1=mysql_query("SELECT batch,batch_ptr, batch_pts, batch_nrv FROM mst_batchdetails WHERE batch='".$batch."' AND product_id='".$RP->id."' ORDER BY batch_id desc limit 0,1");
$row1=mysql_fetch_array($sql1);
if(mysql_num_rows($sql1) > 0){
	$batch=$row1['batch'];
	$ptr=$row1['batch_ptr'];
	$pts=$row1['batch_pts'];
	$nrv=$row1['batch_nrv'];
}

$month_date=explode(',', $_GET["bill_date"]);
// MASTER BLASTER
mysql_query("INSERT INTO areawise_temp(m_id16,dist_id,cust_name,area_name,pincode,state_id,district_id,pin_id,rep_id,dist_cust_id,our_cust_id,dist_prod_id,our_product_id,pro_name,quantity,replace_quantity,free_quantity,return_analysis,c_date,c_time,bill_no,bill_date,bill_string,area_id, ptr, pts, nrv,batch_id) VALUES ('".$_SESSION['m_id16']."','".$_GET["dist"]."','".$baba[1]."','".$baba[2]."','".$baba[0]."','".$Pooja->state_id."','".$Pooja->district_id."','".$Pooja->pin_id."','".$Pooja->rep_id."','".$DISTID."','".$Pooja->id."','".$DISTPID."','".$RP->id."','".$product."','".$_GET["qty"]."','".$_GET["rqty"]."','".$_GET["fqty"]."','".$return_analysis."','".date("d/m/Y")."','".date("H:i:s")."','".$_GET["bill_no"]."','".$month_date[0]."','".$month_date[1]."','".$Pooja->area_id."','".$ptr."','".$pts."','".$nrv."','".$batch."')");

echo mysql_error();
?>