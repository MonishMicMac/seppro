<?php
/*====================== Database Connection Code Start Here ======================= */
include("connect_db.php");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

/*====================== Database Connection Code End Here ========================== */

// Here, we will get user input data and trim it, if any space in that user input data
//echo $_GET["our_cust_id"];

$y = explode("Y",$_GET["dist_cust_id"]);

$sql=mysql_query("SELECT batch,batch_ptr,batch_pts FROM mst_batchdetails WHERE product_id='".$_GET["our_cust_id"]."' ORDER BY batch_id DESC LIMIT 0,1");
$row=mysql_fetch_array($sql);

mysql_query("UPDATE dist_prod SET our_id = ".$_GET["our_cust_id"]." WHERE id = $y[1]");

mysql_query("UPDATE areawise_temp SET our_product_id='".$_GET["our_cust_id"]."',batch_id='".$row['batch']."',ptr='".$row['batch_ptr']."',pts='".$row['batch_pts']."' WHERE dist_prod_id=$y[1]");

?>