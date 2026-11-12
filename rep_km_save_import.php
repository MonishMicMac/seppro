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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='rep_km_next_import.php?last_id=".$last_id."&&rep_id=".$rep_id."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 $rep_id=$_REQUEST['rep_id'];
 $from=$_POST['from'];
 $to=$_POST['to'];

 $type=$_POST['type'];
 $onward_km=$_POST['onward_km'];
 $onward_km_wages=$_POST['onward_km_wages'];
 $onward_km_fare=$_POST['onward_km_fare'];
 $return_km=$_POST['return_km'];
 $return_km_wages=$_POST['return_km_wages'];
 $return_km_fare=$_POST['return_km_fare'];
 $total_wages=$_POST['total_wages'];
// echo  '1';
// 		die();

$st=mysql_query("select * from representative where id='$rep_id' ")or die(mysql_error());
$row_s=mysql_fetch_array($st);





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
global $from,$to,$type,$onward_km,$onward_km_wages,$onward_km_fare,$return_km,$rep_id,$record_id,$return_km_wages,$return_km_fare,$total_wages;

//$district_name
$from1=isset($sheet['cells'][$x][$from]) ? $sheet['cells'][$x][$from] : '';
$from2=str_replace("'", "", $from1);

$to1=isset($sheet['cells'][$x][$to]) ? $sheet['cells'][$x][$to] : '';
$to2=str_replace("'", "", $to1);

$type1=isset($sheet['cells'][$x][$type]) ? $sheet['cells'][$x][$type] : '';
$type2=str_replace("'", "", $type1);

$onward_km1=isset($sheet['cells'][$x][$onward_km]) ? $sheet['cells'][$x][$onward_km] : '';
$onward_km2=str_replace("'", "", $onward_km1);

$onward_km_wages1=isset($sheet['cells'][$x][$onward_km_wages]) ? $sheet['cells'][$x][$onward_km_wages] : '';
$onward_km_wages2=str_replace("'", "", $onward_km_wages1);

$onward_km_fare1=isset($sheet['cells'][$x][$onward_km_fare]) ? $sheet['cells'][$x][$onward_km_fare] : '';
$onward_km_fare2=str_replace("'", "", $onward_km_fare1);

$return_km1=isset($sheet['cells'][$x][$return_km]) ? $sheet['cells'][$x][$return_km] : '';
$return_km2=str_replace("'", "", $return_km1);

$return_km_wages1=isset($sheet['cells'][$x][$return_km_wages]) ? $sheet['cells'][$x][$return_km_wages] : '';
$return_km_wages2=str_replace("'", "", $return_km_wages1);

$return_km_fare1=isset($sheet['cells'][$x][$return_km_fare]) ? $sheet['cells'][$x][$return_km_fare] : '';
$return_km_fare2=str_replace("'", "", $return_km_fare1);

$total_wages1=isset($sheet['cells'][$x][$total_wages]) ? $sheet['cells'][$x][$total_wages] : '';
$total_wages2=str_replace("'", "", $total_wages1);


  
//$ac=mysql_query("select district_name,district_id from master_district where district_name='$district_name2'")or die(mysql_error());
//$row_ac=mysql_fetch_array($ac);
//$dis=$row_ac['district_id'];

// $pc=mysql_query("select pincode,pin_id,dist_id,state_id,id from pincode_list where pincode='$doc_pincode2' ")or die(mysql_error());
// $row_pc=mysql_fetch_array($pc);
// $pinid=$row_pc['pin_id'];
// $district_name=$row_pc['dist_id'];
// $state_id=$row_pc['state_id'];
// $area_id=$row_pc['id'];

$d=mysql_query("select * from km_calc where rep_id='$rep_id' and to='$to' ");
$count_d=mysql_num_rows($d);
if($count_d>0) {
	
	echo "<script type=text/javascript>alert('Please check in Excel $to Details already Stored in database.');</script>";
}


else
	{

		// echo "insert into  km_calc(rep_id,from,to,type,onward_km,onward_km_wages,onward_km_fare,return_km,return_km_wages,return_km_fare,total_wages)values('$rep_id','$from2','$to2','$type2','$onward_km2','$onward_km_wages2','$onward_km_fare2','$return_km2','$return_km_wages2','$return_km_wages2','$return_km_fare2','$total_wages2')";
		// die();

	 mysql_query("insert into  km_calc(rep_id,from_place,to_place,type,onward_km,onward_km_wages,onward_km_fare,return_km,return_km_wages,return_km_fare,total_wages)values('$rep_id','$from2','$to2','$type2','$onward_km2','$onward_km_wages2','$onward_km_fare2','$return_km2','$return_km_wages2','$return_km_fare2','$total_wages2')")or die(mysql_error());
		
	// mysql_query("insert into  doctors(doctor_name,doc_specilist_id,doc_qualification,doctor_addrs,doc_district_id,doc_pincode,doc_contact_no,doc_hospital_clinic_name,rep_id,doc_pin_id,rep_assign,state_id,doc_area_id)values('$doctor_name2','$doc_specilist_id2','$doc_qualification2','$doc_loc_address2','$district_name','$doc_pincode2','$doc_contact_no2','$doc_hospital_clinic_name2','$rep_id','$pinid','$rep_id','$state_id','$area_id')")or die(mysql_error());

	
}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM import_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='rep_km_import.php';</script>";
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