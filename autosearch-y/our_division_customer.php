<?php
	include("connect_db.php");
	
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
	
	if(isset($_GET["pincode"])){
		//if(){}
		$EXISTING = mysql_query("SELECT * FROM tbl_customer_master WHERE pincode='".$_GET["pincode"]."' AND shop_name='".$_GET["customer"]."'");
		$E = mysql_num_rows($EXISTING);
		if($E==0){
		$SQL = mysql_query("SELECT pin_id,state_id,district_id,pincode FROM master_pincode WHERE pincode='".$_GET["pincode"]."'");
		$CNT = mysql_num_rows($SQL);
		if($CNT>0){			
			$RS = mysql_fetch_object($SQL);
			// REP ID - START
			$REP = mysql_query("SELECT rep_id FROM rep_area WHERE pin_id = '".$RS->pin_id."'");
			$C = mysql_num_rows($REP);
			if($C>0){
				$R = mysql_fetch_object($REP);
				$REP_ID = $R->rep_id;
			}
			if($C==0){$REP_ID = 0; }
			// REP ID - END
			
			// AREA ID - START
			$AREA = mysql_query("SELECT id FROM pincode_list WHERE pin_id = '".$RS->pin_id."' GROUP BY pin_id");
			$A = mysql_fetch_object($AREA);
			// AREA ID - END
			
			mysql_query("INSERT INTO tbl_customer_master(shop_name,rep_id,pin_id,state_id,district_id,pincode,area_id,c_date,c_time) VALUES('".$_GET["customer"]."','".$REP_ID."','".$RS->pin_id."','".$RS->state_id."','".$RS->district_id."','".$_GET["pincode"]."','".$A->id."','".date("Y-m-d")."','".date("H:i:s")."')");
			
			echo "CUSTOMER ADDED IN YOUR DIVISION.";
		}
		if($CNT==0){
			echo "PINCODE NOT IN YOUR DIVISION. CONTACT mic&amp;Mac TEAM...";
		}
		}
		if($E>0){ echo "CUSTOMER ALREADY EXIST!!!"; }
	}
	
?>