<?php
include("include/connect.php");
include("include/select.php");
session_start();
//error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$_SESSION["distributor"]=@$_POST['dist_id'];
$ad =new select1;
if(!isset($_SESSION['id']))
{
      echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{
ini_set('memory_limit', '-1');
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
                echo "<script type=text/javascript>alert('".$file_name." uploaded sucessfully');window.location.href='next_step_with_division.php?last_id=".$last_id."&from_date=".$_REQUEST["from_date"]."';</script>";

        }

}


//$file_name=$_FILES["excel_file"]["name"];
//            $file_size=$_FILES["excel_file"]["size"];
//            $file_mb1=round(($file_size / 1048576), 2); // bytes to MB 
//            $file_mb=$file_mb1.'MB';
//            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
//            $random_no=rand(10000000,99999999);
//            $user_id=$_POST['syst_id'];
//            $sess_id=$_POST['sess_id'];
//            $dist_id=$_POST['dist_id'];
//            $head_no=$_POST['head_no'];
//            $target_path = "upload/";
//            $uploaded_files=$random_no."_".$_FILES['excel_file']['name'];
//            move_uploaded_file($_FILES['excel_file']['tmp_name'], $target_path .$random_no."_".$_FILES['excel_file']['name']);
//
//            mysql_query("insert into excel_record(file_type,head_no,dist_id,file_name,file_size,uploaded_by,sess_id,c_date,c_time,ip_addr)values('$ext','$head_no','$dist_id','$uploaded_files','$file_mb','$user_id','$sess_id','$c_date','$c_time','$ip_addr')");
//
//            $last_id=mysql_insert_id();
//
//            $csv_file = 'upload/'.$uploaded_files;
//            //echo $csv_file;
//            $file = fopen($csv_file,"r");
//            feof($file);
//            $line_of_text= fgetcsv($file);
//            $numcols  = count($line_of_text);	
//            for ($c=0; $c < $numcols; $c++) 
//            {
//            $qq=$line_of_text[$c];
//            mysql_query("insert into excel_heading(record_id,heading_name,heading_no)values('$last_id','$qq','$c')");
//            }
//
//
//            echo "<script type=text/javascript>alert('Files Uploaded');window.location='next_step.php?last_id=$last_id&from_date=".$_REQUEST["from_date"]."';</script>";
