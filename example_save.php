<?php
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 15000);

include("include/connect.php");
//include("function.php");
$command=$_POST['command'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');
include('excel_reader.php');
//require 'class.phpmailer.php';
//include("email_send.php");
$excel = new PhpExcelReader;


if($command=='insert_head_record')
{

$file_name=$_FILES["logo"]["name"];
$file_size=$_FILES["logo"]["size"];
$file_mb1=round(($file_size / 1048576), 2); // bytes to MB 
$file_mb=$file_mb1.'MB';
$ext = pathinfo($file_name, PATHINFO_EXTENSION);
$random_no=rand(10000000,99999999);

$head_no=$_POST['head_no'];
$state=$_POST['state_id'];

$target_path = "upload/";
$uploaded_files=$random_no."_".$_FILES['logo']['name'];
move_uploaded_file($_FILES['logo']['tmp_name'], $target_path .$random_no."_".$_FILES['logo']['name']);

mysql_query("insert into import_excel_record(sheet_name,excel_type,file_size,head_no,c_date,c_time)values('$uploaded_files','$ext','$file_mb','$head_no','$c_date','$c_time')")or die(mysql_error());

$last_id=mysql_insert_id();

$excel->read('upload/'.$uploaded_files);
function sheetData($sheet,$last_id,$head_no) 
{
$x = $head_no;
$y = 1;
while($y <= $sheet['numCols']) 
{
$cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
mysql_query("insert into temp_excel_heading(excel_id,heading,heading_no)values('$last_id','$cell','$y')");
$y++;
}  
$x++;
}
$nr_sheets = count($excel->sheets);
$excel_data = '';         
$i=0;
$excel_data .= sheetData($excel->sheets[$i],$last_id,$head_no);

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='example_next.php?last_id=".$last_id."&&state_id=".$state."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 $state=$_REQUEST['state_id'];

$district_name=$_POST['district'];

//echo "select * from excel_record where id='$record_id'";
$b=mysql_query("select * from import_excel_record where id='$record_id'")or die(mysql_error());
$row_b=mysql_fetch_array($b);
$file_name=$row_b['sheet_name'];
$head_no=$row_b['head_no'];


$excel->read('upload/'.$file_name);
function sheetData($sheet,$head_no) 
{
$x = $head_no+1;
$userData = array();
while($x <= $sheet['numRows']) 
{
global $district_name,$state,$record_id;

//$state_id1=isset($sheet['cells'][$x][$state_id]) ? $sheet['cells'][$x][$state_id] : '';
//$state_id2=str_replace("'", "", $state_id1);

$district_name1=isset($sheet['cells'][$x][$district_name]) ? $sheet['cells'][$x][$district_name] : '';
$district_name2=str_replace("'", "", $district_name1);
/*       Loop Based on Section name and Standard Name  Start*/
$d=mysql_query("select * from master_district where district_name='$district_name2' and state_id='$state' ");
$count_d=mysql_num_rows($d);
if($count_d>0) {
	
	echo "<script type=text/javascript>alert('Please check in Excel $district_name2 Details already Stored in database.');</script>";
}
else
	{
mysql_query("insert into  master_district(state_id,district_name )values
('$state','$district_name2')")or die(mysql_error());
$last_id1=mysql_insert_id();
mysql_query("insert into  district(state_id,dist_id,dist_name)values
('$state','$last_id1','$district_name2')")or die(mysql_error());

}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 

echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='example_send.php';</script>";


$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
mysql_query(" DELETE FROM import_excel_record WHERE id='$record_id' ");
mysql_query(" DELETE FROM temp_excel_heading WHERE excel_id='$record_id' ");
}
?>