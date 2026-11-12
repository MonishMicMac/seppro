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

$rep_id=$_REQUEST['rep_id1'];
if (strtolower(substr($fname_ext,-3,3)) == "xls") {
    $excel->read($_FILES["excel_file"]["tmp_name"]);
    function sheetData($sheet,$head_no,$rep_id) {
        $week_day=array('1' => "Monday1",'2' => "Tuesday1",'3' => "Wednesday1",'4' => "Thursday1",'5' => "Friday1",'6' => "Saturday1",'7' => "Monday2",'8' => "Tuesday2",'9' => "Wednesday2",'10' => "Thursday2",'11' => "Friday2",'12' => "Saturday2");


        mysql_query("DELETE FROM mst_tour_plan WHERE wp_rep_id='$rep_id'");

        $x=$head_no;

        while($x <= $sheet['numRows']){
            // print_r('gh');exit();
            if($$sheet['numRows']!=$head_no){
                // print_r($sheet['cells'][$x][2]);exit();
                // print_r($wp_dc_id);exit();
                $h=4;
                foreach ($week_day as $day) {
                  

                    if($sheet['cells'][$x][$h]==1){
                         
                        if($sheet['cells'][$x][2]!=''){
                            // print_r($sheet['cells'][$x][2]);exit();
                            $wp_dc_id=$sheet['cells'][$x][2];
                            // print_r($wp_dc_id);exit();

                            mysql_query("INSERT INTO mst_tour_plan(wp_day,wp_dc_id,wp_rep_id,c_date,c_time)VALUES('$day','$wp_dc_id','$rep_id',CURDATE(),CURTIME())");
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
    sheetData($excel->sheets[$i],$head_no,$rep_id); 

    echo "<script type=text/javascript>alert('File Uploaded Succssfully');window.location='master_tp_report1.php';</script>";
} else {
    echo "<script type=text/javascript>alert('File type should be XLS');window.location='master_tp_report1.php';</script>";
}
?>