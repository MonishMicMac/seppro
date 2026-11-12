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
$division_id=$_POST['division_id'];

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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='product_import_match_division.php?last_id=".$last_id."&&division_id=".$division_id."';</script>";
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
 $div_name=$_POST['division_id'];

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
global $pro_name,$comb,$packing,$ptr,$pts,$pro_mrp,$record_id,$div_name;


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

//$div_name1=isset($sheet['cells'][$x][$div_name]) ? $sheet['cells'][$x][$div_name] : '';
//$div_name2=str_replace("'", "", $div_name1);

$res = mysql_query("select * from product  order by pro_id desc limit 1 ");
$row = mysql_fetch_array($res);
if(mysql_num_rows($res)==1)
{
 $pro_id = $row['pro_id']+1;
}
else{
	$pro_id = 100001;
}

//$div_name=mysql_query("select * from mst_division where division_name='$div_name2'")or die(mysql_error());
//$row=mysql_fetch_array($div_name);
//$division_id=$row['division_id'];
/*$d=mysql_query("select * from product where pro_name='$pro_name2' AND packing='$packing2'");
$count_d=mysql_num_rows($d);
if($count_d>0) {
    
    echo "<script type=text/javascript>alert('Please check in Excel $pro_name2 Details already Stored in database.');</script>";
}
//doc_area_id,doc_pin_id,
else
    {*/
     mysql_query("insert into  product(pro_name,comb,packing,ptr,pts,pro_mrp,division_id,pro_id)values('$pro_name2','$comb2','$packing2','$ptr2','$pts2','$pro_mrp2','$div_name','$pro_id')")or die(mysql_error());

//}
$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM student_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='product_import_division.php';</script>";
$excelid=mysql_query("select * from student_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);

mysql_query("DELETE FROM import_excel_record WHERE id='$record_id' ");

mysql_query("DELETE FROM temp_excel_heading WHERE excel_id='$record_id'");
}
?>