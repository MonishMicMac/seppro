<?php
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
//include PHPExcel library
require_once "Classes/PHPExcel/IOFactory.php";
session_start();
include("include/connect.php");
include("include/function.php");

//load Excel template file
    $yuvaraj = PHPExcel_IOFactory::load("yuvaraj.xls");
    $yuvaraj->setActiveSheetIndex(0);  //set first sheet as active
    $yuvaraj->getActiveSheet()->mergeCells('A1:M1');

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 1, $_SESSION["CNAME"]);
    $yuvaraj->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
    $yuvaraj->getActiveSheet()->getRowDimension(1)->setRowHeight(17);
    $yuvaraj->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $yuvaraj->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
    mytemplate_design_bg('A1:M1','9d9b9b');
    mytemplate_design_fcolor('A1:M1','FFFFFF');

    $repname=mysql_query("SELECT rep_name FROM representative WHERE id='".@$_REQUEST['repid']."' ");
        $repname_row=mysql_fetch_array($repname);

    $yuvaraj->getActiveSheet()->mergeCells('A2:M2');
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 2, $repname_row['rep_name'].'_'."CUSTOMER LIST REPORT");
    $yuvaraj->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
    $yuvaraj->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);
    $yuvaraj->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
    $yuvaraj->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "S.NO");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(35);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "DOCTOR NAME");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(30);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "DOCTOR CATEGORY");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(30);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "AREA");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(30);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "ADDRESS");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(25);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "PINCODE");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(20);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "TERRITORY");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(20);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(7, 3, "SPECIALITY");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(30);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(8, 3, "CHEMIST");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(20);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(9, 3, "DOB");
    $yuvaraj->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(25);
    $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow(10, 3, "ANNIVERSARY");
    
    $yuvaraj->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //A3 until C4 is vertically top-aligned
    $yuvaraj->getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true);
    $yuvaraj->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
    $yuvaraj->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $yuvaraj->getActiveSheet()->freezePane('A4');   
    mytemplate_design_bg('A3:M3','eceeef'); 

    $row = 4;   
    $i=1;

    // ----- ADDED LEFT JOIN TO FETCH AREA NAME -----
    if($_REQUEST['repid']=='')
    {
        $a=mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id WHERE doctors.doctor_name!='' ")or die(mysql_error());
    }
    else{
        $a=mysql_query("SELECT doctors.*, pincode_list.area_name FROM doctors LEFT JOIN pincode_list ON pincode_list.id = doctors.doc_area_id WHERE doctors.doctor_name!='' AND doctors.rep_id='".@$_REQUEST['repid']."'")or die(mysql_error());
    }

    while($y_customer=mysql_fetch_assoc($a)){
        
        // Lookup Chemist
        $current_doc_id = $y_customer['id'];
        $sql5bid = mysql_query("SELECT GROUP_CONCAT(DISTINCT shop_name SEPARATOR ', ') AS shop_name FROM tbl_customer_master WHERE FIND_IN_SET('$current_doc_id', doctor_id) > 0");
        $sql5bid_row = mysql_fetch_array($sql5bid); 

        // Lookup Speciality Name to avoid showing IDs in Excel
        $doc_spec_id = $y_customer['doc_specilist_id'];
        $speciality_name = $doc_spec_id; 
        if (is_numeric($doc_spec_id)) {
            $spec_query = mysql_query("SELECT specilist_name FROM specilist_list WHERE id = '$doc_spec_id'");
            if ($spec_query && mysql_num_rows($spec_query) > 0) {
                $spec_row = mysql_fetch_array($spec_query);
                $speciality_name = $spec_row['specilist_name'];
            }
        }

        if ($y_customer['managerapprovestatus'] == '0') { 
            $color = 'FFFFFF'; // white
        } elseif ($y_customer['managerapprovestatus'] == '1') {
            $color = 'FF0000'; // Red
        }

        mytemplate_design_bg('A' . $row . ':J' . $row, $color);

        $col=0;
        $yuvaraj->getActiveSheet()->getRowDimension($row)->setRowHeight(17);
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $i);
        $col++;
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["doctor_name"]);
        $col++;                     
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["doc_category"]);
        $col++; 
        
        // ----- CORRECTED TO SHOW area_name FROM THE JOIN -----
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["area_name"]);
        $col++;                     
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["doctor_addrs"]);
        $col++;                     
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["doc_pincode"]);
        $col++;                     
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["territory"]);
        $col++;  
        
        // ----- CORRECTED TO SHOW SPECIALITY NAME -----
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $speciality_name);
        $col++;                     
        
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $sql5bid_row['shop_name']);
        $col++;                     
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["dob"]);
        $col++;                     
        $yuvaraj->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $y_customer["anniversary"]);
        $row++;

        $i++;
    }
    
    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    
    $row=$row-1;
    $yuvaraj->getActiveSheet()->getStyle('A1:A'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('B1:B'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('C1:C'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('D1:D'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('E1:E'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('F1:F'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('G1:G'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('H1:H'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('I1:I'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('J1:J'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('K1:K'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('L1:L'.$row)->applyFromArray($styleArray);
    $yuvaraj->getActiveSheet()->getStyle('M1:M'.$row)->applyFromArray($styleArray);

    $full_name = $repname_row["rep_name"];

    $name_place=    explode('(', $full_name);

    $name_part_exp = explode(' ', $name_place[0]);

    $name = $name_part_exp[0];

    // Ensure array index 1 exists before trying to access it to prevent errors
    $place = isset($name_place[1]) ? str_replace(")","",$name_place[1]) : '';

    $rep_name_new = $name . '-'. $place ;

    $yuvaraj->getActiveSheet()->getStyle('M1:M'.$row)->getAlignment()->setWrapText(true); 
    if($_REQUEST['repid']=='')
    {

    }else{
        // $yuvaraj->getActiveSheet()->setTitle($repname_row["rep_name"]);
        $yuvaraj->getActiveSheet()->setTitle(substr($rep_name_new, 0, 31)); // Excel sheet names have a 31 char limit
    }

    //prepare download
    $filename="Customer List.xls"; //just some random filename
    header('Content-Type: application/vnd.ms-excel');
    if($_REQUEST['repid']=='')
    {
        header('Content-Disposition: attachment;filename="clientlist.xls"');
    }
    else
    {
        header('Content-Disposition: attachment;filename="'.$repname_row['rep_name'].'clientlist.xls"');

    }
    header('Cache-Control: max-age=0');
    
    $objWriter = PHPExcel_IOFactory::createWriter($yuvaraj, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
    $objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
    
    exit; //done.. exiting!

?>