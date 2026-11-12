<?php
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
/*include("include/function.php");
$conn=mysql_connect("localhost","root","");
mysql_select_db("xylo");*/
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 300000000);
ini_set('max_execution_time', 150000000);
set_time_limit(0);
error_reporting(E_ALL);

/*$RSM_REP = mysql_query("SELECT GROUP_CONCAT(repid) REP FROM assigningreptomanager WHERE managerid='33' AND status=0");
$REP=mysql_fetch_object($RSM_REP);

$RSM_STK = mysql_query("SELECT GROUP_CONCAT(repid) REP FROM assigningreptomanager WHERE managerid='33' AND status=1");
$STK=mysql_fetch_object($RSM_STK);*/


$_REQUEST["from_date"]=date("Y/m",strtotime($_REQUEST["from_date"]))."/01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);
$totq=0;$tot=0;
/*$REP = mysql_query("SELECT id,rep_name FROM representative WHERE id='".@$_REQUEST['rep_name']."'");
$R=mysql_fetch_object($REP);*/
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
/*$yuvaraj->setActiveSheetIndex(0);
$TNtot = mysql_query("SELECT IFNULL(ROUND(SUM(`quantity`*`pts`),0),0) TOT FROM `areawise_temp` WHERE `rep_id` IN (".$_REQUEST['rep_name'].") AND dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
$TN=mysql_fetch_object($TNtot);
$tntotal=$TN->TOT;
$CommonCredit = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='46'");
$CC=mysql_fetch_object($CommonCredit);
$common = $CC->TOT;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "REPWISE SALES MADE FOR EACH STOCKIST FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));
$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MR");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "L.Q. Avg. Sales");
$col=2;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sales Credit Percentage");
$col=0;$row=3;
$TN = mysql_query("SELECT representative.rep_name RNAME,IFNULL(ROUND(SUM(areawise_temp.`quantity`*areawise_temp.`pts`),0),0) TOT FROM `areawise_temp`,representative WHERE areawise_temp.`rep_id` IN (".$_REQUEST['rep_name'].") AND areawise_temp.dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) AND areawise_temp.rep_id=representative.id group by areawise_temp.rep_id");
while($T=mysql_fetch_object($TN)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $T->RNAME);	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $T->TOT);
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round((($T->TOT/$tntotal)*100),1));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($common*(round((($T->TOT/$tntotal)*100),1)))/100,0));
	$row++;
	$col=0;
}*/
/*$yuvaraj->setActiveSheetIndex(0);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "REPWISE SALES MADE FOR EACH STOCKIST FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));
$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
$col=2;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "QTY");
$col=3;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PTS");
$col=4;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MR");
$col=0;$row=3;
$inF = mysql_query("SELECT DISTINCT areawise_temp.`our_product_id` as product,product.pro_name PRODUCT
FROM `areawise_temp` , product, distributor
WHERE areawise_temp.`dist_id`
IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )
AND areawise_temp.rep_id NOT
IN ( 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32 )
AND areawise_temp.our_product_id = product.id
AND distributor.dis_id = areawise_temp.dist_id
 ORDER BY CAST( areawise_temp.`our_product_id` AS UNSIGNED )");
while($P=mysql_fetch_object($inF)){

	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($P->PRODUCT));
	$col++;
	$Infil = mysql_query("SELECT product.pro_name PRODUCT, distributor.dis_name DNAME, IFNULL( SUM( areawise_temp.`quantity` ) , 0 ) AS Q, IFNULL( round( SUM( areawise_temp.`quantity` * areawise_temp.pts ) , 0 ) , 0 ) AS PTS, areawise_temp.rep_id
FROM `areawise_temp` , product, distributor
WHERE areawise_temp.`dist_id`
IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )
AND areawise_temp.rep_id NOT
IN ( 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32 )
AND areawise_temp.our_product_id = product.id AND areawise_temp.our_product_id = '".$P->product."'
AND distributor.dis_id = areawise_temp.dist_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'
GROUP BY areawise_temp.rep_id, areawise_temp.dist_id
ORDER BY CAST( areawise_temp.`our_product_id` AS UNSIGNED ) ");
while($D=mysql_fetch_object($Infil)){$col=1;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->DNAME));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->Q));$totq+=$D->Q;	
	$col++;
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->PTS));$tot+=$D->PTS;	
	$col++;
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->rep_id));
	$row++;
}
		
	/*$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->DNAME));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->Q));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->PTS));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->rep_id));*/		
	//$col=1;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($totq));	
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($tot));
//	$row++;
//	$totq=0;$tot=0;
//	/*$col=0;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total : ".strtoupper($D->PRODUCT));
//	$row++;*/
//
//$col=0;
//}*/

/*$yuvaraj->setActiveSheetIndex(0);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "REPWISE SALES MADE FOR EACH STOCKIST FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
$col=1;	
$Representative=mysql_query("SELECT rep_name FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "%");	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
//$row=3;$col=1;
$dist = array();
$col=0;$row=3;
$Distributor=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Distributor)){
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$row++;
}
$row=3;$col=1;
$DistributorS=mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )"); // PRODUCT DETAILS	
while($DS=mysql_fetch_object($DistributorS)){
		$Representative1=mysql_query("SELECT id FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative1)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' AND dist_id='".$DS->dis_id."'");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
				$col++;
				$Sales12 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$_REQUEST['rep_name'].")");
		$S12=mysql_fetch_object($Sales12);
				if($S12->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}			
				if($S12->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->Q/$S12->Q)*100,1));}	
				$col++;
		}
		
		$Sales1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$_REQUEST['rep_name'].")");
		$S1=mysql_fetch_object($Sales1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->Q);
		$col=1;$row++;
}
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "RUPEEWISE VALUE");
$col=1;
$TOTAL = 0;
$Rep1=mysql_query("SELECT id FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Rep1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->Q);	
		$col++;
		$Sales222 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) and rep_id IN (".$_REQUEST['rep_name'].")");
		$S222=mysql_fetch_object($Sales222);
		if($S222->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}	
		if($S222->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S2->Q/$S222->Q)*100,1));}	
		$col++;		
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTAL);*/
// CLIENT POB - END

// INFIL IN - START
if(@$_REQUEST["submit"]=="INFIL"){

$yuvaraj->setActiveSheetIndex(1);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKISTWISE SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=3;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=3;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=1;	$row=4;
$Representative=mysql_query("SELECT id,pro_name,packing FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));	
	$row++;
}

$col=2;$row=2;

$OHQ = mysql_query("SELECT infil_name,infil_stockist,infil_stockist_cnt FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($O->infil_name));	
	$col+=$O->infil_stockist_cnt;
}
$col=2;$row=3;	
$OHQ1 = mysql_query("SELECT infil_stockist FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ1)){
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$O->infil_stockist.")"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$col++;
}}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "VALUE");
$col++;

$row=4;$col=2;
$ProductSales=mysql_query("SELECT id,pts FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){

$OHQ2 = mysql_query("SELECT infil_stockist FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ2)){

		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$O->infil_stockist.")");
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id  in (".$R->dis_id.") and rep_id in (33,34,35,36,58)");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
				$col++;
				$TOTQ = $TOTQ+$S->Q;				
		}
	}
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTQ);	
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($TOTQ*$PS->pts,0));	
		$col++;
		$TOTQ = 0;$TOTVALUE = 0;
		$col=2;$row++;
		
		
}

// TOTAL 
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col+=2;
$OHQ3 = mysql_query("SELECT infil_stockist,local_rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ3)){
		$Representative21=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$O->infil_stockist.")");
		while($R=mysql_fetch_object($Representative21)){		
				$Sales = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id  in (".$R->dis_id.") and rep_id in (".$O->local_rep_id.")");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->PTS);	
				$col++;
		}}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."180)");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."180)");

// INFIL

$yuvaraj->setActiveSheetIndex(2);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKISTWISE SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=3;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=3;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=1;	$row=4;
$Representative=mysql_query("SELECT id,pro_name,packing FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));	
	$row++;
}

$col=2;$row=2;

$OHQ = mysql_query("SELECT infil_name,infil_stockist,infil_stockist_cnt,local_stockist_cnt FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($O->infil_name));	
	$col+=$O->local_stockist_cnt;
}
$col=2;$row=3;	
$OHQ1 = mysql_query("SELECT local_stockist FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ1)){
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$O->local_stockist.")"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$col++;
}}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "VALUE");
$col++;

$row=4;$col=2;
$ProductSales=mysql_query("SELECT id,pts FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){

$OHQ2 = mysql_query("SELECT local_stockist,rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ2)){

		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$O->local_stockist.")");
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id  in (".$R->dis_id.") and rep_id in (".$O->rep_id.")");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
				$col++;
				$TOTQ = $TOTQ+$S->Q;				
		}
	}
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTQ);	
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($TOTQ*$PS->pts,0));	
		$col++;
		$TOTQ = 0;$TOTVALUE = 0;
		$col=2;$row++;
		
		
}

// TOTAL 
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col+=2;
$OHQ3 = mysql_query("SELECT local_stockist,rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id=".$_REQUEST["hq_name"]."");
while($O=mysql_fetch_object($OHQ3)){
		$Representative21=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$O->local_stockist.")");
		while($R=mysql_fetch_object($Representative21)){		
				$Sales = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id  in (".$R->dis_id.") and rep_id in (".$O->rep_id.")");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->PTS);	
				$col++;
		}}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."180)");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."180)");
}
// INFIL OUT - END



// Yuvaraj Rajendran - Start
if(@$_REQUEST["submit"]=="REP"){
$yuvaraj->setActiveSheetIndex(1);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKISTWISE SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$Covering_STK = mysql_query("SELECT group_concat(distinct dist_id) as D FROM `areawise_temp` WHERE rep_id IN (".$_REQUEST["rep_name"].")");
$STK=mysql_fetch_object($Covering_STK);

// reprsentative details

$REP = mysql_query("SELECT rdist_id,id FROM representative WHERE id IN (".$_REQUEST["rep_name"].")");
$REPSTK=mysql_fetch_object($REP);

$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='0' and dist_id IN (".$REPSTK->rdist_id.")");
$CC=mysql_fetch_object($CommonCredit);
$common = $CC->TOT;$commonQ = $CC->Q;

// TOTAL HQ SUM

$CommonCreditSTK = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE dist_id IN (".$REPSTK->rdist_id.") and rep_id in (33,34,35,58) and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$CCSTK=mysql_fetch_object($CommonCreditSTK);
$commonSTK = $CCSTK->TOT;



// CC1 CALCULATING

$CommonCreditMR = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE rep_id IN (".$_REQUEST["rep_name"].") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$CCMR=mysql_fetch_object($CommonCreditMR);
$commonMR = $CCMR->TOT;

$MRVALUEPERCENTAGE = round($CC->TOT*round(($CCMR->TOT/$CCSTK->TOT)*100,0)/100,0);



$CommonCredit1 = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='57'");
$CC1=mysql_fetch_object($CommonCredit1);
$common1 = $CC1->TOT;$commonQ1 = $CC1->Q;

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=1;	$row=3;
$Representative=mysql_query("SELECT id,pro_name,packing FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));	
	$row++;
}

$col=2;$row=2;	
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$STK->D.") ORDER BY id"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC1");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MEDPLUS");
$col++;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "VASAN MEDICAL HALL");
//$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "VALUE");
$col++;
$Sales3 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (".$_REQUEST["rep_name"].")");
$S32=mysql_fetch_object($Sales3);
$row=3;$col=2;
$ProductSales=mysql_query("SELECT id,pts FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$STK->D.") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id='".$R->dis_id."' and rep_id IN (".$_REQUEST["rep_name"].")");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
				$col++;
				$TOTQ = $TOTQ+$S->Q;
		}
		$Representative22=mysql_query("SELECT id,sales_credit,rdist_id FROM representative WHERE id IN (".$_REQUEST["rep_name"].") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative22)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' and dist_id IN (".$R->rdist_id.")");
				$S=mysql_fetch_object($Sales);	
				$SalesHQ = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' and dist_id NOT IN (".$R->rdist_id.")");
				$SHQ=mysql_fetch_object($SalesHQ);
				$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (".$R->rdist_id.")");
				$S2=mysql_fetch_object($Sales2);
				
				$MPLUS = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE our_product_id='".$PS->id."' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id='57'");
				$MPY=mysql_fetch_object($MPLUS);
				
				/*$CommonCreditP = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,round(IFNULL(SUM(quantity*pts),0),0) TOT FROM `areawise_temp` WHERE our_product_id='".$PS->id."' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and `rep_id`='0' and dist_id IN (".$STK->D.")");
				$CCP=mysql_fetch_object($CommonCreditP);*/
				
				if($S2->PTS==0){
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
					$col++;
				}
				if($S2->PTS>0){					
					//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round(()*(round(($S->Q/$S2->Q)*100,0)/100),0));					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,round(round(($MRVALUEPERCENTAGE*round(($S->Q/$S2->Q)*100,0)/100),0)/$PS->pts,0));
					//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$MRVALUEPERCENTAGE);	
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($MPY->Q*$R->sales_credit/100,0));
					
					$col++;
					
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  $TOTQ+round(round(($MRVALUEPERCENTAGE*round(($S->Q/$S2->Q)*100,0)/100),0)/$PS->pts,0)+round($MPY->Q*$R->sales_credit/100,0));
					$col++;
					
					$CC1 =$CC1+round(round(($MRVALUEPERCENTAGE*round(($S->Q/$S2->Q)*100,0)/100),0),0);
				
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  round($PS->pts*($TOTQ+round(round(($MRVALUEPERCENTAGE*round(($S->Q/$S2->Q)*100,0)/100),0)/$PS->pts,0)+round($MPY->Q*$R->sales_credit/100,0)),0));
					$col++;
//					
				}
				
		}
		$TOTQ = 0;$TOTVALUE = 0;$col=2;$row++;
		
}
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col+=2;

$Dist=mysql_query("SELECT `areawise_temp`.dist_id DID,round( sum( `areawise_temp`.quantity * `areawise_temp`.pts ) , 0 ) PTS FROM areawise_temp WHERE rep_id IN (".$_REQUEST["rep_name"].") GROUP BY `areawise_temp`.dist_id ORDER BY `areawise_temp`.dist_id"); // PRODUCT DETAILS	
while($DTOT=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $DTOT->PTS);	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($CC1,0));
$col++;
$REPMP = mysql_query("SELECT sales_credit FROM representative WHERE id IN (".$_REQUEST["rep_name"].")");$RMP=mysql_fetch_object($REPMP);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($common1*$RMP->sales_credit/100),0));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."180)");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."180)");
$col++;
}
//Yuvaraj Rajendran




/*$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col=2;
$TOTAL = 0;
$DistributorTOT1=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$STK->D.") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."' and rep_id IN (".$_REQUEST['rep_name'].")");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->PTS);	
		$col++;		
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTAL);*/

/*$yuvaraj->setActiveSheetIndex(2); // DETAILED REPORT
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKISTWISE DETAILED SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=1;	$row=3;
$Representative=mysql_query("SELECT id,pro_name,packing FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));	
	$row++;
}

$col=2;$row=2;	
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) ORDER BY id"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name)." PTS");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "%");	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL PTS");

$row=3;$col=3;
$ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id='".$R->dis_id."'");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->PTS);	
				$col++;
				$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."'  and rep_id IN (".$_REQUEST['rep_name'].")");
				$S2=mysql_fetch_object($Sales2);
				if($S2->PTS==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
				if($S2->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->PTS/$S2->PTS)*100,1));}	
				$col++;
		}
		$PSales1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."'  and rep_id IN (".$_REQUEST['rep_name'].") and  dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
		$S1=mysql_fetch_object($PSales1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->Q);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->PTS);
		$col=2;$row++;
}

$Sales3 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'  and rep_id IN (".$_REQUEST['rep_name'].") and  dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
$S32=mysql_fetch_object($Sales3);


$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col=2;
$TOTAL = 0;
$DistributorTOT1=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."' and rep_id IN (".$_REQUEST['rep_name'].")");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->Q);	
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->PTS);	
		$col++;
		if($S32->PTS==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
		if($S32->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S2->PTS/$S32->PTS)*100,1));}	
		$col++;	
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTAL);
$col++;	
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S32->PTS);*/

// amma - start



//$yuvaraj->setActiveSheetIndex(3); // NETSALES REPORT
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "REPWISE PRODUCTWISE SALES FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));
//$TOTQ = 0;
//$TOTVALUE = 0;
//$col=0;$row=2;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
//$col=1;$row=2;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
//$col=2;$row=2;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRICE");
//
//$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='46'");
//$CC=mysql_fetch_object($CommonCredit);
//$common = $CC->TOT;$commonQ = $CC->Q;
//
//$CommonCredit1 = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='57'");
//$CC1=mysql_fetch_object($CommonCredit1);
//$common1 = $CC1->TOT;$commonQ1 = $CC1->Q;
//
//
//$col=3;$row=2;	
//$Dist=mysql_query("SELECT rep_name FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id"); // PRODUCT DETAILS	
//while($D=mysql_fetch_object($Dist)){
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->rep_name)." QTY");	
////	$col++;
////	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "%");	
////	$col++;
////	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC1");	
////	$col++;
////	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC2");	
////	$col++;
////	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Infil");	
////	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->rep_name)." Q");	
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Value");	
//	$col++;
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
//$col++;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Value");
//
//
//$col=1;	$row=3;
//$Representative=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
//while($R=mysql_fetch_object($Representative)){
//	$col=0;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pts));	
//	$row++;
//}
//
//$Sales3 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) and rep_id IN (".$_REQUEST['rep_name'].")");
//$S32=mysql_fetch_object($Sales3);
//
//$row=3;$col=3;
//$ProductSales=mysql_query("SELECT id,pts FROM product"); // PRODUCT DETAILS	
//while($PS=mysql_fetch_object($ProductSales)){
//		$Representative2=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id"); // PRODUCT DETAILS	
//		while($R=mysql_fetch_object($Representative2)){	
//				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//				$S=mysql_fetch_object($Sales);
//				$SalesHQ = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' and dist_id NOT IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//				$SHQ=mysql_fetch_object($SalesHQ);
//				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
////				$col++;
//				$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//				$S2=mysql_fetch_object($Sales2);
//				if($S2->PTS==0){
//					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
////					$col++;
////					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
////					$col++;
////					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
////					$col++;
////					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
////					$col++;
//					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
//					$col++;
//					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
//					$col++;
//					
//				}
//				if($S2->PTS>0){
//				
//					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->PTS/$S2->PTS)*100,1));
////					$col++;
////					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round((round(($commonQ*(round(($S2->Q/$S32->Q)*100,1))/100),0))*(round(($S->Q/$S2->Q)*100,1)/100),0));
////					$col++;
////					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round((round(($S->Q/$S2->Q)*100,1)*round(($commonQ1*($R->sales_credit))/100,1))/100,0));
////					$col++;
////					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SHQ->Q);
////					$col++;
//					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, ($SHQ->Q)+round((round(($S->Q/$S2->Q)*100,1)*round(($commonQ1*($R->sales_credit))/100,1))/100,0)+round((round(($commonQ*(round(($S2->Q/$S32->Q)*100,1))/100),0))*(round(($S->Q/$S2->Q)*100,1)/100),0)+$S->Q);
//					$col++;
//					
//					$TOTQ = $TOTQ+($SHQ->Q)+round((round(($S->Q/$S2->Q)*100,1)*round(($commonQ1*($R->sales_credit))/100,1))/100,0)+round((round(($commonQ*(round(($S2->Q/$S32->Q)*100,1))/100),0))*(round(($S->Q/$S2->Q)*100,1)/100),0)+$S->Q;
//					
//					
//					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($PS->pts)*(($SHQ->Q)+round((round(($S->Q/$S2->Q)*100,1)*round(($commonQ1*($R->sales_credit))/100,1))/100,0)+round((round(($commonQ*(round(($S2->Q/$S32->Q)*100,1))/100),0))*(round(($S->Q/$S2->Q)*100,1)/100),0)+$S->Q),0));
//					$TOTVALUE = $TOTVALUE+round(($PS->pts)*(($SHQ->Q)+round((round(($S->Q/$S2->Q)*100,1)*round(($commonQ1*($R->sales_credit))/100,1))/100,0)+round((round(($commonQ*(round(($S2->Q/$S32->Q)*100,1))/100),0))*(round(($S->Q/$S2->Q)*100,1)/100),0)+$S->Q),0);
//					$col++;
//				}
//				
//		}
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTQ);
//		$col++;
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTVALUE);
//		$col++;
//		$TOTQ = 0;$TOTVALUE = 0;$col=3;$row++;
//		
//}
//$col=0;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MR VALUE");
//$col=4;
//$TOT=0;
//$SalesHQ = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$_REQUEST['rep_name'].") and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//$SHQ=mysql_fetch_object($SalesHQ);
//
//$Representative21=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$_REQUEST['rep_name'].")");
//while($R=mysql_fetch_object($Representative21)){		
//		$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//				$S=mysql_fetch_object($Sales);
//				$SalesHQ = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id NOT IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//				$SHQ=mysql_fetch_object($SalesHQ);
//				//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
////				$col++;
//				$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
//				$S2=mysql_fetch_object($Sales2);
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,($S->PTS)+($SHQ->PTS)+round(round(($S->PTS/$SHQ->PTS),3)*$common,0)+($common1*round(($R->sales_credit/100),3)));
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  0);	
//	//$TOT = $TOT+($S->PTS)+($SHQ->PTS)+round(round(($S->PTS/$SHQ->PTS),1)*$common,0)+($common1*round(($R->sales_credit/100),1));
//	//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col)."181)");
//	$col+=2;	
//}
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$TOT);
// amma - end	

function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}	
//
//
//
//$Sales311 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (100019,100026,100027,100083,100084,100085,100086,100090,100091,100092) and rep_id IN (".$_REQUEST['rep_name'].")");
//$S32=mysql_fetch_object($Sales311);
//
//$col=0;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "REPRESENTATIVE VALUE");
//$col=3;
//$TOTAL = 0;
//$DistributorTOT1=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id"); // PRODUCT DETAILS	
//while($R=mysql_fetch_object($DistributorTOT1)){	
//		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100019,100026,100027,100083,100084,100085,100086,100090,100091,100092)");
//		$S2=mysql_fetch_object($Sales2);
//		echo "SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id NOT IN (100019,100026,100027,100083,100084,100085,100086,100090,100091,100092)";
//		$SalesHQ1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id NOT IN (100019,100026,100027,100083,100084,100085,100086,100090,100091,100092)");
////		$SHQ=mysql_fetch_object($SalesHQ1);
//		$TOTAL+=$S2->Q;	
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->Q);	
//		$col++;	
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->PTS);	
//		$col++;
//		if($S32->PTS>0){
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "100%");
//			$col++;
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($common*(round(($S2->PTS/$S32->PTS)*100,1))/100),0)); // CC1
//			$col++;
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($common1*($R->sales_credit))/100,0)); // CC2	
//			$col++;
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,0); // OHQ			
//		}
//		if($S32->PTS==0){
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
//			$col++;
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
//			$col++;
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
//			$col++;
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
//		}
//		$col++;	
//				
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTAL);
//$col++;	
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S32->PTS);
// OTHER HQ

/*$col=134;$row=2;	
$Dist=mysql_query("SELECT rep_name FROM representative WHERE id IN (33,35,38,42,45,47,48,49) ORDER BY id"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->rep_name)." QTY");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->rep_name)." PTS");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "%");	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL PTS");

$row=3;$col=84;
$ProductSales1=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales1)){
		$Representative21=mysql_query("SELECT id FROM representative WHERE id IN (33,35,38,42,45,47,48,49) ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative21)){	
				$Sales1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
				$S=mysql_fetch_object($Sales1);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->PTS);	
				$col++;
				$Sales21 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
				$S2=mysql_fetch_object($Sales21);
				if($S2->PTS==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
				if($S2->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->PTS/$S2->PTS)*100,1));}	
				$col++;
		}
		$PSales11 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) and rep_id IN (33,35,38,42,45,47,48,49)");
		$S1=mysql_fetch_object($PSales11);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->Q);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->PTS);
		$col=84;$row++;
}

$Sales31 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 ) and rep_id IN (33,35,38,42,45,47,48,49)");
$S32=mysql_fetch_object($Sales31);



$col=84;
$TOTAL = 0;
$DistributorTOT11=mysql_query("SELECT id FROM representative WHERE id IN (33,35,38,42,45,47,48,49) ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT11)){	
		$SalesY2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
		$S2=mysql_fetch_object($SalesY2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->Q);	
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->PTS);	
		$col++;
		if($S32->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S2->PTS/$S32->PTS)*100,1));}
		if($S32->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "100%");}
		$col++;	
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTAL);
$col++;	
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S32->PTS);*/

/*$yuvaraj->setActiveSheetIndex(4); // STOCKIST + REP DETAILED REPORT
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKIST PRODUCTWISE SALES FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=2;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRICE");

$col=3;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
$col=4;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "RSM");
$col=5;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "OTHER");


$col=1;	$row=3;
$Representative=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pts));	
	$col++;
	$Distributor = mysql_query("SELECT dis_id,dis_name FROM distributor WHERE dis_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100022,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100051,100052,100053,100054,100055,100056) ORDER BY id");
	while($R=mysql_fetch_object($Distributor)){
		$col=4;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->dis_name));
		$row++;
	}
}
$col=4;	$row=3;
$Distributor=array(100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 );
$Product=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($P=mysql_fetch_object($Product)){
	$col=4;
	foreach($Distributor as $Dist){
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id='".$Dist."'");	
		$S=mysql_fetch_object($Sales2);
	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
		$row++;
	}
	$Sales21 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");	
		$S=mysql_fetch_object($Sales21);
	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
		$row++;
		
}*/
/*$col=5;	$row=3;
$ProductY=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($P=mysql_fetch_object($ProductY)){
	$col=5;
	foreach($Distributor as $Dist){
		$Sales2Y = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id='".$Dist."'");	
		$S=mysql_fetch_object($Sales2Y);
	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
		$row++;
	}
	$Sales21Y = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");	
		$S=mysql_fetch_object($Sales21Y);
	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
		$row++;
		
}
$col=6;	$row=2;
$RepresentativeY=mysql_query("SELECT rep_name FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($RepresentativeY)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));	
	$col++;
}

$row=3;$col=6;
$ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		foreach($Distributor as $Dist){
		$Representative2=mysql_query("SELECT id FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				//@$colD=$col;$rowD=$row;
				
					$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' AND dist_id='".$Dist."'");
					$S=mysql_fetch_object($Sales);		
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
					$col++;		
				}$col=6;$row++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total".$col);
				$col++;		
		}
		$Representative2=mysql_query("SELECT id FROM representative WHERE id IN (".$_REQUEST['rep_name'].") ORDER BY id ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
			$SalesA = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' AND dist_id IN (100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051 )");
			$SA=mysql_fetch_object($SalesA);
			$yuvaraj->getActiveSheet()->getStyle($col)->getFont()->setBold(true)
                                ->setName('Verdana')
                                ->setSize(".$_REQUEST['rep_name'].")
                                ->getColor()->setRGB('6F6F6F');
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SA->Q);
			$col++;
		}
		
		$row++;$col=6;
		
		$col=6;
}*/

if($_REQUEST["submit"]=="RSM"){

$did=array();
$repid=array();
$other_repid=array();


$styleArray= array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'f4b384')
    )
);

$styleArray1= array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '333f4f')
    )
);

$styleArray_f = array(
    'font'  => array(
        'bold'  => true
));

$styleArray_f1 = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'ffffff')
));

$styleArray_h= array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '9fcf9d')
    )
);

$OHQ = mysql_query("SELECT local_rep_id,local_stockist,rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id='".$_REQUEST["hq_name"]."' GROUP BY headquarters_id");
while($OHQ_ROW = mysql_fetch_array($OHQ)){
	$did[]=$OHQ_ROW['local_stockist'];
	$repid[]=$OHQ_ROW['local_rep_id'];
}

$OHQ1 = mysql_query("SELECT local_rep_id,local_stockist,rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id='".$_REQUEST["hq_name"]."'");
while($OHQ_ROW1 = mysql_fetch_array($OHQ1)){
	$other_repid[]=$OHQ_ROW1['rep_id'];
}

$stockist=implode(",",$did);
$rep=implode(",",$repid);
$oth_rep=implode(",",$other_repid);

$hq_sql=mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id='".$_REQUEST["hq_name"]."'");
$row_hq=mysql_fetch_object($hq_sql);

$yuvaraj->setActiveSheetIndex(4); // STOCKIST + REP DETAILED REPORT
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKIST PRODUCTWISE SALES FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"]))." - ".$row_hq->headquarters_name);

$yuvaraj->getActiveSheet()->mergeCells("A1:H1");
$yuvaraj->getActiveSheet()->getStyle("A1:H1")->applyFromArray($styleArray_h);

$yuvaraj->getActiveSheet()->freezePane('A3');

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=2;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRICE");
$col=3;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
$col=4;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");
$col=5;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ");

$col=6;
$representative = mysql_query("SELECT id,rep_name FROM representative WHERE id IN ($rep) ORDER BY id");
while($R=mysql_fetch_object($representative)){
	$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));
	$col++;
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "OTHERS");
$col++;

$representative = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
while($R=mysql_fetch_object($representative)){
	$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->headquarters_name));
	$col++;
}

$col=1;	$row=3;
$Representative=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id limit 5"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(25);	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pts));	
	$col++;

	$total_qty=0;

	$Distributor = mysql_query("SELECT dis_id,dis_name FROM distributor WHERE dis_id IN ($stockist) ORDER BY id");
	while($R1=mysql_fetch_object($Distributor)){
		$col=3;
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(49);	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R1->dis_name));
		$col++;

		$rsm_qty=0;
		$col=6;
		$representative1 = mysql_query("SELECT id,rep_name FROM representative WHERE id IN ($rep) ORDER BY id");
		while($R2=mysql_fetch_object($representative1)){
			$areawise=mysql_query("SELECT sum(quantity) as quantity FROM areawise_temp WHERE our_product_id='".$R->id."' AND dist_id='".$R1->dis_id."' AND rep_id='".$R2->id."' AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY our_product_id");
			$R3=mysql_fetch_object($areawise);
			$quantity='0';
			if($R3->quantity!=''){ $quantity=$R3->quantity; }
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $quantity);
			$col++;

			$rsm_qty=$rsm_qty+$quantity;
		}

		$prev_col=$col;
		$col++;
		$rsm_qty1=0;
		$representative2 = mysql_query("SELECT rep_id FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
		while($R2=mysql_fetch_object($representative2)){
			$areawise2=mysql_query("SELECT sum(quantity) as quantity FROM areawise_temp WHERE our_product_id='".$R->id."' AND dist_id='".$R1->dis_id."' AND rep_id IN (".$R2->rep_id.") AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY our_product_id");
			$R3=mysql_fetch_object($areawise2);
			$quantity2='0';
			if($R3->quantity!=''){ $quantity2=$R3->quantity; }
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $quantity2);
			$col++;

			$rsm_qty1=$rsm_qty1+$quantity2;
		}

		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $rsm_qty+$rsm_qty1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $rsm_qty);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($prev_col, $row, $rsm_qty1);
		$row++;
	}

	$rsm_total_qty=0;
	$col=6;
	$representative2 = mysql_query("SELECT id,rep_name FROM representative WHERE id IN ($rep) ORDER BY id");
	while($RT1=mysql_fetch_object($representative2)){
		$areawise1=mysql_query("SELECT sum(quantity) as quantity FROM areawise_temp WHERE our_product_id='".$R->id."' AND dist_id IN ($stockist) AND rep_id='".$RT1->id."' AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY our_product_id");
		$RT3=mysql_fetch_object($areawise1);
		$quantity1='0';
		if($RT3->quantity!=''){ $quantity1=$RT3->quantity; }
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $quantity1);
		$col++;

		$rsm_total_qty=$rsm_total_qty+$quantity1;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, $row, "TOTAL");
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $rsm_total_qty);

	$prev_col_tot=$col;
	$col++;

	$rsm_total_qty1=0;
	$representative4 = mysql_query("SELECT rep_id FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
	while($RT1=mysql_fetch_object($representative4)){
		$areawise1=mysql_query("SELECT sum(quantity) as quantity FROM areawise_temp WHERE our_product_id='".$R->id."' AND dist_id IN ($stockist) AND rep_id IN (".$RT1->rep_id.") AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY our_product_id");
		$RT3=mysql_fetch_object($areawise1);
		$quantity3='0';
		if($RT3->quantity!=''){ $quantity3=$RT3->quantity; }
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $quantity3);
		$col++;

		$rsm_total_qty1=$rsm_total_qty1+$quantity3;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $rsm_total_qty+$rsm_total_qty1);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($prev_col_tot, $row, $rsm_total_qty1);

	$adjustment = $col-1;
	$currentColumn = 'A';

	$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	$adjustedColumnIndex = $columnIndex + $adjustment;
	$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	$yuvaraj->getActiveSheet()->getStyle("D".$row.":".$adjustedColumn.$row)->applyFromArray($styleArray);
	$yuvaraj->getActiveSheet()->getStyle("D".$row.":".$adjustedColumn.$row)->applyFromArray($styleArray_f);

	$yuvaraj->getActiveSheet()->getStyle("A2:".$adjustedColumn."2")->applyFromArray($styleArray1);
	$yuvaraj->getActiveSheet()->getStyle("A2:".$adjustedColumn."2")->applyFromArray($styleArray_f1);

	$row++;
	$row++;
}
// $col=4;	$row=3;
// $Distributor=array(100002,100006,100007,100012,100013,100014,100016,100017,100018,100020,100023,100024,100025,100029,100032,100033,100035,100036,100037,100038,100039,100040,100041,100044,100045,100047,100048,100049,100050,100052,100053,100054,100055,100056,100022,100051);

//$Distributor = array($stockist);



// $Product=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
// while($P=mysql_fetch_object($Product)){
// 	$col=4;
// 	foreach($Distributor as $Dist){
// 		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id='".$Dist."'");	
// 		$S=mysql_fetch_object($Sales2);
// 	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
// 		$row++;
// 	}
// 	$Sales21 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id IN ($stockist)");	
// 		$S=mysql_fetch_object($Sales21);
// 	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
// 		$row++;
		
// }
// $col=5;	$row=3;
// $ProductY=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
// while($P=mysql_fetch_object($ProductY)){
// 	$col=5;
// 	foreach($Distributor as $Dist){
// 		$Sales2Y = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id='".$Dist."'");	
// 		$S=mysql_fetch_object($Sales2Y);
// 	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
// 		$row++;
// 	}
// 	$Sales21Y = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$P->id."' AND dist_id IN ($stockist)");	
// 		$S=mysql_fetch_object($Sales21Y);
// 	 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
// 		$row++;
		
// }
// $col=6;	$row=2;
// $RepresentativeY=mysql_query("SELECT rep_name FROM representative WHERE id IN ($rep) ORDER BY id ORDER BY id"); // PRODUCT DETAILS	
// while($R=mysql_fetch_object($RepresentativeY)){
// 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));	
// 	$col++;
// }

// $row=3;$col=6;
// $ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
// while($PS=mysql_fetch_object($ProductSales)){
// 		foreach($Distributor as $Dist){
// 		$Representative2=mysql_query("SELECT id FROM representative WHERE id IN ($rep) ORDER BY id ORDER BY id"); // PRODUCT DETAILS	
// 		while($R=mysql_fetch_object($Representative2)){	
// 				//@$colD=$col;$rowD=$row;
				
// 					$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' AND dist_id='".$Dist."'");
// 					$S=mysql_fetch_object($Sales);		
// 					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q);	
// 					$col++;		
// 				}$col=6;$row++;
// 				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total".$col);
// 				$col++;		
// 		}
// 		$Representative2=mysql_query("SELECT id FROM representative WHERE id IN ($rep) ORDER BY id ORDER BY id"); // PRODUCT DETAILS	
// 		while($R=mysql_fetch_object($Representative2)){	
// 			$SalesA = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' AND dist_id IN ($stockist)");
// 			$SA=mysql_fetch_object($SalesA);
// 			$yuvaraj->getActiveSheet()->getStyle($col)->getFont()->setBold(true)
//                                 ->setName('Verdana')
//                                 ->setSize(10)
//                                 ->getColor()->setRGB('6F6F6F');
// 			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SA->Q);
// 			$col++;
// 		}
		
// 		$row++;$col=6;
		
// 		$col=6;
// }
}

//prepare download
$filename=" Daily_Sales_Report ".date("d/m/Y H:i:s").".csv"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>