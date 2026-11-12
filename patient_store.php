<?php
include("include/connect.php");
include("include/select.php");
session_start();
//error_reporting(0);
// print_r('tfdgfcfg');exit();
$id=$_SESSION['id'];
// print_r($id);exit();


$dis_shop_name=$_REQUEST['dis_shop_name']; 


$dis_cust_name=$_REQUEST['dis_cust_name'];

$dis_cust_no=$_REQUEST['dis_cust_no'];

$location=$_REQUEST['location'];

$drug_lic_no1=$_REQUEST['drug_lic_no1']; 


$drug_lic_no2=$_REQUEST['drug_lic_no2'];

$address=$_REQUEST['address'];



$date=date('Y-m-d');




$data = mysql_query("INSERT INTO patient_details(patient_name,contact_person,phone_no,location,disease_name,patient_details,address,c_date) 
VALUES('$dis_shop_name','$dis_cust_name','$dis_cust_no','$location','$drug_lic_no1','$drug_lic_no2','$address','$date')")or die(mysql_error());

echo "<script>alert('Add Successfully');window.location='../patient_menu.php';</script>";

if(isset($_REQUEST['id']))
{



$data = mysql_query("INSERT INTO nurse_assign(patient_id,nurse_id,nurse_name,c_date,remarks,created_at) 
VALUES('$ids','$rep_id','$nurse_name','$birthday','$remark','$date')")or die(mysql_error());




// $data = mysql_query("  UPDATE Customers)")or die(mysql_error());
	// $data=	mysql_query("");

  

}
else
{
// ini_set('memory_limit', '-1');
// print_r('jjmjk,kl,k,');exit();

ini_set('upload_max_filesize', '512M');
ini_set('post_max_size', '512M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 15000);

include("include/excel_reader.php");
include("encrypt.php");
$sess_id=$_SESSION['id'];
$command=$_POST['command'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');
$excel = new PhpExcelReader;

        if($command=='add_csv')
        {
               
			   $dist_id=$_POST['dist_id'];
                $file_name=$_FILES["excel_file"]["name"];
                $file_size=$_FILES["excel_file"]["size"];
                $file_temp=$_FILES['excel_file']['tmp_name'];
                $file_mb1=round(($file_size / 1048576), 2);
                $file_mb=$file_mb1."MB";
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $random_no=rand(10000000,99999999);
                $head_no=$_POST['head_no'];
                $uploaded_files=$random_no."_".$file_name;
                $target_path = "upload/";
                move_uploaded_file($file_temp, $target_path.$uploaded_files);
                mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','$dist_id','$uploaded_files','$file_mb','0','$sess_id','$c_date','$c_time','$ip_addr')")or die(mysql_error());
                $last_id=mysql_insert_id();
    ////////////////////////////////Function Starts/////////////////////////////
                function sheetData($sheet,$last_id,$head_no) 
                 {
                    $x = $head_no;
                    $y = 1;
                    while($y <= $sheet['numCols']) 
                    {
                    $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                    mysql_query("insert into excel_heading(record_id,heading_name,heading_no)values('$last_id','$cell','$y')");
                    $y++;
                    }  
                    $x++;
                 }
    ////////////////////////////////Function Ends/////////////////////////////// 
                $excel->read($target_path.$uploaded_files);
                $nr_sheets = count($excel->sheets);
                $excel_data = '';         
                $i=0;
                $excel_data .= sheetData($excel->sheets[$i],$last_id,$head_no);  
                echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='next_step.php?last_id=".$last_id."&from_date=".$_REQUEST["from_date"]."';</script>";

        }

}

