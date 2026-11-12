<?php
require_once "Classes/PHPExcel/IOFactory.php";
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
$totq=0;$tot=0;


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

// HQ NAME
$HQNAME = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
$HQN = mysql_fetch_object($HQNAME);
$HEADQUARTERNAME = strtoupper($HQN->headquarters_name);

// HQ STOCKIST DETAILS
$OWNYSTK = mysql_query("SELECT group_concat(dis_id) HQYSTK FROM distributor WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
$OYSTK = mysql_fetch_object($OWNYSTK);
$stockist1=$OYSTK->HQYSTK;


// HQ REP DETAILS
$OWNYREP = mysql_query("SELECT group_concat(id) HQYREP FROM representative WHERE headquarter_id='".$_REQUEST["hq_name1"]."'");
$OYREP = mysql_fetch_object($OWNYREP);
$rep_id=$OYREP->HQYREP;

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
///////////////////////////////////////// Sheet 1 ////////////////////////////////////////////////
$yuvaraj->setActiveSheetIndex(0);

$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME HQ SALES");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME HQ - STOCKIST COVERED DETAILS (LOCAL HQ ONLY)");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "STOCKIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 2, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 2, "AREA");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 2, "CHEMIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 2, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 2, "MR NAME");

$col=0;$row=3;	
$PRODUCT = mysql_query("SELECT id,pro_name FROM product");
while($Prod=mysql_fetch_object($PRODUCT)){ // PRODUCT
	$PRODUCTCNT = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id in (".$stockist1.") ");
	$ProdCNT=mysql_fetch_object($PRODUCTCNT);	
	if($ProdCNT->Q>0){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Prod->pro_name));
		$col++;	
		$Stockist_CNT = mysql_query("SELECT distributor.dis_name DNAME,areawise_temp.dist_id dist_id,sum(areawise_temp.quantity) Q,ifnull((select rep_name from representative where id=areawise_temp.rep_id),'vacant') as rep_name,cust_name,area_id,ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp,distributor WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id in (".$stockist1.") AND areawise_temp.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.dist_id,areawise_temp.rep_id,areawise_temp.our_cust_id order by areawise_temp.dist_id,areawise_temp.cust_name");
		while($Stockist=mysql_fetch_object($Stockist_CNT)){
			if($Stockist->Q>0){
				if($dist_id!=$Stockist->dist_id){
					$col=1;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->DNAME));		
					$col++;
					
					$sql_quan=mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp,distributor WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id='".$Stockist->dist_id."' AND areawise_temp.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.dist_id");
					$row_quan=mysql_fetch_object($sql_quan);

					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row_quan->Q));
					$dist_id=$Stockist->dist_id;
				}

				$col=3;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->cust_name));		
				$col++;
				$AREA = mysql_query("SELECT pincode_list.pincode PINCODE,pincode_list.area_name AREA,master_district.district_name DISTNAME FROM pincode_list,master_district WHERE pincode_list.id=".$Stockist->area_id." AND pincode_list.dist_id=master_district.district_id");
				$A=mysql_fetch_object($AREA);
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $A->PINCODE);
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->AREA).", ".strtoupper($A->DISTNAME));
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->Q));
				$col++;$totq=$totq+$Stockist->Q;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->PTS));
				$col++;$tot=$tot+$Stockist->PTS;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->rep_name));
				$row++;
			}
		}
		$col=5;
		$yuvaraj->getActiveSheet()->getStyle("F".$row.":H".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F28A8B');
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT TOTAL");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totq);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot);	
		$row++;$col=0;	$totq=0;$tot=0;
	} // PRODUCT CNT
}
///////////////////////////////////////// Sheet 1 ////////////////////////////////////////////////

 // OUT - INFIL
///////////////////////////////////////// Sheet 2 ////////////////////////////////////////////////
$yuvaraj->setActiveSheetIndex(1);
$yuvaraj->getActiveSheet()->setTitle("INFIL-OTHER HQ");

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "INFILTRATION FROM OTHER HQS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "STOCKIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 2, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 2, "AREA");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 2, "CHEMIST Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 2, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 2, "MR NAME");

$col=0;$row=3;	
$PRODUCT = mysql_query("SELECT id,pro_name FROM product");
while($Prod=mysql_fetch_object($PRODUCT)){ // PRODUCT
	$PRODUCTCNT = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id not in (".$stockist1.") AND rep_id IN (".$rep_id.")");
	$ProdCNT=mysql_fetch_object($PRODUCTCNT);	
	if($ProdCNT->Q>0){
		$Stockist_CNT = mysql_query("SELECT distributor.dis_name DNAME,areawise_temp.dist_id dist_id,areawise_temp.rep_id,ifnull((select rep_name from representative where id=areawise_temp.rep_id),'vacant') as rep_name,cust_name,area_id, IFNULL(SUM(quantity),0) Q,ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp,distributor WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id not in (".$stockist1.") AND areawise_temp.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.dist_id,areawise_temp.rep_id");
		if(mysql_num_rows($Stockist_CNT)>0){
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Prod->pro_name));
			$col++;	
			$dist_id=0;
			while($Stockist=mysql_fetch_object($Stockist_CNT)){
				if($Stockist->Q>0){
					if($dist_id!=$Stockist->dist_id){
						$col=1;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->DNAME));		
						$col++;
						
						$sql_quan=mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp,distributor WHERE areawise_temp.our_product_id='".$Prod->id."' and areawise_temp.dist_id='".$Stockist->dist_id."' AND areawise_temp.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.dist_id");
						$row_quan=mysql_fetch_object($sql_quan);

						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row_quan->Q));
						$dist_id=$Stockist->dist_id;
					}

					$col=3;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->cust_name));		
					$col++;
					$AREA = mysql_query("SELECT pincode_list.pincode PINCODE,pincode_list.area_name AREA,master_district.district_name DISTNAME FROM pincode_list,master_district WHERE pincode_list.id=".$Stockist->area_id." AND pincode_list.dist_id=master_district.district_id");
					$A=mysql_fetch_object($AREA);
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $A->PINCODE);		
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->AREA).", ".strtoupper($A->DISTNAME));		
					$col++;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->Q));					
					$col++;
					$totq=$totq+$Stockist->Q;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->PTS));
					$col++;	
					$tot=$tot+$Stockist->PTS;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->rep_name));
					$row++;
				}
			}
			$col=5;
			$yuvaraj->getActiveSheet()->getStyle("F".$row.":H".$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('F28A8B');
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT TOTAL");
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $totq);
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $tot);	
			$row++;$col=0;	$totq=0;$tot=0;
		}
	} // PRODUCT CNT
}
/////////////////////////////////////// Sheet 2 ////////////////////////////////////////////////

// HQ - DETAILED REPORT

/////////////////////////////////////// Sheet 3 ////////////////////////////////////////////////

$yuvaraj->setActiveSheetIndex(2);
$yuvaraj->getActiveSheet()->setTitle("CONSOLIDATED $HEADQUARTERNAME->headquarters_name HQ");

$CC1_REP = mysql_query("SELECT id FROM representative WHERE headquarter_id = ".$_REQUEST["hq_name1"]." AND cc1 = 1");
	$CC1REP=mysql_fetch_object($CC1_REP);
$DCHEMIST = mysql_query("SELECT local_stockist Stockist,local_rep_id rep_id FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]." GROUP BY headquarters_id");
$DCHY=mysql_fetch_object($DCHEMIST);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "CONSOLIDATED VALUE COVERED BY LOCAL HQ STOCKISTS WITH INFIL, CC1 & MEDPLUS");

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
$col=1;	
$Representative=mysql_query("SELECT rep_name FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 ORDER BY id"); // PRODUCT DETAILS   
while($R=mysql_fetch_object($Representative)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "%");	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ TOTAL");
$col++;


// OTHER HQ
$OHQ1 = mysql_query("SELECT infil_stockist,rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
while($OHQ_ROW1 = mysql_fetch_array($OHQ1)){
	$other_stockist[]=$OHQ_ROW1['infil_stockist'];
	$other_repid[]=$OHQ_ROW1['rep_id'];
}
$oth_stock=implode(",",$other_stockist);
$oth_rep=implode(",",$other_repid);

$representative = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
while($R=mysql_fetch_object($representative)){
	$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->headquarters_name));
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "OTHERS TOTAL");
$col++;


$HQSTK = mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (".$DCHY->Stockist.")");
$dist = array();
$col=0;$row=3;
$Distributor=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$DCHY->Stockist.")"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Distributor)){
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$row++;
}
$row=3;$col=1;
$DistributorS=mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (".$DCHY->Stockist.")"); // PRODUCT DETAILS	
while($DS=mysql_fetch_object($DistributorS)){
	$col=1;
	$Representative1=mysql_query("SELECT id FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 ORDER BY id"); // PRODUCT DETAILS 	
	while($R=mysql_fetch_object($Representative1)){	
			$Sales = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' AND dist_id='".$DS->dis_id."'");
			$S=mysql_fetch_object($Sales);		
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->Q,0));	
			$col++;
			$Sales12 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$DCHY->rep_id.")");
	$S12=mysql_fetch_object($Sales12);
			if($S12->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}			
			if($S12->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->Q/$S12->Q)*100,0));}	
			$col++;
	}
	
	$Sales1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$DCHY->rep_id.")");
	$S1=mysql_fetch_object($Sales1);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->Q,0));
	$row++;
}

$prev_col=$col+1;
$row=3;
$Distributor = mysql_query("SELECT dis_id,dis_name FROM distributor WHERE dis_id IN (".$DCHY->Stockist.")");
while($R1=mysql_fetch_object($Distributor)){
	$col=$prev_col;
	$other_pts1=0;
	 $representative2 = mysql_query("SELECT rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id ='".$_REQUEST["hq_name1"]."'");
	   
	while($R2=mysql_fetch_object($representative2)){
		$areawise2=mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE dist_id='".$R1->dis_id."' AND rep_id IN (".$R2->rep_id.") AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY dist_id");
		$R3=mysql_fetch_object($areawise2);
		$pts_value2='0';
		if($R3->PTS!=''){ $pts_value2=$R3->PTS; }
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pts_value2);
		$col++;

		$other_pts1=$other_pts1+$pts_value2;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $other_pts1);
	$row++;
}

$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC1");
$col++;

$HQTOTAL = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$DCHY->Stockist.") and rep_id IN (".$DCHY->rep_id.")");
$HQTOT=mysql_fetch_object($HQTOTAL); // HQ TOTAL

$CC1=0;

$HQCC1 = mysql_query("SELECT round(IFNULL(SUM(quantity),0),0) Q,round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id='".$CC1REP->id."' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND hq_id='".$_REQUEST["hq_name1"]."'");
$HQCC11=mysql_fetch_object($HQCC1); // HQ STK CC1 TOTAL

$YUCC1 = $HQTOT->PTS-$HQCC11->PTS;

$HQCC12 = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$DCHY->Stockist.") and rep_id IN (".$DCHY->rep_id.") group by rep_id");
while($HQCC112=mysql_fetch_object($HQCC12)){ // HQ STK CC1 REP TOTAL

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS*round(($HQCC112->PTS/$YUCC1)*100,0)/100,0));
	$CC2 = $CC2+round($HQCC11->PTS*round($HQCC11->PTS*round(($HQCC112->PTS/$YUCC1)*100,0)/100,0),0);
	$col++;
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($HQCC112->PTS/$YUCC1)*100,0));
	$col++;

}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS,0));
$row++;
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MEDPLUS");
$col++;
$MPTOT = 0;
$Medplus = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id='57' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");$MPLUS=mysql_fetch_object($Medplus);
$RepMP1=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 GROUP BY id"); // PRODUCT DETAILS	
while($RMP=mysql_fetch_object($RepMP1)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($MPLUS->PTS*$RMP->sales_credit/100,0));
	$col+=2;
	$MPTOT+=round(round($MPLUS->PTS*$RMP->sales_credit/100,0),0);	
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $MPTOT);
$row++;
$col=0; // INFILTRATION
$HQINFIL = mysql_query("SELECT infil_stockist Stockist,local_rep_id rep_id,infil_name FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]."");
while($HQI=mysql_fetch_object($HQINFIL)){

	$INFILCNT = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$HQI->rep_id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
	while($INCNT=mysql_fetch_object($INFILCNT)){
	if($INCNT->PTS>0){
	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($HQI->infil_name));
		$col++;
		$REPINFIL = mysql_query("SELECT id FROM representative WHERE id IN (".$HQI->rep_id.") GROUP BY id");
		while($REP1=mysql_fetch_object($REPINFIL)){
			$INFILTOT = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$REP1->id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
			while($HQI1=mysql_fetch_object($INFILTOT)){		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQI1->PTS,0));
				$col+=2;		
			}	
		}
		$INFILTOT1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$HQI->rep_id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
		$HQI11=mysql_fetch_object($INFILTOT1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQI11->PTS,0));
		$row++;$col=0;	
	}}  //CNT
}
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "RUPEEWISE VALUE");
$col=1;
$TOTAL = 0;
$Rep1=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 ORDER BY id"); // PRODUCT DETAILS    
while($R=mysql_fetch_object($Rep1)){	
		$Sales2 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."'");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$REPCC1HQ = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$DCHY->Stockist.") and rep_id IN (".$R->id.") group by rep_id");
		$REPCC1HQTOT=mysql_fetch_object($REPCC1HQ);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");	// REP TOTAL
		$col++;
		$Sales222 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (".$DCHY->Stockist.") and rep_id IN (".$DCHY->rep_id.")");
		$S222=mysql_fetch_object($Sales222);
		if($S222->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}	
		if($S222->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S2->Q/$S222->Q)*100,0));}	
		$col++;		
				
}





$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;


$other_pts1=0;
$representative3 = mysql_query("SELECT rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id IN (".$_REQUEST["hq_name1"].")");
while($R12=mysql_fetch_object($representative3)){
	$areawise21=mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE dist_id IN (".$DCHY->Stockist.") AND rep_id IN (".$R12->rep_id.") AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY bill_string");
	$R13=mysql_fetch_object($areawise21);
	$pts_value2='0';
	if($R13->PTS!=''){ $pts_value2=$R13->PTS; }
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pts_value2);
	$col++;

	$other_pts1=$other_pts1+$pts_value2;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $other_pts1);


//$yuvaraj->setActiveSheetIndex(2);
//$yuvaraj->getActiveSheet()->setTitle("CONSOLIDATED $HEADQUARTERNAME HQ");
//$DCHEMIST = mysql_query("SELECT local_stockist Stockist,local_rep_id rep_id FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]." GROUP BY headquarters_id");
//$DCHY=mysql_fetch_object($DCHEMIST);
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "CONSOLIDATED VALUE COVERED BY LOCAL HQ STOCKISTS WITH INFIL, CC1 & MEDPLUS");
//
//$col=0;$row=2;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST");
//$col=1;	
//$Representative=mysql_query("SELECT rep_name FROM representative WHERE id IN (".$rep_id.") ORDER BY id"); // PRODUCT DETAILS	
//while($R=mysql_fetch_object($Representative)){
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->rep_name));	
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "%");	
//	$col++;
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ TOTAL");
//$col++;
//
//
//// OTHER HQ
//$OHQ1 = mysql_query("SELECT infil_stockist,rep_id FROM tbl_headquarters_infiltration WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
//while($OHQ_ROW1 = mysql_fetch_array($OHQ1)){
//	$other_stockist[]=$OHQ_ROW1['infil_stockist'];
//	$other_repid[]=$OHQ_ROW1['rep_id'];
//}
//$oth_stock=implode(",",$other_stockist);
//$oth_rep=implode(",",$other_repid);
//
//$representative = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
//while($R=mysql_fetch_object($representative)){
//	$row=2;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->headquarters_name));
//	$col++;
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "OTHERS TOTAL");
//$col++;
//
//
//$HQSTK = mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (".$stockist1.")");
//$dist = array();
//$col=0;$row=3;
//$Distributor=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$stockist1.")"); // PRODUCT DETAILS	
//while($D=mysql_fetch_object($Distributor)){
//	
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
//	$row++;
//}
//$row=3;$col=1;
//$DistributorS=mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (".$stockist1.")"); // PRODUCT DETAILS	
//while($DS=mysql_fetch_object($DistributorS)){
//	$col=1;
//	$Representative1=mysql_query("SELECT id FROM representative WHERE id IN (".$rep_id.") ORDER BY id"); // PRODUCT DETAILS	
//	while($R=mysql_fetch_object($Representative1)){	
//			$Sales = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' AND dist_id='".$DS->dis_id."'");
//			$S=mysql_fetch_object($Sales);		
//			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->Q,0));	
//			$col++;
//			$Sales12 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$rep_id.")");
//	$S12=mysql_fetch_object($Sales12);
//			if($S12->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}			
//			if($S12->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->Q/$S12->Q)*100,0));}	
//			$col++;
//	}
//	
//	$Sales1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$rep_id.")");
//	$S1=mysql_fetch_object($Sales1);
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->Q,0));
//	$row++;
//}
//
//$prev_col=$col+1;
//$row=3;
//$Distributor = mysql_query("SELECT dis_id,dis_name FROM distributor WHERE dis_id IN (".$stockist1.")");
//while($R1=mysql_fetch_object($Distributor)){
//	$col=$prev_col;
//	$other_pts1=0;
//	$representative2 = mysql_query("SELECT rep_id FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
//	while($R2=mysql_fetch_object($representative2)){
//		$areawise2=mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE dist_id='".$R1->dis_id."' AND rep_id IN (".$R2->rep_id.") AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY dist_id");
//		$R3=mysql_fetch_object($areawise2);
//		$pts_value2='0';
//		if($R3->PTS!=''){ $pts_value2=$R3->PTS; }
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pts_value2);
//		$col++;
//
//		$other_pts1=$other_pts1+$pts_value2;
//	}
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $other_pts1);
//	$row++;
//}
//
//$col=0;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC1");
//$col++;
//
//$HQTOTAL = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$stockist1.") and rep_id IN (".$rep_id.")");
//$HQTOT=mysql_fetch_object($HQTOTAL); // HQ TOTAL
//
//$CC1=0;
//
//$HQCC1 = mysql_query("SELECT round(IFNULL(SUM(quantity),0),0) Q,round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id=0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$stockist1.")");
//$HQCC11=mysql_fetch_object($HQCC1); // HQ STK CC1 TOTAL
//
//$YUCC1 = $HQTOT->PTS-$HQCC11->PTS;
//
//$HQCC12 = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$stockist1.") and rep_id IN (".$rep_id.") group by rep_id");
//while($HQCC112=mysql_fetch_object($HQCC12)){ // HQ STK CC1 REP TOTAL
//
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS*floor(($HQCC112->PTS/$YUCC1)*100)/100,0));
//	$col++;
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, floor(($HQCC112->PTS/$YUCC1)*100));
//	$col++;
//
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS,0));
//$row++;
//$col=0;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MEDPLUS");
//$col++;
//$MPTOT = 0;
//$Medplus = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id='57' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");$MPLUS=mysql_fetch_object($Medplus);
//$RepMP1=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$rep_id.") GROUP BY id"); // PRODUCT DETAILS	
//while($RMP=mysql_fetch_object($RepMP1)){
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($MPLUS->PTS*$RMP->sales_credit/100,0));
//	$col+=2;
//	$MPTOT+=round(round($MPLUS->PTS*$RMP->sales_credit/100,0),0);	
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $MPTOT);
//$row++;
//$col=0; // INFILTRATION
//$HQINFIL = mysql_query("SELECT infil_stockist Stockist,local_rep_id rep_id,infil_name FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]."");
//while($HQI=mysql_fetch_object($HQINFIL)){
//
//	$INFILCNT = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$HQI->rep_id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
//	while($INCNT=mysql_fetch_object($INFILCNT)){
//	if($INCNT->PTS>0){
//	
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($HQI->infil_name));
//		$col++;
//		$REPINFIL = mysql_query("SELECT id FROM representative WHERE id IN (".$HQI->rep_id.") GROUP BY id");
//		while($REP1=mysql_fetch_object($REPINFIL)){
//			$INFILTOT = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$REP1->id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
//			while($HQI1=mysql_fetch_object($INFILTOT)){		
//				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQI1->PTS,0));
//				$col+=2;		
//			}	
//		}
//		$INFILTOT1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$HQI->rep_id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
//		$HQI11=mysql_fetch_object($INFILTOT1);
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQI11->PTS,0));
//		$row++;$col=0;	
//	}}  //CNT
//}
//$col=0;
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "RUPEEWISE VALUE");
//$col=1;
//$TOTAL = 0;
//$Rep1=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$rep_id.") ORDER BY id"); // PRODUCT DETAILS	
//while($R=mysql_fetch_object($Rep1)){	
//		$Sales2 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."'");
//		$S2=mysql_fetch_object($Sales2);
//		$TOTAL+=$S2->Q;	
//		$REPCC1HQ = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id in (".$stockist1.") and rep_id IN (".$R->id.") group by rep_id");
//		$REPCC1HQTOT=mysql_fetch_object($REPCC1HQ);
//		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");	// REP TOTAL
//		$col++;
//		$Sales222 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (".$stockist1.") and rep_id IN (".$rep_id.")");
//		$S222=mysql_fetch_object($Sales222);
//		if($S222->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}	
//		if($S222->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S2->Q/$S222->Q)*100,0));}	
//		$col++;		
//				
//}
//
//
//
//
//
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($TOTAL+$CC1+$MPTOT,0));
//$col++;
//
//
//$other_pts1=0;
//$representative3 = mysql_query("SELECT rep_id FROM mst_headquarters WHERE headquarters_id IN (SELECT headquarter_id FROM representative WHERE id IN ($oth_rep))");
//while($R12=mysql_fetch_object($representative3)){
//	$areawise21=mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE dist_id IN (".$stockist1.") AND rep_id IN (".$R12->rep_id.") AND bill_string='".date("F Y",strtotime($_REQUEST["from_date"]))."' GROUP BY bill_string");
//	$R13=mysql_fetch_object($areawise21);
//	$pts_value2='0';
//	if($R13->PTS!=''){ $pts_value2=$R13->PTS; }
//	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $pts_value2);
//	$col++;
//
//	$other_pts1=$other_pts1+$pts_value2;
//}
//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $other_pts1);
//
///////////////////////////////////////// Sheet 3 ////////////////////////////////////////////////
//
/*$yuvaraj->setActiveSheetIndex(3);
$yuvaraj->getActiveSheet()->setTitle("CONSOLIDATED $HEADQUARTERNAME HQ");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME STOCKISTWISE SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

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
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$stockist1.") ORDER BY id"); // PRODUCT DETAILS	
while($D=mysql_fetch_object($Dist)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($D->dis_name));	
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "TOTAL");

$row=3;$col=2;
$ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$stockist1.") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id='".$R->dis_id."'");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S->Q,0);	
				$col++;
		}
		$PSales1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' and dist_id IN (".$stockist1.")");
		$S1=mysql_fetch_object($PSales1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S1->Q,0);
		$col=2;$row++;
}

$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col=2;
$TOTAL = 0;
$DistributorTOT1=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$stockist1.") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."' ");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $S2->Q,0);	
		$col++;		
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
//
//
$yuvaraj->setActiveSheetIndex(4); // DETAILED REPORT
$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME STOCKIST PRODUCT DETAILS");
$DCHEMIST = mysql_query("SELECT local_stockist Stockist,local_rep_id rep_id FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]." GROUP BY headquarters_id");
$DCHY=mysql_fetch_object($DCHEMIST);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME HQ STOCKISTWISE DETAILED SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

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
$Dist=mysql_query("SELECT dis_name FROM distributor WHERE dis_id IN (".$stockist1.") ORDER BY id"); // PRODUCT DETAILS	
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

$row=3;$col=2;
$ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		$Representative2=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$stockist1.") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND dist_id='".$R->dis_id."'");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->Q,0));	
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->PTS,0));	
				$col++;
				$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."'");
				$S2=mysql_fetch_object($Sales2);
				if($S2->PTS==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
				if($S2->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->PTS/$S2->PTS)*100,0));}	
				$col++;
		}
		$PSales1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."'  and  dist_id IN (".$stockist1.")");
		$S1=mysql_fetch_object($PSales1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->Q,0));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->PTS,0));
		$col=2;$row++;
}

$Sales3 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'  and  dist_id IN (".$stockist1.")");
$S32=mysql_fetch_object($Sales3);


$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "STOCKIST VALUE");
$col=2;
$TOTAL = 0;
$DistributorTOT1=mysql_query("SELECT dis_id FROM distributor WHERE dis_id IN (".$stockist1.") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$R->dis_id."'");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");	
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");	
		$col++;
		if($S32->PTS==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
		if($S32->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");}	
		$col++;	
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;	
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
//
$yuvaraj->setActiveSheetIndex(5); // NETSALES REPORT
$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME REP PRODUCT Q");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME HQ REPWISE PRODUCTWISE SALES FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$col=0;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRODUCT");
$col=1;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "UNITS");
$col=2;$row=2;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PRICE");

$col=3;$row=2;	
$Dist=mysql_query("SELECT rep_name FROM representative WHERE id IN (".$rep_id.") ORDER BY id"); // PRODUCT DETAILS	
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


$col=1;	$row=3;
$Representative=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($Representative)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pts));	
	$row++;
}



$row=3;$col=3;
$ProductSales=mysql_query("SELECT id FROM product"); // PRODUCT DETAILS	
while($PS=mysql_fetch_object($ProductSales)){
		$Representative2=mysql_query("SELECT id FROM representative WHERE id IN (".$rep_id.") ORDER BY id"); // PRODUCT DETAILS	
		while($R=mysql_fetch_object($Representative2)){	
				$Sales = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' AND rep_id='".$R->id."' and dist_id IN (".$stockist1.")");
				$S=mysql_fetch_object($Sales);		
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->Q,0));	
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->PTS,0));	
				$col++;
				$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (".$stockist1.")");
				$S2=mysql_fetch_object($Sales2);
				if($S2->PTS==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
				if($S2->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->PTS/$S2->PTS)*100,1));}	
				$col++;
		}
		$PSales1 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND our_product_id='".$PS->id."' and dist_id IN (".$stockist1.") and rep_id IN (".$rep_id.")");
		$S1=mysql_fetch_object($PSales1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->Q,0));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->PTS,0));
		$col=3;$row++;
}

$Sales3 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and dist_id IN (".$stockist1.") and rep_id IN (".$rep_id.")");
$S32=mysql_fetch_object($Sales3);


$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "REPRESENTATIVE VALUE");
$col=3;
$TOTAL = 0;
$DistributorTOT1=mysql_query("SELECT id FROM representative WHERE id IN (".$rep_id.") ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($DistributorTOT1)){	
		$Sales2 = mysql_query("SELECT IFNULL(SUM(quantity),0) Q,IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' and dist_id IN (".$stockist1.")");
		$S2=mysql_fetch_object($Sales2);
		$TOTAL+=$S2->Q;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S2->Q,0));	
		$col++;	
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S2->PTS,0));	
		$col++;
		if($S32->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S2->PTS/$S32->PTS)*100,1));}
		if($S32->PTS>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}
		$col++;	
				
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($TOTAL,0));
$col++;	
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S32->PTS,0));
//
//
 $yuvaraj->setActiveSheetIndex(6);
 $yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME REP PRODUCT DETAILS");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "PRODUCT");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 1, "STOCKIST");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 1, "STOCKIST Q");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 1, "OTHER HQ");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 1, "CHEMIST");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 1, "PINCODE");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 1, "AREA");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 1, "CHEMIST Q");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 1, "PTS");
 $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 1, "MR NAME");
 $col=0;$row=2;	
 $PRODUCT = mysql_query("SELECT id,pro_name FROM product");
 while($Prod=mysql_fetch_object($PRODUCT)){ // PRODUCT
 	$Stockist_CNT12017 = mysql_query("SELECT sum(areawise_temp.quantity) Q,ROUND(sum(areawise_temp.quantity*areawise_temp.pts),0) PTS FROM `areawise_temp` WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$stockist1.") AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.")");$Prod2017=mysql_fetch_object($Stockist_CNT12017);

 	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Prod->pro_name)." [Q: ".$Prod2017->Q.", PTS:".$Prod2017->PTS."]");
 	$col++;	
 	$Stockist_CNT = mysql_query("SELECT distributor.dis_name DNAME,areawise_temp.dist_id dist_id,sum(areawise_temp.quantity) Q FROM `areawise_temp`,distributor WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$stockist1.") AND `areawise_temp`.dist_id=distributor.dis_id AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$rep_id.") group by areawise_temp.`dist_id`");
 	while($Stockist=mysql_fetch_object($Stockist_CNT)){  // STOCKIST
 		$col=1;
 		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->DNAME));		
 		$col++;		
 		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($Stockist->Q));
 		$col++;	
 		$DCHEMISTR11 = mysql_query("SELECT rep_id,infil_name FROM `tbl_headquarters_infiltration` WHERE `headquarters_id`=".$_REQUEST["hq_name1"]."");
 		while($DCHYR1=mysql_fetch_object($DCHEMISTR11)){
 			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR1->Q));
 			$col++;
 			$col=3;
 			$Stockist_CNT10 = mysql_query("SELECT sum(areawise_temp.quantity) Q FROM `areawise_temp` WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$Stockist->dist_id.") AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$DCHYR1->rep_id.")");
 			while($DCHYR10=mysql_fetch_object($Stockist_CNT10)){
 				if($DCHYR10->Q>0){
 					$col=3;
 					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR1->infil_name)." ".strtoupper($DCHYR10->Q));		
 					$Stockist_CNT120 = mysql_query("SELECT ifnull((select rep_name from representative where id=areawise_temp.rep_id),'vacant') as rep_name,cust_name,area_id,sum(areawise_temp.quantity) Q,ROUND(sum(areawise_temp.quantity*areawise_temp.pts),0) PTS FROM `areawise_temp` WHERE areawise_temp.`our_product_id`='".$Prod->id."' and areawise_temp.`dist_id` in (".$Stockist->dist_id.") AND areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id IN (".$DCHYR1->rep_id.") GROUP BY cust_name,pincode");
 					while($DCHYR120=mysql_fetch_object($Stockist_CNT120)){
 						$col=4;
 						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->cust_name));
 						$col++;
 						$AREA = mysql_query("SELECT pincode_list.pincode PINCODE,pincode_list.area_name AREA,master_district.district_name DISTNAME FROM pincode_list,master_district WHERE pincode_list.id=".$DCHYR120->area_id." AND pincode_list.dist_id=master_district.district_id");
 						$A=mysql_fetch_object($AREA);
 						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->PINCODE));
 						$col++;
 						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($A->AREA).", ".strtoupper($A->DISTNAME));
 						$col++;
 						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->Q));
 						$col++;
 						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->PTS));
 						$col++;
 						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($DCHYR120->rep_name));
 						$row++;
 					}		
 					$col=3;
 					$row++;
 				}
 				$col=3;
 			}
 		}
 	}
 	$col=0;
 }*/
 
// 
$yuvaraj->setActiveSheetIndex(7); // INFIL IN CHEMISTWISE DETAILS
$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME INFIL IN DETAILS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME INFIL IN CHEMISTWISE DETAILS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "HQ");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "PINCODE");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "CHEMIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "STOCKIST");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 2, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 2, "QTY");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 2, "PTS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 2, "MR NAME");
 $col = 0; $row = 3;

 $MASTER = mysql_query("SELECT group_concat(DISTINCT pin_id) Pincode,ifnull(group_concat(DISTINCT rep_id),'Vacant') Rep,group_concat(DISTINCT dist_id) Stockist, ifnull((select headquarters_name from distributor,mst_headquarters where distributor.dis_id=areawise_temp.dist_id and distributor.headquarters_id=mst_headquarters.headquarters_id),'VACANT') HQ, sum(quantity) Q, round(sum(quantity*pts),0) PTS FROM `areawise_temp` WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') and dist_id  IN (SELECT `dis_id` FROM `distributor` WHERE `headquarters_id` IN (".$_REQUEST["hq_name1"].")) AND rep_id NOT IN (SELECT `id` FROM `representative` WHERE `headquarter_id` IN (".$_REQUEST["hq_name1"]."))group by HQ HAVING sum(quantity) > 0");
	while($Y = mysql_fetch_object($MASTER)){
		$HQTOTAL = mysql_query("SELECT round(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$Y->Stockist.") AND rep_id IN (".$Y->Rep.") and (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') ");
		$HQTOTALY = mysql_fetch_object($HQTOTAL);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Y->HQ." [ TOTAL SALE : ".$HQTOTALY->PTS." ]");
		$col++;
		$PIN_ID = explode(",",$Y->Pincode);
		foreach($PIN_ID as $PINID){
			$col = 1;
			$PINCODE_DETAILS = mysql_query("SELECT pincode_list.pincode,pincode_list.area_name,master_district.district_name FROM pincode_list,master_district WHERE pincode_list.pin_id = ".$PINID." and pincode_list.dist_id=master_district.district_id GROUP BY pincode_list.pin_id");
			$PINCODEDETAILS = mysql_fetch_object($PINCODE_DETAILS);
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PINCODEDETAILS->pincode." [ ".strtoupper($PINCODEDETAILS->area_name).", ".strtoupper($PINCODEDETAILS->district_name)." ]");
			$col++;
								
			// Chemist
			$CHEMIST_DETAILS = mysql_query("SELECT cust_name,our_cust_id,sum(quantity) Q, round(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE (bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND pin_id = ".$PINID." AND rep_id IN (".$Y->Rep.") AND dist_id IN (".$Y->Stockist.") group by our_cust_id,pin_id");
			while($CHEMISTDETAILS=mysql_fetch_object($CHEMIST_DETAILS)){
				$col = 2;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($CHEMISTDETAILS->cust_name)." [ Q : ".$CHEMISTDETAILS->Q.", PTS : ".$CHEMISTDETAILS->PTS." ] ");
				$col++;
				$STOCKIST_DETAILS = mysql_query("SELECT areawise_temp.dist_id,distributor.dis_name FROM areawise_temp,distributor WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.pin_id = ".$PINID." AND areawise_temp.our_cust_id IN (".$CHEMISTDETAILS->our_cust_id.") AND areawise_temp.rep_id IN (".$Y->Rep.") AND areawise_temp.dist_id IN (".$Y->Stockist.") AND areawise_temp.dist_id=distributor.dis_id group by areawise_temp.dist_id");
				while($STOCKISTDETAILS=mysql_fetch_object($STOCKIST_DETAILS)){
					$col = 3;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($STOCKISTDETAILS->dis_name));
					$col++;
					
					$PRODUCT_DETAILS = mysql_query("SELECT (SELECT pro_name FROM product WHERE product.id=areawise_temp.our_product_id) PNAME,sum(quantity) Q, round(SUM(quantity*pts),0) PTS,(SELECT rep_name FROM representative WHERE representative.id=areawise_temp.rep_id) REP FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."') AND areawise_temp.pin_id = ".$PINID." AND areawise_temp.our_cust_id IN (".$CHEMISTDETAILS->our_cust_id.") AND areawise_temp.rep_id IN (".$Y->Rep.") AND areawise_temp.dist_id IN (".$STOCKISTDETAILS->dist_id.") group by areawise_temp.our_product_id,areawise_temp.our_cust_id,areawise_temp.pin_id");
					while($PRODUCTDETAILS=mysql_fetch_object($PRODUCT_DETAILS)){
						$col = 4;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($PRODUCTDETAILS->PNAME));
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PRODUCTDETAILS->Q);
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PRODUCTDETAILS->PTS);
						$col++;
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($PRODUCTDETAILS->REP));
						$row++;
					}				
					//$row++;
				}
				
				$row++;$col = 2;
			}						
			$row++;$col = 1;
						
		}
		$row++;$col = 0;
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