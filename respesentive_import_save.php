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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='respesentive_import_match.php?last_id=".$last_id."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 $rep_name=$_POST['rep_name'];
 $add=$_POST['add'];
 $doj=$_POST['doj'];
 $dob=$_POST['dob'];
 $blood=$_POST['blood'];
 $mobile=$_POST['mobile'];
 $email=$_POST['email'];
$division_name=$_POST['division_name'];
$emp_code=$_POST['emp_code'];
//echo "select * from import_excel_record where id='$record_id'";
$b=mysql_query("select * from import_excel_record where id='$record_id'")or die(mysql_error());
$row_b=mysql_fetch_array($b);
$file_name=$row_b['sheet_name'];
$head_no=$row_b['head_no'];


$excel->read('upload/'.$file_name);
function sheetData($sheet,$head_no) 
{
$x = $head_no+1;
$i = 100001;
$r = 1;
$userData = array();
while($x <= $sheet['numRows']) 
{
global $rep_name,$add,$doj,$dob,$blood,$mobile,$email,$division_name,$record_id,$emp_code;

$rep_name1=isset($sheet['cells'][$x][$rep_name]) ? $sheet['cells'][$x][$rep_name] : '';
$rep_name2=str_replace("'", "", $rep_name1);

$add1=isset($sheet['cells'][$x][$add]) ? $sheet['cells'][$x][$add] : '';
$add2=str_replace("'", "", $add1);

$doj1=isset($sheet['cells'][$x][$doj]) ? $sheet['cells'][$x][$doj] : '';
$doj2=str_replace("'", "", $doj1);

$dob1=isset($sheet['cells'][$x][$dob]) ? $sheet['cells'][$x][$dob] : '';
$dob2=str_replace("'", "", $dob1);

$blood1=isset($sheet['cells'][$x][$blood]) ? $sheet['cells'][$x][$blood] : '';
$blood2=str_replace("'", "", $blood1);


$mobile1=isset($sheet['cells'][$x][$mobile]) ? $sheet['cells'][$x][$mobile] : '';
$mobile2=str_replace("'", "", $mobile1);

$email1=isset($sheet['cells'][$x][$email]) ? $sheet['cells'][$x][$email] : '';
$email2=str_replace("'", "", $email1);

$division_name1=isset($sheet['cells'][$x][$division_name]) ? $sheet['cells'][$x][$division_name] : '';
$division_name2=str_replace("'", "", $division_name1);


$emp_code1=isset($sheet['cells'][$x][$emp_code]) ? $sheet['cells'][$x][$emp_code] : '';
$emp_code2=str_replace("'", "", $emp_code1);
/*$res = mysql_query("select * from representative  order by mark_id desc limit 1 ");
$row = mysql_fetch_array($res);
if(mysql_num_rows($res)==1)
{
 $mark_id = $row['mark_id']+1;
}*/

$div_name=mysql_query("select * from mst_division where division_name='$division_name2'")or die(mysql_error());
$row=mysql_fetch_array($div_name);
$division_id=$row['division_id'];

$d=mysql_query("select * from representative where rep_name='$rep_name2' AND mobile='$mobile2' AND division_id='$division_id' ");
$count_d=mysql_num_rows($d);
if($count_d>0) {
    
    echo "<script type=text/javascript>alert('Please check in Excel $rep_name2 Details already Stored in database.');</script>";
}
//doc_area_id,doc_pin_id,mobile,email
else
    {

     mysql_query("insert into  representative(mark_id,rep_id,rep_name,address,doj,dob,blood_group,mobile,email,division_id,emp_code)values('$i','0','$rep_name2','$add2','$doj2','$dob2','$blood2','$mobile2','$email2','$division_id','$emp_code2')")or die(mysql_error());

}
$x++;
$i++;
//$r++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM import_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='respesentive_import.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);

mysql_query("DELETE FROM temp_excel_heading WHERE id='$record_id'");
}
?>