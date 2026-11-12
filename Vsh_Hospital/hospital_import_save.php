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

/*$rep_id=$_POST['rep_id'];*/

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

//echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='doctor_import_next.php?last_id=".$last_id."&&rep_id=".$rep_id."';</script>";
echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='hospital_import_next.php?last_id=".$last_id."';</script>";

}

if($command=='match_insert_excel_rows')
{

 $record_id=$_POST['record_id'];
 $hos_name=$_REQUEST['hos_name'];
 $hos_category=$_POST['hos_category'];
 $area=$_POST['area'];
 $mobile=$_POST['mobile'];
 $email=$_POST['email'];
 $hos_pincode=$_POST['hos_pincode'];
 $landmark=$_POST['landmark'];
 $address=$_POST['address'];
 /*
$st=mysql_query("select * from representative where id='$rep_id' ")or die(mysql_error());
$row_s=mysql_fetch_array($st);*/
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
global $hos_name,$hos_category,$area,$mobile,$email,$hos_pincode,$landmark,$address,$record_id;

$hos_name1=isset($sheet['cells'][$x][$hos_name]) ? $sheet['cells'][$x][$hos_name] : '';
$hos_name2=str_replace("'", "", $hos_name1);

$hos_category1=isset($sheet['cells'][$x][$hos_category]) ? $sheet['cells'][$x][$hos_category] : '';
$hos_category2=str_replace("'", "", $hos_category1);

$area1=isset($sheet['cells'][$x][$area]) ? $sheet['cells'][$x][$area] : '';
$area2=str_replace("'", "", $area1);

$mobile1=isset($sheet['cells'][$x][$mobile]) ? $sheet['cells'][$x][$mobile] : '';
$mobile2=str_replace("'", "", $mobile1);

$email1=isset($sheet['cells'][$x][$email]) ? $sheet['cells'][$x][$email] : '';
$email2=str_replace("'", "", $email1);

$hos_pincode1=isset($sheet['cells'][$x][$hos_pincode]) ? $sheet['cells'][$x][$hos_pincode] : '';
$hos_pincode2=str_replace("'", "", $hos_pincode1);

$landmark1=isset($sheet['cells'][$x][$landmark]) ? $sheet['cells'][$x][$landmark] : '';
$landmark2=str_replace("'", "", $landmark1);

$address1=isset($sheet['cells'][$x][$address]) ? $sheet['cells'][$x][$address] : '';
$address2=str_replace("'", "", $address1);


$pc=mysql_query("select pincode,pin_id from master_pincode where pincode='$hos_pincode2' ")or die(mysql_error());
$row_pc=mysql_fetch_array($pc);
$pinid=$row_pc['pin_id'];
/*$district_name=$row_pc['district_id'];
$state_id=$row_pc['state_id'];*/

$pc1=mysql_query("select * from mst_category where category_name='$hos_category2' ")or die(mysql_error());
$row_pc1=mysql_fetch_array($pc1);
$hos_category3=$row_pc1['category_id'];
/*$pc3=mysql_query("select pincode,id,area_name from pincode_list where area_name='$area2' ")or die(mysql_error());
$row_pc3=mysql_fetch_array($pc3);
$area_id=$row_pc3['id'];*/

$d=mysql_query("select * from Hospitalname where hos_name='$hos_name2' and hos_pincode='$hos_pincode2' ");
$count_d=mysql_num_rows($d);
if($count_d>0){
	echo "<script type=text/javascript>alert('Please check in Excel $hos_name2
	 Details already Stored in database.');</script>";
}
else
	{
	 mysql_query("insert into  Hospitalname(hos_name,hos_category,area_hos,mobile_no,email_hos,hos_pincode,land_hos,address,pin_id)values('$hos_name2','$hos_category3','$area2','$mobile2','$email2','$hos_pincode2','$landmark2','$address2','$pinid')")or die(mysql_error());	
}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM import_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='hospital_import.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);

mysql_query("DELETE FROM temp_excel_heading WHERE excel_id='$record_id'");
mysql_query(" DELETE FROM import_excel_record WHERE id='$record_id' ");
}
?>