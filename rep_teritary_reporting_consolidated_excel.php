<?php
//include PHPExcel library
session_start();
require_once "Classes/PHPExcel/IOFactory.php";
include("include/connect.php");
include("include/function.php");
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 15000);
//load Excel template file
$yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
$yuvaraj->setActiveSheetIndex(0);  //set first sheet as active

$yuvaraj->getActiveSheet()->mergeCells('A1:H1');
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["marketer"]);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$yuvaraj->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
mytemplate_design_fcolor('A1:H1','FFFFFF');
mytemplate_design_bg('A1:H1','9d9b9b');


$_REQUEST["from_date"]=$_REQUEST["from_date"]."/01";
$_REQUEST["to_date"]=$_REQUEST["to_date"]."/28";

$yuvaraj->getActiveSheet()->mergeCells('A2:H2');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, "Period: ".date("M y",strtotime($_REQUEST["from_date"]))." TO ".date("M y",strtotime($_REQUEST["to_date"])));
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setShrinkToFit(true);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A4 until C4 is vertically top-aligned
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
$yuvaraj->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A2:H2','0e7cd8');

$col=0;
$row=3;
$MDifference=mysql_query("SELECT TIMESTAMPDIFF(MONTH, '".$_REQUEST["from_date"]."', '".$_REQUEST["to_date"]."') AS MONTH");$MDiff=mysql_fetch_object($MDifference);
if($MDiff->MONTH==0){$MDiff->MONTH=1;}
$SQL = "select DATE_FORMAT(m1, '%Y/%m/%d') AS S, LAST_DAY(DATE_ADD(DATE_FORMAT(m1, '%Y/%m/%d'), INTERVAL 0 MONTH)) S1 from (select 
('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."' - INTERVAL DAYOFMONTH('".date("Y-m-d",strtotime($_REQUEST["from_date"]))."')-1 DAY) +INTERVAL m MONTH as m1 from (select @rownum:=@rownum+1 as m from (select 1 union select 2 union select 3 union select 4) t1, (select 1 union select 2 union select 3 union select 4) t2, (select 1 union select 2 union select 3 union select 4) t3, (select 1 union select 2 union select 3 union select 4) t4, (select @rownum:=-1) t0 ) d1 ) d2  where m1<='".date("Y-m-d",strtotime($_REQUEST["to_date"]))."' order by m1";
$Monthwise=mysql_query($SQL);
	
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30);
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':H'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':H'.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor('A'.$col.':H'.$row,'0e7cd8');

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "ALL HQ");
$col++;
while($M=mysql_fetch_object($Monthwise)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("M y",strtotime($M->S)));
	$col++;
}
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Average");
$col++;

$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Target");
$Target=mysql_query($SQL);
while($T=mysql_fetch_object($Target)){
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Primary Sales");
$PSales=mysql_query($SQL);
while($PS=mysql_fetch_object($PSales)){
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Secondary Sales");
$SSales=mysql_query($SQL);
while($SS=mysql_fetch_object($SSales)){
	$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($SS->S))."' AND '".date("Y/m/d",strtotime($SS->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
	while($PTSValue=mysql_fetch_object($PTS)){ @$SSPTS+=$PTSValue->PTS;
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PTSValue->PTS);
	}
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSPTS));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSPTS/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Free");
$Free=mysql_query($SQL);
while($F=mysql_fetch_object($Free)){
	$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(free_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($F->S))."' AND '".date("Y/m/d",strtotime($F->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
	while($FValue=mysql_fetch_object($PTS)){@$SSF+=$FValue->F;
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $FValue->F);
	}
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSF));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSF/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sale Return");
$Replace=mysql_query($SQL);
while($R=mysql_fetch_object($Replace)){
	$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(replace_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R->S))."' AND '".date("Y/m/d",strtotime($R->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
	while($RValue=mysql_fetch_object($PTS)){ @$SSR+=$RValue->F;
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RValue->F);
	}
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSR));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSR/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Net Sales");
$NSales=mysql_query($SQL);
while($NS=mysql_fetch_object($NSales)){
	$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) - IFNULL(ROUND(SUM(free_quantity),0),0) NETVALUE FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($NS->S))."' AND '".date("Y/m/d",strtotime($NS->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
	while($NValue=mysql_fetch_object($PTS)){ $SS+=$NValue->NETVALUE;
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $NValue->NETVALUE);
	}
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SS));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SS/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sec value (Rs.) Growth (%)");
$Growth=mysql_query($SQL);
while($G=mysql_fetch_object($Growth)){
				// Prev Month Sale
				$Prev=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($G->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($G->S))."',interval -1 month)) LastDay");
				$PSale=mysql_fetch_object($Prev);

				$PS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale->LastDay))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
				$PPTS=mysql_fetch_object($PS);
				// Current Month Sale
				$CSale=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($G->S))."' AND '".date("Y/m/d",strtotime($G->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
				$CPTS=mysql_fetch_object($CSale);
				$col++;
				//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(((($CPTS->PTS-$PPTS->PTS)/$PPTS->PTS)*100))."%");
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0%");
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0%");
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0%");
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "No of Growth Products");
$GProducts=mysql_query($SQL);
while($PTS5=mysql_fetch_object($GProducts)){
				// Prev Month Sale
				$Prev1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -1 month)) LastDay");
				$PSale1=mysql_fetch_object($Prev1);

				$PS1=mysql_query("SELECT IFNULL(COUNT(our_product_id),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$PCNT=mysql_num_rows($PS1);
				
				if(empty($PCNT)){$PPTS=0;}
				if(!empty($PCNT)){$PPTS1=mysql_fetch_object($PS1);$PPTS=$PPTS1->Q;}
				// Current Month Sale
				$CSale1=mysql_query("SELECT IFNULL(COUNT(our_product_id),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS5->S))."' AND '".date("Y/m/d",strtotime($PTS5->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
					
				$CCNT=mysql_num_rows($CSale1);
				if(empty($CCNT)){$CPTS=0;}
				if(!empty($CCNT)){$CPTS1=mysql_fetch_object($CSale1);$CPTS=$CPTS1->Q;}
				$col++;
				@$GrowthProducts+=abs($PPTS-$CPTS);
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, abs($PPTS-$CPTS));
				
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$GrowthProducts));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$GrowthProducts/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "No of Degrowth Products");
$DGProducts=mysql_query($SQL);
while($PTS6=mysql_fetch_object($DGProducts)){
				// Prev Month Sale
				$Prev1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS6->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS6->S))."',interval -1 month)) LastDay");
				$PSale1=mysql_fetch_object($Prev1);

				$PS1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$PCNT=mysql_num_rows($PS1);
				
				if(empty($PCNT)){$PPTS=0;}
				if(!empty($PCNT)){$PPTS1=mysql_fetch_object($PS1);$PPTS=$PPTS1->Q;}
				// Current Month Sale
				$CSale1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS6->S))."' AND '".date("Y/m/d",strtotime($PTS6->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
				$CCNT=mysql_num_rows($CSale1);
				if(empty($CCNT)){$CPTS=0;}
				if(!empty($CCNT)){$CPTS1=mysql_fetch_object($CSale1);$CPTS=$CPTS1->Q;}
				$col++;
				@$DGrowthProducts+=abs($PPTS-$CPTS);
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, abs($PPTS-$CPTS));	
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$DGrowthProducts));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$DGrowthProducts/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "No of Products under Nil Sales");
$NILProducts=mysql_query($SQL);
while($PTS11=mysql_fetch_object($NILProducts)){
	$SS3=mysql_query("SELECT COUNT(id) AS NILPROD FROM product WHERE id NOT IN (SELECT our_product_id FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS11->S))."' AND '".date("Y/m/d",strtotime($PTS11->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' GROUP BY our_product_id)"); while($NetValue=mysql_fetch_object($SS3)){
			$col++;
			@$Nilproducts+=$NetValue->NILPROD;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $NetValue->NILPROD);
	}
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Nilproducts));
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Nilproducts/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Target Vs Achievement (%)");
$TAProducts=mysql_query($SQL);
while($PTS12=mysql_fetch_object($TAProducts)){
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
}
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);

// PRODUCTS LIST
$col=0;
$row+=3;

$PMonthwise=mysql_query($SQL);
	
$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30);
$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor($row,'0e7cd8');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "ALL HQ");
$col++;
while($M=mysql_fetch_object($PMonthwise)){
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("M y",strtotime($M->S)));
	$col++;
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");
$col++;
$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Average");
$row++;

$col=0;
$product=mysql_query("SELECT id,pro_name FROM product");while($prod=mysql_fetch_object($product)){
	$Qty=0;	
	$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($prod->pro_name));	
	$col++;
	$QProducts=mysql_query($SQL);
	
	 while($M1=mysql_fetch_object($QProducts)){
				$CSale1=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$prod->id."'");
				
				$CPTS1=mysql_fetch_object($CSale1);
				@$Qty+=$CPTS1->Q;				
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CPTS1->Q);
				$col++;			
	}
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$Qty);	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Qty/$MDiff->MONTH,0));
	$col=0;
	$row++;
	
}
$col=0;
$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor($row,'ED3237');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total QTY");
$col++;
$TOTALQ=mysql_query($SQL);
while($M1=mysql_fetch_object($TOTALQ)){
				$CSaleA2=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!=''");
				$CPTS1=mysql_fetch_object($CSaleA2);
				@@$Qty+=$CPTS1->Q;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CPTS1->Q);
				$col++;	
}
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$Qty);	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Qty/$MDiff->MONTH,0));
$col=0;
$row++;
$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
mytemplate_design_fcolor($row,'ED3237');
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PTS VALUE");
$col++;
$AVGQ=mysql_query($SQL);
while($M1=mysql_fetch_object($AVGQ)){
				$CSaleA2=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts)),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND areawise_temp.our_product_id=product.id");
				$CPTS1=mysql_fetch_object($CSaleA2);
				@$PTS+=$CPTS1->PTS;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($CPTS1->PTS,0));
				$col++;	
}

$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$PTS);	
$col++;
$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$PTS/$MDiff->MONTH,0));
$col=0;
$styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );

$yuvaraj->getActiveSheet()->getStyle('A1:B1')->applyFromArray($styleArray);
$row+=2;

// TERITARY WISE REPORT

$Teritary=mysql_query("SELECT * FROM mst_tertiary WHERE teritary_rep_id='".$_REQUEST["rep"]."'"); // Teritarywise
$TCnt=mysql_num_rows($Teritary);
if($TCnt>0){		
	while($T=mysql_fetch_object($Teritary)){ 
		@$TID=$T->tertiary_id;
		@$TNAME=$T->tertiary_name;
		
		$TMonthwise=mysql_query($SQL);
	
		$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30);
		$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		mytemplate_design_fcolor($row,'0e7cd8');
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$TNAME);
		$col++;
		while($M=mysql_fetch_object($TMonthwise)){
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("M y",strtotime($M->S)));
			$col++;
		}
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Average");
			
		$col=0;
		$row++;
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Target");
		$Target=mysql_query($SQL);
		while($T=mysql_fetch_object($Target)){
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Primary Sales");
		$PSales=mysql_query($SQL);
		while($PS=mysql_fetch_object($PSales)){
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Secondary Sales");
		$SSales=mysql_query($SQL);
		while($SS=mysql_fetch_object($SSales)){
			$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($SS->S))."' AND '".date("Y/m/d",strtotime($SS->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");@$SSPTS=0;
			while($PTSValue=mysql_fetch_object($PTS)){ @$SSPTS+=$PTSValue->PTS;
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $PTSValue->PTS);
			}
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSPTS));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSPTS/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Free");
		$Free=mysql_query($SQL);
		while($F=mysql_fetch_object($Free)){
			$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(free_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($F->S))."' AND '".date("Y/m/d",strtotime($F->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
			@$SSF=0;
			while($FValue=mysql_fetch_object($PTS)){ @$SSF+=$FValue->F;
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $FValue->F);
			}
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSF));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSF/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sale Return");
		$Replace=mysql_query($SQL);
		while($R=mysql_fetch_object($Replace)){
			$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(replace_quantity),0),0) F FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($R->S))."' AND '".date("Y/m/d",strtotime($R->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");@$SSR=0;
			while($RValue=mysql_fetch_object($PTS)){ @$SSR+=$RValue->F;
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $RValue->F);
			}
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSR));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SSR/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Net Sales");
		$NSales=mysql_query($SQL);
		while($NS=mysql_fetch_object($NSales)){
			$PTS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) - IFNULL(ROUND(SUM(free_quantity),0),0) NETVALUE FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($NS->S))."' AND '".date("Y/m/d",strtotime($NS->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");@$SS=0;
			while($NValue=mysql_fetch_object($PTS)){ @$SS+=$NValue->NETVALUE;
				$col++;
				$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $NValue->NETVALUE);
			}
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SS));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$SS/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Sec value (Rs.) Growth (%)");
		$Growth=mysql_query($SQL);
		while($G=mysql_fetch_object($Growth)){
						// Prev Month Sale
						$Prev=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($G->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($G->S))."',interval -1 month)) LastDay");
						$PSale=mysql_fetch_object($Prev);
		
						$PS=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale->LastDay))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
						$PPTS=mysql_fetch_object($PS);
						// Current Month Sale
						$CSale=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts),0),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($G->S))."' AND '".date("Y/m/d",strtotime($G->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id");
						$CPTS=mysql_fetch_object($CSale);
						$col++;
						//$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(((($CPTS->PTS-$PPTS->PTS)/$PPTS->PTS)*100))."%");
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0%");
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0%");
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "0%");
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "No of Growth Products");
		$GProducts=mysql_query($SQL);
		@$GrowthProducts=0;
		while($PTS5=mysql_fetch_object($GProducts)){
						// Prev Month Sale
						$Prev1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS5->S))."',interval -1 month)) LastDay");
						$PSale1=mysql_fetch_object($Prev1);
		
						$PS1=mysql_query("SELECT IFNULL(COUNT(our_product_id),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
						$PCNT=mysql_num_rows($PS1);
						
						if(empty($PCNT)){$PPTS=0;}
						if(!empty($PCNT)){$PPTS1=mysql_fetch_object($PS1);$PPTS=$PPTS1->Q;}
						// Current Month Sale
						$CSale1=mysql_query("SELECT IFNULL(COUNT(our_product_id),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS5->S))."' AND '".date("Y/m/d",strtotime($PTS5->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
							
						$CCNT=mysql_num_rows($CSale1);
						if(empty($CCNT)){$CPTS=0;}
						if(!empty($CCNT)){$CPTS1=mysql_fetch_object($CSale1);$CPTS=$CPTS1->Q;}
						$col++;
						@$GrowthProducts+=abs($PPTS-$CPTS);
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, abs($PPTS-$CPTS));
						
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$GrowthProducts));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$GrowthProducts/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "No of Degrowth Products");
		$DGProducts=mysql_query($SQL);
		@$DGrowthProducts=0;
		while($PTS6=mysql_fetch_object($DGProducts)){
						// Prev Month Sale
						$Prev1=mysql_query("select date_add(LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS6->S))."',interval -2 month)), interval 1 day) FirstDay, LAST_DAY(date_add('".date("Y/m/d",strtotime($PTS6->S))."',interval -1 month)) LastDay");
						$PSale1=mysql_fetch_object($Prev1);
		
						$PS1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PSale1->FirstDay))."' AND '".date("Y/m/d",strtotime($PSale1->LastDay))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
						$PCNT=mysql_num_rows($PS1);
						
						if(empty($PCNT)){$PPTS=0;}
						if(!empty($PCNT)){$PPTS1=mysql_fetch_object($PS1);$PPTS=$PPTS1->Q;}
						// Current Month Sale
						$CSale1=mysql_query("SELECT IFNULL(COUNT(quantity),0) Q  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS6->S))."' AND '".date("Y/m/d",strtotime($PTS6->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id=product.id GROUP BY our_product_id");
						$CCNT=mysql_num_rows($CSale1);
						if(empty($CCNT)){$CPTS=0;}
						if(!empty($CCNT)){$CPTS1=mysql_fetch_object($CSale1);$CPTS=$CPTS1->Q;}
						$col++;
						@$DGrowthProducts+=abs($PPTS-$CPTS);
						$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, abs($PPTS-$CPTS));	
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$DGrowthProducts));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$DGrowthProducts/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "No of Products under Nil Sales");
		$NILProducts=mysql_query($SQL);
		@$Nilproducts=0;
		while($PTS11=mysql_fetch_object($NILProducts)){
			$SS3=mysql_query("SELECT COUNT(id) AS NILPROD FROM product WHERE id NOT IN (SELECT our_product_id FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($PTS11->S))."' AND '".date("Y/m/d",strtotime($PTS11->S1))."') AND teritary_id='".$TID."' AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' GROUP BY our_product_id)"); while($NetValue=mysql_fetch_object($SS3)){
					$col++;
					@$Nilproducts+=$NetValue->NILPROD;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $NetValue->NILPROD);
			}
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Nilproducts));
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Nilproducts/$MDiff->MONTH,0));
		$col=0;
		$row++;
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Target Vs Achievement (%)");
		$TAProducts=mysql_query($SQL);
		while($PTS12=mysql_fetch_object($TAProducts)){
			$col++;
			$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		}
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 0);
	}
	
	
	// PRODUCTS LIST
	$col=0;
	$row+=3;
	
	$TPMonthwise=mysql_query($SQL);
	$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);	
	$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	mytemplate_design_fcolor($row,'0e7cd8');
	$yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30);
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$TNAME);
	$col++;
	while($M=mysql_fetch_object($TPMonthwise)){
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, date("M y",strtotime($M->S)));
		$col++;
	}
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total");
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Average");
	$row++;
	
	$col=0;
	
	$product=mysql_query("SELECT id,pro_name FROM product");while($prod=mysql_fetch_object($product)){
		$Qty=0;	
		$yuvaraj->getActiveSheet()->getStyle('A'.$col.':A'.$row)->getFont()->setBold(true);
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($prod->pro_name));	
		$col++;		
		$QProducts=mysql_query($SQL);
		 while($M1=mysql_fetch_object($QProducts)){
					$CSale1=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND our_product_id='".$prod->id."'");
					$CPTS1=mysql_fetch_object($CSale1);
					@$Qty+=$CPTS1->Q;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CPTS1->Q);	
					$col++;			
		}		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$Qty);	
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Qty/$MDiff->MONTH,0));
		$col=0;
		$row++;
		
	}
	$col=0;
	$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	mytemplate_design_fcolor($row,'ED3237');
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Total QTY");
	$col++;
	@$Qty=0;
	$TOTALQ=mysql_query($SQL);
	while($M1=mysql_fetch_object($TOTALQ)){
					$CSaleA2=mysql_query("SELECT IFNULL(SUM(quantity),0) Q  FROM areawise_temp WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!=''");
					$CPTS1=mysql_fetch_object($CSaleA2);
					@$Qty+=$CPTS1->Q;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $CPTS1->Q);
					$col++;	
	}
		
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$Qty);	
		$col++;
		$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$Qty/$MDiff->MONTH,0));
	$col=0;
	$row++;
	$yuvaraj->getActiveSheet()->getStyle($row)->getFont()->setBold(true);
	$yuvaraj->getActiveSheet()->getStyle($row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	mytemplate_design_fcolor($row,'ED3237');
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "PTS VALUE");
	$col++;
	$AVGQ=mysql_query($SQL);
	@$PTS=0;
	while($M1=mysql_fetch_object($AVGQ)){
					$CSaleA2=mysql_query("SELECT IFNULL(ROUND(SUM(quantity*pts)),0) PTS  FROM areawise_temp,product WHERE (areawise_temp.bill_date BETWEEN '".date("Y/m/d",strtotime($M1->S))."' AND '".date("Y/m/d",strtotime($M1->S1))."') AND rep_id='".$_REQUEST["rep"]."' AND our_cust_id!='' AND our_product_id!='' AND areawise_temp.our_product_id=product.id");
					$CPTS1=mysql_fetch_object($CSaleA2);
					@$PTS+=$CPTS1->PTS;
					$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round($CPTS1->PTS,0));
					$col++;
	}
	
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, @$PTS);	
	$col++;
	$yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, round(@$PTS/$MDiff->MONTH,0));
	$col=0;
	$row+=2;
	
	
}
//prepare download
$filename="Q-CHECK PHARMA_Repwise_report ".".xls"; //just some random filename
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
 
exit; //done.. exiting!

?>