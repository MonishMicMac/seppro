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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='product_import_match_aapp.php?last_id=".$last_id."';</script>";
}

if($command=='match_insert_excel_rows')
{

	$record_id=$_POST['record_id'];
	$pro_name=$_POST['pro_name'];
	$funcode=$_POST['funcode'];
	$hsncode=$_POST['hsncode'];
	$description=$_POST['description'];
	$capacity=$_POST['capacity'];
	$dimension=$_POST['dimension'];
	$mrp=$_POST['mrp'];

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
			global $pro_name,$funcode,$hsncode,$description,$capacity,$dimension,$mrp;

			$pro_name1=isset($sheet['cells'][$x][$pro_name]) ? $sheet['cells'][$x][$pro_name] : '';
			$pro_name2=str_replace("'", "", $pro_name1);

			$funcode1=isset($sheet['cells'][$x][$funcode]) ? $sheet['cells'][$x][$funcode] : '';
			$funcode2=str_replace(",", "", $funcode1);

			$hsncode1=isset($sheet['cells'][$x][$hsncode]) ? $sheet['cells'][$x][$hsncode] : '';
			$hsncode2=str_replace("'", "", $hsncode1);

			$description1=isset($sheet['cells'][$x][$description]) ? $sheet['cells'][$x][$description] : '';
			$description2=str_replace("'", "", $description1);

			$capacity1=isset($sheet['cells'][$x][$capacity]) ? $sheet['cells'][$x][$capacity] : '';
			$capacity2=str_replace("'", "", $capacity1);


			$dimension1=isset($sheet['cells'][$x][$dimension]) ? $sheet['cells'][$x][$dimension] : '';
			$dimension2=str_replace("'", "", $dimension1);

			$mrp1=isset($sheet['cells'][$x][$mrp]) ? $sheet['cells'][$x][$mrp] : '';
			$mrp2=str_replace("'", "", $mrp1);

			$res = mysql_query("select * from product  order by dummy_id desc limit 1 ");
			$row = mysql_fetch_array($res);
			if(mysql_num_rows($res)==1)
			{
				$pro_id = $row['dummy_id']+1;
			}
			else{
				$pro_id = 100001;
			}
/*$d=mysql_query("select * from product where pro_name='$pro_name2' AND packing='$packing2'");
$count_d=mysql_num_rows($d);
if($count_d>0) {
    
    echo "<script type=text/javascript>alert('Please check in Excel $pro_name2 Details already Stored in database.');</script>";
}
//doc_area_id,doc_pin_id,
else
{*/
	mysql_query("insert into  product(pro_name,funcode,hsncode,description,capacity,dimension,pro_mrp,dummy_id)values('$pro_name2','$funcode2','$hsncode2','$description2','$capacity2','$dimension2','$mrp2','$pro_id')")or die(mysql_error());

//}
	$x++;
}
}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM import_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='product_import_aapp.php';</script>";
$excelid=mysql_query("select * from import_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
}
?>