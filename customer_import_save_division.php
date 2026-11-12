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

$rep_id=$_POST['rep_id'];

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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='customer_import_next_division.php?last_id=".$last_id."&&rep_id=".$rep_id."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 $rep_id=$_REQUEST['rep_id'];
 $district_name=$_POST['district'];
 $doc_pincode=$_POST['doc_pincode'];
 $shop_name=$_POST['shop_name'];
 $cus_name=$_POST['cus_name'];
 $mob=$_POST['mob'];
 $state=$_POST['state'];
 $cus_type=$_POST['cus_type'];
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
global $district_name,$doc_pincode,$shop_name,$cus_name,$mob,$state,$cus_type,$rep_id,$address,$record_id;

//$state_id1=isset($sheet['cells'][$x][$state_id]) ? $sheet['cells'][$x][$state_id] : '';
//$state_id2=str_replace("'", "", $state_id1);

$district_name1=isset($sheet['cells'][$x][$district_name]) ? $sheet['cells'][$x][$district_name] : '';
$district_name2=str_replace("'", "", $district_name1);

$doc_pincode1=isset($sheet['cells'][$x][$doc_pincode]) ? $sheet['cells'][$x][$doc_pincode] : '';
$doc_pincode2=str_replace("'", "", $doc_pincode1);

$shop_name1=isset($sheet['cells'][$x][$shop_name]) ? $sheet['cells'][$x][$shop_name] : '';
$shop_name2=str_replace("'", "", $shop_name1);

$cus_name1=isset($sheet['cells'][$x][$cus_name]) ? $sheet['cells'][$x][$cus_name] : '';
$cus_name2=str_replace("'", "", $cus_name1);

$mob1=isset($sheet['cells'][$x][$mob]) ? $sheet['cells'][$x][$mob] : '';
$mob2=str_replace("'", "", $mob1);


$state1=isset($sheet['cells'][$x][$state]) ? $sheet['cells'][$x][$state] : '';
$state2=str_replace("'", "", $state1);

$cus_type1=isset($sheet['cells'][$x][$cus_type]) ? $sheet['cells'][$x][$cus_type] : '';
$cus_type2=str_replace("'", "", $cus_type1);

$address1=isset($sheet['cells'][$x][$address]) ? $sheet['cells'][$x][$address] : '';
$address2=str_replace("'", "", $address1);


$ac=mysql_query("select district_name,district_id from master_district where district_name='$district_name2'")or die(mysql_error());
$row_ac=mysql_fetch_array($ac);
$dis=$row_ac['district_id'];


$pc=mysql_query("select pincode,pin_id from master_pincode where pincode='$doc_pincode2' ")or die(mysql_error());
$row_pc=mysql_fetch_array($pc);
$pinid=$row_pc['pin_id'];

$pc=mysql_query("select * from representative where id='$rep_id' ")or die(mysql_error());
$row_pc=mysql_fetch_array($pc);
$division_id=$row_pc['division_id'];

$sc=mysql_query("select state_id,state_name from master_state where state_name='$state2' ")or die(mysql_error());
$row_sc=mysql_fetch_array($sc);
$state_id=$row_sc['state_id'];

$d=mysql_query("select * from tbl_customer_master where shop_name='$shop_name2' and pincode='$doc_pincode2'");
$count_d=mysql_num_rows($d);
if($count_d>0) {
	
	echo "<script type=text/javascript>alert('Please check in Excel $shop_name2 Details already Stored in database.');</script>";
}

else
	{
		mysql_query("insert into  tbl_customer_master(shop_name,customer_name,mobile_no,customer_address,district_id,pincode,pin_id,rep_id,state_id,customer_type,area_id)values('$shop_name2','$cus_name2','$mob2','$address2','$dis','$doc_pincode2','$pinid','$rep_id','$state_id','$cus_type2','$pinid')")or die(mysql_error());
$last_id1=mysql_insert_id();
mysql_query("insert into  tbl_cds_master(tbl_cds_dcsid,tbl_cds_pinid,tbl_cds_areaid,tbl_cds_stateid,tbl_cds_districtid,tbl_cds_repid,tbl_cds_divisionid,tbl_cds_pincode,tbl_cds_status)values('$last_id1','$pinid','$pinid','$state_id','$dis','$rep_id','$division_id','$doc_pincode2','C')")or die(mysql_error());

}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
mysql_query("DELETE FROM import_excel_record WHERE id='$record_id' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='customer_import_division.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
}
?>