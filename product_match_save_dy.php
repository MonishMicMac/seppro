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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='product_import_match_dy.php?last_id=".$last_id."';</script>";
}

if($command=='match_insert_excel_rows')
{

$record_id=$_POST['record_id'];
 $pro_name=$_POST['pro_name'];
 $comb=$_POST['comb'];
 $packing=$_POST['packing'];
 $ptr=$_POST['ptr'];
 $pts=$_POST['pts'];
 $pro_mrp=$_POST['pro_mrp'];
$pro_short_code=$_POST['pro_short_code'];

$offerprice=$_POST['pro_mrp_Brand_offer'];
$brand=$_POST['pro_mrp_Brand'];
$category=$_POST['pro_mrp_Category'];
$pro_img=$_POST['pro_img'];

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
global $pro_name,$comb,$packing,$ptr,$pts,$pro_mrp,$pro_short_code,$offerprice,$brand,$category,$pro_img;


$pro_name1=isset($sheet['cells'][$x][$pro_name]) ? $sheet['cells'][$x][$pro_name] : '';
$pro_name2=str_replace("'", "", $pro_name1);

$comb1=isset($sheet['cells'][$x][$comb]) ? $sheet['cells'][$x][$comb] : '';
$comb2=str_replace(",", "", $comb1);

$packing1=isset($sheet['cells'][$x][$packing]) ? $sheet['cells'][$x][$packing] : '';
$packing2=str_replace("'", "", $packing1);

$ptr1=isset($sheet['cells'][$x][$ptr]) ? $sheet['cells'][$x][$ptr] : '';
$ptr2=str_replace("'", "", $ptr1);

$pts1=isset($sheet['cells'][$x][$pts]) ? $sheet['cells'][$x][$pts] : '';
$pts2=str_replace("'", "", $pts1);


$pro_mrp1=isset($sheet['cells'][$x][$pro_mrp]) ? $sheet['cells'][$x][$pro_mrp] : '';
$pro_mrp2=str_replace("'", "", $pro_mrp1);

$pro_short_code1=isset($sheet['cells'][$x][$pro_short_code]) ? $sheet['cells'][$x][$pro_short_code] : '';
$pro_short_code2=str_replace("'", "", $pro_short_code1);

$offerprice1=isset($sheet['cells'][$x][$offerprice]) ? $sheet['cells'][$x][$offerprice] : '';
$offerprice2=str_replace("'", "", $offerprice1);

$brand1=isset($sheet['cells'][$x][$brand]) ? $sheet['cells'][$x][$brand] : '';
$brand2=str_replace("'", "", $brand1);

$category1=isset($sheet['cells'][$x][$category]) ? $sheet['cells'][$x][$category] : '';
$category2=str_replace("'", "", $category1);

$pro_img1=isset($sheet['cells'][$x][$pro_img]) ? $sheet['cells'][$x][$pro_img] : '';
$pro_img2=str_replace("'", "", $pro_img1);

$res = mysql_query("select * from product  order by dummy_id desc limit 1 ");
$row = mysql_fetch_array($res);
if(mysql_num_rows($res)==1)
{
 $pro_id = $row['dummy_id']+1;
}
else{
	$pro_id = 100001;
}

$d=mysql_query("select * from product1 where pro_name='$pro_name2' AND packing='$packing2' AND poduct_category='$category2'");
$count_d=mysql_num_rows($d);
if($count_d>0) {
    
    echo "<script type=text/javascript>alert('Please check in Excel $pro_name2 Details already Stored in database.');</script>";
}
//doc_area_id,doc_pin_id,
else
    {
     mysql_query("insert into  product1(pro_name,comb,packing,ptr,pts,pro_mrp,dummy_id,pro_short_code,poduct_category,brand_name,offer_price,product_image)values('$pro_name2','$comb2','$packing2','$ptr2','$pts2','$pro_mrp2','$pro_id','$pro_short_code2','$category2','$brand2','$offerprice2','$pro_img2')")or die(mysql_error());

}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM import_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='product_import_dy.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
}
?>