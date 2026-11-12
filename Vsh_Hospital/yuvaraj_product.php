<?php
/*====================== Database Connection Code Start Here ======================= */
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

/*====================== Database Connection Code End Here ========================== */

// Here, we will get user input data and trim it, if any space in that user input data
//echo $_GET["our_cust_id"];

$y = explode("Y",$_GET["dist_cust_id"]);

$priya = "SELECT state_id FROM areawise_temp WHERE dist_prod_id ='".$y[1]."' order by id desc limit 1";
$prod_pri = mysql_query($priya); 

// 
$err_chk = 0;
if(mysql_num_rows($prod_pri)) {

	$err_chk = 1;

	$hpri = mysql_fetch_object($prod_pri);
	$state_id = $hpri->state_id;


	//$sql=mysql_query("SELECT batch,batch_ptr,batch_pts FROM mst_batchdetails WHERE product_id='".$_GET["our_cust_id"]."' ORDER BY batch_id DESC LIMIT 0,1");
	$sql=mysql_query("SELECT a.batch as batch, b.ptr as batch_ptr, b.pts as batch_pts FROM mst_batchdetails a left join tbl_statewise_product_price b on a.batch=b.batch_id WHERE a.product_id='".$_GET["our_cust_id"]."' and b.state_id='".$state_id."' order by a.batch_id, b.id desc limit 1");
	$row=mysql_fetch_array($sql);

}

	$priya1 = "SELECT division_id FROM product WHERE id ='".$_GET["our_cust_id"]."'";
	$prod_pri1 = mysql_query($priya1); 
	$hpri1 = mysql_fetch_object($prod_pri1);
	$division_id = $hpri1->division_id;

mysql_query("UPDATE dist_prod SET our_id = ".$_GET["our_cust_id"].", division_id='".$division_id."' WHERE id = $y[1]");

//secondary
if($err_chk==1)
mysql_query("UPDATE areawise_temp SET our_product_id='".$_GET["our_cust_id"]."',division_id='".$division_id."',batch_id='".$row['batch']."',ptr='".$row['batch_ptr']."',pts='".$row['batch_pts']."' WHERE dist_prod_id='".$y[1]."'");

//primary
mysql_query("UPDATE primary_sales SET product_id='".$_GET["our_cust_id"]."',division_id='".$division_id."' WHERE distributor_product_id='".$y[1]."'");

# SHARING PINCODE - START
$PIN_ID = mysql_query("SELECT IFNULL(areawise_temp.pin_id,0) PINID FROM areawise_temp,pincode_list WHERE areawise_temp.dist_prod_id=$y[1] AND areawise_temp.pin_id = pincode_list.pin_id and pincode_list.product_sharing = 1");
while($PIN=mysql_fetch_object($PIN_ID)){
	if($PIN->PINID>0){
		$Existing_Pin = mysql_query("SELECT * FROM tbl_product_sharing WHERE sharing_productid=".$_GET["our_cust_id"]." AND sharing_pinid=".$PIN->PINID."");
		$CNTY = mysql_num_rows($Existing_Pin);
		if($CNTY>0){
			$E_PIN = mysql_fetch_object($Existing_Pin);
			$REP = $E_PIN->sharing_repid;
			$HQID1 = mysql_query("SELECT headquarter_id FROM representative WHERE id = ".$E_PIN->sharing_repid."");
			$HQ1 = mysql_fetch_object($HQID1);
			mysql_query("UPDATE areawise_temp SET rep_id='".$REP."',hq_id=".$HQ1->headquarter_id." WHERE dist_prod_id=$y[1]");
		}	
	}
}
# SHARING PINCODE - END

?>