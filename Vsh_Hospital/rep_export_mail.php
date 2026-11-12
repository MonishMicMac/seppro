<?php
//connect the database
require("Classes/PHPExcel/IOFactory.php");
require("include/connect.php");

$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");

$_REQUEST["from_date"]=date("Y/m",strtotime($_REQUEST["from_date"]))."/01";
$MDATE = mysql_query("select LAST_DAY(date_add('".$_REQUEST["from_date"]."',interval 0 month)) LastDay");
$R_MDATE=mysql_fetch_object($MDATE);
$totq=0;$tot=0;

if(@$_REQUEST["submit"]=="REP"){

$yuvaraj->setActiveSheetIndex(1);
$yuvaraj->getActiveSheet()->setTitle("REP STOCKISTWISE DETAILS");
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "STOCKISTWISE SALES MADE FOR EACH PRODUCT FOR THE MONTH OF ".date("F Y",strtotime($_REQUEST["from_date"])));

$Covering_STK = mysql_query("SELECT group_concat(distinct dist_id) as D FROM `areawise_temp` WHERE rep_id IN (".$_REQUEST["rep_name"].")");
$STK=mysql_fetch_object($Covering_STK);

// reprsentative details

$REP1 = mysql_query("SELECT group_concat(id) rep_id FROM representative WHERE headquarter_id in (SELECT `headquarter_id` FROM `representative` WHERE `id` IN (".$_REQUEST["rep_name"]."))");
$REPALL=mysql_fetch_object($REP1);

$REP = mysql_query("SELECT rdist_id,id FROM representative WHERE id IN (".$_REQUEST["rep_name"].")");
$REPSTK=mysql_fetch_object($REP);

$CommonCredit = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='0' and dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
$CC=mysql_fetch_object($CommonCredit);
$common = $CC->TOT;$commonQ = $CC->Q;

// TOTAL HQ SUM

$CommonCreditSTK = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE dist_id IN (".$REPSTK->rdist_id.") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' and rep_id IN (".$REPALL->rep_id.")");
$CCSTK=mysql_fetch_object($CommonCreditSTK);
$commonSTK = $CCSTK->TOT;



// CC1 CALCULATING

$CommonCreditMR = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE rep_id IN (".$_REQUEST["rep_name"].") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."' AND dist_id IN (".$REPSTK->rdist_id.")");
$CCMR=mysql_fetch_object($CommonCreditMR);
$commonMR = $CCMR->TOT;

$MRVALUEPERCENTAGE = round($CC->TOT*round(($CCMR->TOT/$CCSTK->TOT)*100,0)/100,0);



$CommonCredit1 = mysql_query("SELECT round(SUM(quantity),0) AS Q, round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE `rep_id`='57' and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");
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
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $MRVALUEPERCENTAGE);
$col++;
$REPMP = mysql_query("SELECT rep_name,sales_credit FROM representative WHERE id IN (".$_REQUEST["rep_name"].")");$RMP=mysql_fetch_object($REPMP);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(($common1*$RMP->sales_credit/100),0));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "=SUM(".getNameFromNumber($col)."3:".getNameFromNumber($col).($row-1).")");
$col++;
$REPTOTALF = mysql_query("SELECT round(SUM(quantity*pts),0) TOT FROM `areawise_temp` WHERE rep_id IN (".$_REQUEST["rep_name"].") and bill_date BETWEEN '".$_REQUEST["from_date"]."' AND '".date("Y/m/d",strtotime($R_MDATE->LastDay))."'");$repfinal=mysql_fetch_object($REPTOTALF);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($repfinal->TOT,0)+$MRVALUEPERCENTAGE+round(($common1*$RMP->sales_credit/100),0));
$col++;

$REPORTNAME = $RMP->rep_name."_Stockistwise";

}


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


$filename=$REPORTNAME.'_Sales_Report_'.date("d-m-Y H:i:s").'.csv'; //just some random filename

$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
 
$objWriter->save(str_replace(__FILE__,$_SERVER['DOCUMENT_ROOT'] .'excelformat/'.$filename,__FILE__));
echo "success";
//exit; //done.. exiting!


?>