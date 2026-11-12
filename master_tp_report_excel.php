<?php
require_once 'Classes/PHPExcel.php';
include("include/connect.php");
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('max_input_time', 300000000);
ini_set('max_execution_time', 150000000);
set_time_limit(0);

ob_end_clean();
header("Connection: close\r\n");
header("Content-Encoding: none\r\n");
ignore_user_abort(true);
ob_start();
echo "Loading";
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();
flush();
ob_end_clean();


$_REQUEST["from_date"]=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";

$cust_cnt_sql=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='".$_REQUEST["rep_id"]."' ORDER BY doctor_name ASC");
$cust_cnt=mysql_num_rows($cust_cnt_sql);

$sql3=mysql_query("SELECT rep_name FROM representative WHERE id='".$_REQUEST["rep_id"]."'");
$row3=mysql_fetch_array($sql3);

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("SWP Master");
$row=2; $col=0;

$last_date=13;

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $row3['rep_name']." - Master Work Plan");

$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setSize(13);
$objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(35);
$objPHPExcel->getActiveSheet()->getStyle(2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle(3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->freezePane('A4');

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

$objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
$objPHPExcel->getActiveSheet()->mergeCells('C2:C3');

$objPHPExcel->getActiveSheet()->mergeCells('A1:'.getNameFromNumber($last_date+1).'1');
$objPHPExcel->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.getNameFromNumber($last_date+1).'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);

$objPHPExcel->getActiveSheet()->getStyle('D2:'.getNameFromNumber($last_date+1).'2')->applyFromArray(
    array(
        'font'  => array(
         'color' => array('rgb' => 'ffffff')
         )
        )
    );

$objPHPExcel->getActiveSheet()->getStyle('D2:'.getNameFromNumber($last_date+1).'2')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '000000')
            )
        )
    );

$objPHPExcel->getActiveSheet()->getStyle('A2:C3')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'a6a6a6')
            )
        )
    );

$objPHPExcel->getActiveSheet()->getStyle('A2:C3')->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "S.NO");
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "ID");
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "NAME");
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Monday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "ffd966")
            )
        )
    );

$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Tuesday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "ffd966")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Wednesday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "ffd966")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Thursday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "ffd966")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Friday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "ffd966")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Saturday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "ffd966")
            )
        )
    );
$col++;


$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Monday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "a9d08e")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Tuesday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "a9d08e")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Wednesday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "a9d08e")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Thursday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "a9d08e")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Friday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "a9d08e")
            )
        )
    );
$col++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, "Saturday");
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'2:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
	array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => 'ffffff')
                )
            )
        )
    );

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth(11);

$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber($col).'3:'.getNameFromNumber($col).($cust_cnt+3))->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => "a9d08e")
            )
        )
    );
$col++;



$row++;
$col=3;
for ($i=0; $i <= $last_date; $i++) { 
	if($i>1){
		$t=$i-1;
		if($t<10){
			$date='0'.$t;
		} else {
			$date=$t;
		}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $date);
		$col++;
	}
}
$row++;

$z=1;
$col=0;
$last_date=12;
$week_day=array('1' => "Monday1",'2' => "Tuesday1",'3' => "Wednesday1",'4' => "Thursday1",'5' => "Friday1",'6' => "Saturday1",'7' => "Monday2",'8' => "Tuesday2",'9' => "Wednesday2",'10' => "Thursday2",'11' => "Friday2",'12' => "Saturday2");

$sql1=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='".$_REQUEST["rep_id"]."' ORDER BY doctor_name ASC");
while ($row1=mysql_fetch_array($sql1)) {
	$col=0;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $z);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row1['id']);
	$col++;
	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, strtoupper($row1['doctor_name']));
	$col++;
    for ($i=1; $i <= $last_date; $i++) { 
        $sql2=mysql_query("SELECT count(*) as cnt FROM mst_tour_plan WHERE wp_day='".$week_day[$i]."' AND wp_rep_id='".$_REQUEST["rep_id"]."' AND wp_dc_id='".$row1['id']."'");
        $row2=mysql_fetch_array($sql2);
        if($row2['cnt']==0){ $value=''; } else { $value='1'; }
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        $col++;
    }
    $row++;
    $z++;
}

$password=strtolower($_SESSION['CID'].$_SESSION['CNAME'].'@'.date('Y'));


$last_val_row=getNameFromNumber($last_date+2).($row-1);
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword($password);
$objPHPExcel->getActiveSheet()->getStyle('D4:'.$last_val_row)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

$font_style1 = array(
    'font'  => array(
        'size'  => 10
        )
    );

$font_style2 = array(
    'font'  => array(
        'name'  => 'Arial'
        )
    );

$objPHPExcel->getActiveSheet()->getStyle('A2:'.$last_val_row)->applyFromArray($font_style1);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$last_val_row)->applyFromArray($font_style2);


$filename=$row3['rep_name']." - Master Work Plan.xls";

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace(__FILE__,str_replace("\\","/",getcwd()) .'/download_excel/'.$filename,__FILE__));
$_SESSION['mst_file_name']=$filename;
$_SESSION['success_msg']="Success";
exit;

?>