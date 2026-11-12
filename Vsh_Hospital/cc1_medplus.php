<?php
	
	session_start();
	header("Connection: close\r\n");
	ob_start();
	header("location: medplus_cc1_report.php");
	$size = ob_get_length();
	header("Content-Length: $size");
	ob_end_flush();
	flush();
	ob_end_clean();
	include("include/connect.php");
	
	ini_set('memory_limit', '-1');
	ini_set('upload_max_filesize', '1024M');
	ini_set('post_max_size', '1024M');
	ini_set('max_input_time', 3000000);
	ini_set('max_execution_time', 1500000);
	set_time_limit(0);
	error_reporting(E_ALL);
	
	$_REQUEST["from_date"]=date("Y/m",strtotime($_REQUEST["from_date"]))."/01";
	$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
	$R_MDATE=mysql_fetch_object($MDATE);
	
	// MEDPLUS
	if(@$_REQUEST["submit"]=="CC"){	
		
		$REPRESENTATIVE = mysql_query("SELECT id,sales_credit FROM representative WHERE sales_credit>0");
		while($REP = mysql_fetch_object($REPRESENTATIVE)){
			$ProductSales=mysql_query("SELECT id,pts FROM product"); // PRODUCT DETAILS	
			while($PS=mysql_fetch_object($ProductSales)){
				$MPLUS1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE our_product_id='".$PS->id."' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id='57'");
				$MPY1=mysql_fetch_object($MPLUS1);			
				mysql_query("INSERT INTO tbl_medplus (medplus_rep_id,medplus_billdate,medplus_product_id,medplus_qty,medplus_pts) VALUES (".$REP->id.",'".date("Y/m/d",strtotime($R_MDATE->LastDay))."','".$PS->id."','".round($MPY1->Q*$REP->sales_credit/100,0)."','".$PS->pts*round($MPY1->Q*$REP->sales_credit/100,2)."')");
			}
		}
	
	}
	
	// CC1
	
	if(@$_REQUEST["submit"]=="CC1"){
		
			$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='0' and dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (".$_REQUEST["hq_name"].")) and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
			$CC=mysql_fetch_object($CommonCredit);
			// TOTAL HQ SUM
			
			$CommonCreditSTK = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (".$_REQUEST["hq_name"].")) and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (SELECT id FROM representative WHERE headquarter_id IN (".$_REQUEST["hq_name"]."))");
			$CCSTK=mysql_fetch_object($CommonCreditSTK);
			
			$REPRESENTATIVE = mysql_query("SELECT id FROM representative WHERE headquarter_id IN (".$_REQUEST["hq_name"].")");
			while($REP = mysql_fetch_object($REPRESENTATIVE)){
				$CommonCreditMR = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE rep_id IN (".$REP->id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (".$_REQUEST["hq_name"]."))");
				$CCMR=mysql_fetch_object($CommonCreditMR);
				
				$MRVALUEPERCENTAGE = round(($CCMR->TOT/($CCSTK->TOT-$CC->TOT))*100,0);
				
				$ProductSales=mysql_query("SELECT id,pts FROM product"); // PRODUCT DETAILS	
				while($PS=mysql_fetch_object($ProductSales)){
					
					$Sales11 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' and dist_id IN (SELECT dis_id FROM distributor WHERE headquarters_id IN (".$_REQUEST["hq_name"]."))");
				$S111=mysql_fetch_object($Sales11);					
					
				mysql_query("INSERT INTO tbl_medplus (medplus_rep_id,medplus_billdate,medplus_product_id,medplus_qty,medplus_pts,medplus_status) VALUES (".$REP->id.",'".date("Y/m/d",strtotime($R_MDATE->LastDay))."','".$PS->id."','".round(($MRVALUEPERCENTAGE*$S111->Q/100),0)."','".$PS->pts*round(($MRVALUEPERCENTAGE*$S111->Q/100),3)."',1)");
					
				
				}
			}
	
	}
?>