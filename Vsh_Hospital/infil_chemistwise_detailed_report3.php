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
$HQNAME = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
$HQN = mysql_fetch_object($HQNAME);
$HEADQUARTERNAME = strtoupper($HQN->headquarters_name);

$CC1_REP = mysql_query("SELECT id FROM representative WHERE headquarter_id = ".$_REQUEST["hq_name1"]." AND cc1 = 1");
$CC1REP=mysql_fetch_object($CC1_REP);

//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(2);
$yuvaraj->getActiveSheet()->setTitle("CONSOLIDATED $HEADQUARTERNAME HQ");

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

// OTHER HQ - NAME - START
$representative = mysql_query("SELECT infil_name headquarters_name FROM tbl_headquarters_infiltration WHERE headquarters_id ='".$_REQUEST["hq_name1"]."'");
while($R=mysql_fetch_object($representative)){
	$row=2;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->headquarters_name));
	$col++;
}
// OTHER HQ - NAME - END
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
$row=3;$col=1;$repArrayValues=array();$totalRepValues=0;
$DistributorS=mysql_query("SELECT dis_name,dis_id FROM distributor WHERE dis_id IN (".$DCHY->Stockist.")"); // PRODUCT DETAILS	
while($DS=mysql_fetch_object($DistributorS)){
	$col=1;
	$Representative1=mysql_query("SELECT id FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 ORDER BY id"); // PRODUCT DETAILS	
	while($R=mysql_fetch_object($Representative1)){	
			$Sales = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND rep_id='".$R->id."' AND dist_id='".$DS->dis_id."'");
			$S=mysql_fetch_object($Sales);		
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S->Q,0));	

			if($row==3) :
				$repArrayValues[$R->id] = round($S->Q,0);
			else :
				$repArrayValues[$R->id] += round($S->Q,0);
			endif;

			$col++;
			$Sales12 = mysql_query("SELECT ROUND(IFNULL(SUM(quantity*pts),0),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$DCHY->rep_id.")");
	$S12=mysql_fetch_object($Sales12);
	
	//echo "<br />$S12->Q-$S->Q";
	
			if($S12->Q==0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);}			
			if($S12->Q>0){$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($S->Q/$S12->Q)*100,0));}	
			$col++;
	}
	
	$Sales1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) Q FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id='".$DS->dis_id."' and rep_id IN (".$DCHY->rep_id.")");
	$S1=mysql_fetch_object($Sales1);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($S1->Q,0));

	$totalRepValues += round($S1->Q,0);

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


//////////////////////////////////////////////////////////////////// YUVARAJ CC1 CODE ///////////////////////////////////////////////////////////////////
/*$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC1");
$col++;
echo "<br />SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'  and rep_id IN (".$DCHY->rep_id.")"; exit;
$HQTOTAL = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'  and rep_id IN (".$DCHY->rep_id.")");
$HQTOT=mysql_fetch_object($HQTOTAL); // HQ TOTAL

$CC1=0;

$HQCC1 = mysql_query("SELECT round(IFNULL(SUM(quantity),0),0) Q,round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id='".$CC1REP->id."' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$HQCC11=mysql_fetch_object($HQCC1); // HQ STK CC1 TOTAL

$YUCC1 = $HQTOT->PTS-$HQCC11->PTS; // REPRESENTATIVE PERCENTAGE CALCULATION REPTOT / HQTOT - CC1TOT

$HQCC12 = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (".$DCHY->rep_id.")  group by rep_id");
while($HQCC112=mysql_fetch_object($HQCC12)){ // HQ STK CC1 REP TOTAL

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS*round(($HQCC112->PTS/$YUCC1)*100,2)/100,2));
	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($HQCC112->PTS/$YUCC1)*100,2));
	$col++;

}*/



$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "CC1");
$col++;

$HQTOTAL = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id>0 AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'  and rep_id IN (".$DCHY->rep_id.")");
$HQTOT=mysql_fetch_object($HQTOTAL); // HQ TOTAL

$CC1=0;

$HQCC1 = mysql_query("SELECT round(IFNULL(SUM(quantity),0),0) Q,round(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE rep_id='".$CC1REP->id."' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$HQCC11=mysql_fetch_object($HQCC1); // HQ STK CC1 TOTAL


$HQCC12 = mysql_query("SELECT round(IFNULL(SUM(quantity*pts),0),0) PTS, rep_id as id FROM areawise_temp WHERE bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (".$DCHY->rep_id.")  group by rep_id");
while($HQCC112=mysql_fetch_object($HQCC12)){ // HQ STK CC1 REP TOTAL

	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS*round(($HQCC112->PTS/$HQTOT->PTS)*100,2)/100,2));

	$repArrayValues[$HQCC112->id] += round($HQCC11->PTS*round(($HQCC112->PTS/$HQTOT->PTS)*100,2)/100,2);

	$col++;	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($HQCC112->PTS/$HQTOT->PTS)*100,2));
	$col++;

}



$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQCC11->PTS,0));

$totalRepValues += round($HQCC11->PTS,0);

$row++;
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "MEDPLUS");
$col++;
$MPTOT = 0;
$Medplus = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE rep_id='57' AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");$MPLUS=mysql_fetch_object($Medplus);
$RepMP1=mysql_query("SELECT id,sales_credit FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 GROUP BY id"); // PRODUCT DETAILS	
while($RMP=mysql_fetch_object($RepMP1)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($MPLUS->PTS*$RMP->sales_credit/100,0));

	$repArrayValues[$RMP->id] += round($MPLUS->PTS*$RMP->sales_credit/100,0);

	$col+=2;
	$MPTOT+=round(round($MPLUS->PTS*$RMP->sales_credit/100,0),0);	
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $MPTOT);

$totalRepValues += $MPTOT;

$row++;


 // INFILTRATION - Checking
$col = 0;
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

				$repArrayValues[$REP1->id] += round($HQI1->PTS,0);

				$col+=2;		
			}	
		}
		$INFILTOT1 = mysql_query("SELECT IFNULL(SUM(quantity*pts),0) PTS FROM areawise_temp WHERE dist_id IN (".$HQI->Stockist.") AND rep_id IN (".$HQI->rep_id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
		$HQI11=mysql_fetch_object($INFILTOT1);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($HQI11->PTS,0));

		$totalRepValues += round($HQI11->PTS,0);
		
		$row++;$col=0;	
	}}  //CNT
}

// Checking - End


///////////////////////////////////////////////////////////////////// YUVARAJ RUPEEWISE CODE //////////////////////////////////////////////////////////////
/*
$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "RUPEEWISE VALUE");
$col=1;
$TOTAL = 0;
$Rep1=mysql_query("SELECT id FROM representative WHERE id IN (".$DCHY->rep_id.") and cc1 = 0 ORDER BY id"); // PRODUCT DETAILS	
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


*/



$col=0;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "RUPEEWISE VALUE");
$col=1;
$TOTAL = 0;
$repExplode = explode(",", $DCHY->rep_id);	
for($o = 0; $o < count($repExplode); $o ++) :
	if(array_key_exists($repExplode[$o], $repArrayValues)) :
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $repArrayValues[$repExplode[$o]] );
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($repArrayValues[$repExplode[$o]]/$totalRepValues)*100,2));
		$col++;
	else :
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col++;
	endif;

endfor;





$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  $totalRepValues);
$col++;


//
//# INFIL DETAILS - START
//
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

/*$yuvaraj->setActiveSheetIndex(3);
$HQNAME = mysql_query("SELECT headquarters_name FROM mst_headquarters WHERE headquarters_id='".$_REQUEST["hq_name1"]."'");
$HQN = mysql_fetch_object($HQNAME);
$HEADQUARTERNAME = strtoupper($HQN->headquarters_name);
$yuvaraj->getActiveSheet()->setTitle("$HEADQUARTERNAME MRWISE SALES");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "$HEADQUARTERNAME Consolidated MR sales Report Quantity with Value ".date("F Y",strtotime($_REQUEST["from_date"])));
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "PRODUCT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "UNIT");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 2, "PTS");

$REP11 = mysql_query("SELECT group_concat(id) rep_id FROM representative WHERE headquarter_id in (".$_REQUEST["hq_name1"].")");
$REPALL=mysql_fetch_object($REP11);

$REP2 = mysql_query("SELECT group_concat(dis_id) rdist_id FROM distributor WHERE headquarters_id IN (".$_REQUEST["hq_name1"].")");
$REPSTK=mysql_fetch_object($REP2);

$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='0' and dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$CC=mysql_fetch_object($CommonCredit);



// TOTAL HQ SUM

$CommonCreditSTK = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (".$REPALL->rep_id.")");
$CCSTK=mysql_fetch_object($CommonCreditSTK);



$col=0;	$row=3;
$PRODUCT=mysql_query("SELECT id,pro_name,packing,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R=mysql_fetch_object($PRODUCT)){
	$col=0;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pro_name));	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->packing));
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($R->pts));	
	$row++;
}
$col=3;	$row=2;
$REPRESENTATIVE=mysql_query("SELECT rep_name FROM representative  WHERE headquarter_id='".$_REQUEST["hq_name1"]."' ORDER BY id"); // PRODUCT DETAILS	
while($REP=mysql_fetch_object($REPRESENTATIVE)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($REP->rep_name)." Q");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($REP->rep_name)." PTS");	
	$col++;
}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ Q");	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "HQ PTS");	
	$col++;
$col=3;$row=3;
$PRODUCT1=mysql_query("SELECT id,pts FROM product ORDER BY id"); // PRODUCT DETAILS	
while($R1=mysql_fetch_object($PRODUCT1)){
	
	$REPRESENTATIVE1=mysql_query("SELECT id,rep_name,sales_credit FROM representative  WHERE headquarter_id='".$_REQUEST["hq_name1"]."' ORDER BY id"); // PRODUCT DETAILS	
	while($REP1=mysql_fetch_object($REPRESENTATIVE1)){
	
	
		$SALESDETAILS = mysql_query("SELECT IFNULL(SUM(quantity),0) Q, ROUND(IFNULL(SUM(quantity*pts),0),0) PTS FROM areawise_temp WHERE our_product_id = '".$R1->id."' AND rep_id IN (".$REP1->id.") AND bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
		$SALES=mysql_fetch_object($SALESDETAILS); // MR SALES
		
		$SALESDETAILS1 = mysql_query("SELECT IFNULL(SUM(medplus_qty),0) Q,round(IFNULL(SUM(medplus_pts),0),0) PTS FROM tbl_medplus WHERE medplus_product_id = '".$R1->id."' AND medplus_rep_id IN (".$REP1->id.") AND medplus_billdate BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
		$SALES1=mysql_fetch_object($SALESDETAILS1); // MR SALES
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $SALES->Q+$SALES1->Q);
		$TOTQ+=$SALES->Q+$SALES1->Q;
		$col++;		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($R1->pts*($SALES->Q),0)+$SALES1->PTS);
		$TOTPTS+=round($R1->pts*($SALES->Q),0)+$SALES1->PTS;
		$col++;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTQ);	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $TOTPTS);	
	$col++;
	$TOTQ = 0;$TOTPTS = 0;
	$row++;$col=3;
}
$col=0;$row++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, $row, "Stockist Total");
$col=3;
$REPRESENTATIVE2=mysql_query("SELECT id,rep_name,sales_credit FROM representative  WHERE headquarter_id='".$_REQUEST["hq_name1"]."' ORDER BY id"); // PRODUCT DETAILS	
while($REP1=mysql_fetch_object($REPRESENTATIVE2)){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
		$col++;
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row,  "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;*/



//prepare download
$filename=" CONSOLIDATED $HEADQUARTERNAME HQ ".date("d/m/Y H:i:s").".csv"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>