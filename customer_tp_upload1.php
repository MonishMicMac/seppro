<?php
session_start();
ini_set('memory_limit', '-1');
ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);
error_reporting(E_ALL);
include("include/connect.php");
require_once("include/select.php");

include 'excel_reader.php';
$excel = new PhpExcelReader;
$fname_ext = $_FILES["excel_file"]["name"];
$fname = $_FILES["excel_file"]["tmp_name"];
$chk_ext = explode(".", $fname_ext);
// error_reporting(E_ALL);
$rep_id=$_REQUEST['rep_id1'];
$last_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($_REQUEST["from_date"])),date("Y",strtotime($_REQUEST["from_date"])));

if (strtolower(substr($fname_ext,-3,3)) == "xls") {
    $excel->read($_FILES["excel_file"]["tmp_name"]);
    function sheetData($sheet,$head_no,$last_date,$rep_id) {
        mysql_query("DELETE FROM tbl_work_plan WHERE wp_rep_id='$rep_id' AND wp_date>CURDATE()");
        $x=$head_no;

        $sql_g=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='".$rep_id."' ORDER BY id DESC LIMIT 1");
        $row_g=mysql_fetch_array($sql_g);

        // print_r($row_g);exit();
        $last_date1=$row_g['last_date'];
        $last_day=substr($row_g['last_day'], -1);

        if($last_day!=''){
            $next_first_date=date("Y-m",strtotime($_REQUEST["from_date"]))."-01";
            $prev_first_date='';

            $d=1;
            while ($prev_first_date < $next_first_date) {
                $prev_day=date('l', strtotime($last_date1 . ' +'.$d.' day'));
                if($prev_day=='Sunday'){
                    if($last_day==1){
                        $last_day='2';
                    } elseif($last_day==2){
                        $last_day='1';
                    }
                }
                $prev_first_date=date('Y-m-d', strtotime($last_date1 . ' +'.$d.' day'));
                $d++;
            }
        } else {
            $last_day=1;
        }
        
        while($x <= $sheet['numRows']){
            $last=$last_day;
            if($x==$head_no){
                for ($h=4; $h < $last_date+4; $h++) {
                    $k=$sheet['cells'][$x][$h];
                    if($k<10){
                        $full_date[]=date("Y-m",strtotime($_REQUEST["from_date"])).'-0'.$k;
                    } else {
                        $full_date[]=date("Y-m",strtotime($_REQUEST["from_date"])).'-'.$k;
                    }
                }
            } else {
                $h=4;
                foreach ($full_date as $date) {
                    $day=date('l',strtotime($date));
                    $j=substr($date, -2);
                    if($day=='Sunday' && $j!='01'){
                        if($last=='1'){
                            $last=2;
                        } elseif($last=='2'){
                            $last=1;
                        }
                    }
                    $day_f=$day.$last;
// print_r($day);exit();
                    if($date>date('Y-m-d')){
                        if($sheet['cells'][$x][$h]==1){
                            if($sheet['cells'][$x][2]!=''){
                                $wp_dc_id=$sheet['cells'][$x][2];

                                $sql_g1=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='$rep_id' AND wp_dc_id='$wp_dc_id' AND wp_day='$day_f'");

                                
                                if(mysql_num_rows($sql_g1)>0){
                                    $ls_dy='1';
                                    $up_no='P';
                                } else {
                                    $ls_dy='0';
                                     $up_no='U';
                                }
                                mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,mtp,UP,c_date,c_time)VALUES('$date','D','$wp_dc_id','$rep_id','$ls_dy','$up_no',CURDATE(),CURTIME())");
                            }
                        }
                    }
                    $h++;
                }
            }
            $x++;
        }
    }
    $nr_sheets=count($excel->sheets);
    $excel_data='';
    $i=0;
    $head_no=3;
    sheetData($excel->sheets[$i],$head_no,$last_date,$rep_id); 
    echo "<script type=text/javascript>alert('File Uploaded Succssfully');window.location='customer_tp_report1.php';</script>";
} else {
    echo "<script type=text/javascript>alert('File type should be XLS');window.location='customer_tp_report1.php';</script>";
}
