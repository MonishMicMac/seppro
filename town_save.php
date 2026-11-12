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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='town_next.php?last_id=".$last_id."&&state_id=".$state."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 $state=$_REQUEST['state_id'];
 /*$district_name=$_POST['district'];*/
 $area_name=$_POST['area_name'];
 $pincode=$_POST['pincode'];
$st=mysql_query("select * from master_state where state_id='$state' ")or die(mysql_error());
$row_s=mysql_fetch_array($st);
$state_name=$row_s['state_name'];
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
global /*$district_name,*/$state,$area_name,$pincode,$state_name;

//$state_id1=isset($sheet['cells'][$x][$state_id]) ? $sheet['cells'][$x][$state_id] : '';
//$state_id2=str_replace("'", "", $state_id1);

/*$district_name1=isset($sheet['cells'][$x][$district_name]) ? $sheet['cells'][$x][$district_name] : '';
$district_name2=str_replace("'", "", $district_name1);
*/
$area_name1=isset($sheet['cells'][$x][$area_name]) ? $sheet['cells'][$x][$area_name] : '';
$area_name2=str_replace("'", "", $area_name1);

$pincode1=isset($sheet['cells'][$x][$pincode]) ? $sheet['cells'][$x][$pincode] : '';
$pincode2=str_replace("'", "", $pincode1);

/*$ac=mysql_query("select district_name,district_id from master_district where district_name='$district_name2'")or die(mysql_error());
$row_ac=mysql_fetch_array($ac);
$dis=$row_ac['district_id'];

if ($dis=="") 
{
   $har="0";
}
else
{
      $har="$dis";
}
*/$sqlpincode=mysql_query("select * from master_pincode where pincode='$pincode2'")or die(mysql_error());
$rowpincode=mysql_fetch_array($sqlpincode);
$idpin1=$rowpincode['pin_id'];
$district_id=$rowpincode['district_id'];

 $countpincode=mysql_num_rows($sqlpincode);
if($countpincode=='0'){

echo "<script type=text/javascript>alert('Please check in Excel $area_name2 Details already Stored in database.');</script>";	

}else{

	mysql_query("insert into pincode_list(state_id,dist_id,area_name,pin_id,pincode)values('$state','$district_id','$area_name2','$idpin1','$pincode2')")or die(mysql_error());

}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM import_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='town_send.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
}
?>