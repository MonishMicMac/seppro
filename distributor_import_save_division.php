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

//$rep_id=$_POST['rep_id'];

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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='distributor_import_next_division.php?last_id=".$last_id."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 
 $doc_pincode=$_POST['doc_pincode'];
 $dis_name=$_POST['dis_name'];
 $cus_name=$_POST['cus_name'];
 $mob=$_POST['mob'];
 $state=$_POST['state'];
 $address=$_POST['address'];

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
global $doc_pincode,$dis_name,$cus_name,$mob,$state,$address,$record_id;

$doc_pincode1=isset($sheet['cells'][$x][$doc_pincode]) ? $sheet['cells'][$x][$doc_pincode] : '';
$doc_pincode2=str_replace("'", "", $doc_pincode1);

$shop_name1=isset($sheet['cells'][$x][$dis_name]) ? $sheet['cells'][$x][$dis_name] : '';
$shop_name2=str_replace("'", "", $shop_name1);

$cus_name1=isset($sheet['cells'][$x][$cus_name]) ? $sheet['cells'][$x][$cus_name] : '';
$cus_name2=str_replace("'", "", $cus_name1);

$mob1=isset($sheet['cells'][$x][$mob]) ? $sheet['cells'][$x][$mob] : '';
$mob2=str_replace("'", "", $mob1);

$state1=isset($sheet['cells'][$x][$state]) ? $sheet['cells'][$x][$state] : '';
$state2=str_replace("'", "", $state1);

$address1=isset($sheet['cells'][$x][$address]) ? $sheet['cells'][$x][$address] : '';
$address2=str_replace("'", "", $address1);

$pc=mysql_query("select pincode,pin_id,district_id from master_pincode where pincode='$doc_pincode2' ")or die(mysql_error());
$row_pc=mysql_fetch_array($pc);
$pinid=$row_pc['pin_id'];
$di_id=$row_pc['district_id'];

$sc=mysql_query("select state_id,state_name from master_state where state_name='$state2' ")or die(mysql_error());
$row_sc=mysql_fetch_array($sc);
$state_id=$row_sc['state_id'];

	$res = mysql_query("select * from distributor order by convert(dis_id, decimal) desc limit 1");
$row = mysql_fetch_array($res);

if(mysql_num_rows($res)>0)
{
	$dis_id = $row['dis_id']+1;
}
else{
	$dis_id = 1;
}

$d=mysql_query("select dis_name,corp_pin from distributor where dis_name='$shop_name2' and corp_pin='$doc_pincode2'");
$count_d=mysql_num_rows($d);
if($count_d>0) {
	
	echo "<script type=text/javascript>alert('Please check in Excel $shop_name2 Details already Stored in database.');</script>";
}
else
	{
	 mysql_query("insert into  distributor(dis_name,alternate_no1,corp_pin,state_id,dis_id,corp_addr,dis_pin_id)values('$shop_name2','$mob2','$doc_pincode2','$state_id','$dis_id','$address2','$pinid')")or die(mysql_error());
	 
$last_id1=mysql_insert_id();
mysql_query("insert into  tbl_cds_master(tbl_cds_dcsid,tbl_cds_pinid,tbl_cds_areaid,tbl_cds_stateid,tbl_cds_districtid,tbl_cds_pincode,tbl_cds_status)values('$last_id1','$pinid','$pinid','$state_id','$di_id','$doc_pincode2','S')")or die(mysql_error());
}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 

echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='distributor_import_division.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
mysql_query("DELETE FROM import_excel_record WHERE id='$record_id' ");

mysql_query("DELETE FROM temp_excel_heading WHERE excel_id='$record_id'");
}
?>