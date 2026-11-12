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

if($_REQUEST['condition']=='new_grp'){
	$sql1=mysql_query("SELECT * FROM category WHERE catname='".$_REQUEST['add_group_name']."'");
	if(mysql_num_rows($sql1)==0){		
		mysql_query("INSERT INTO category(catname) VALUES('".$_REQUEST['add_group_name']."')");
		$categoryid=mysql_insert_id();
	} else {
		echo "<script type='text/javascript'>alert('category Name Already Exists')</script>"; 
		$sel_row=mysql_fetch_array($sql1);
		$categoryid=$sel_row['catid'];
	}

	
} elseif($_REQUEST['condition']=='old_grp') {
	$categoryid=$_REQUEST['category'];
}
// echo $categoryid;

// exit();
mysql_query("insert into student_excel_record(sheet_name,excel_type,file_size,head_no,c_date,c_time)values('$uploaded_files','$ext','$file_mb','$head_no','$c_date','$c_time')")or die(mysql_error());

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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='customer_import_next_dm1.php?last_id=".$last_id."';</script>";
}

if($command=='match_insert_excel_rows')
{
	$record_id=$_POST['record_id'];
	$project_name=$_POST['project_name'];
	$contact_name=$_POST['contact_name'];
	$category=$_POST['category'];
	$clientcontactnumber=$_POST['clientcontactnumber'];
	$email=$_POST['email'];
	$siteaddress=$_POST['siteaddress'];
	$sitereference=$_POST['sitereference'];
	/*$remarks=$_POST['remarks'];
	$feedback=$_POST['feedback'];*/
	$b=mysql_query("select * from student_excel_record where id='$record_id'")or die(mysql_error());
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
			global $record_id,$project_name,$contact_name,$category,$clientcontactnumber,$email,$siteaddress,$sitereference,$remarks,$feedback;

			$project_name1=isset($sheet['cells'][$x][$project_name]) ? $sheet['cells'][$x][$project_name] : '';
			$project_name2=str_replace("'", "", $project_name1);

			$contact_name1=isset($sheet['cells'][$x][$contact_name]) ? $sheet['cells'][$x][$contact_name] : '';
			$contact_name2=str_replace("'", "", $contact_name1);

			$category1=isset($sheet['cells'][$x][$category]) ? $sheet['cells'][$x][$category] : '';
			$category2=str_replace("'", "", $category1);

			$clientcontactnumber1=isset($sheet['cells'][$x][$clientcontactnumber]) ? $sheet['cells'][$x][$clientcontactnumber] : '';
			$clientcontactnumber2=str_replace("'", "", $clientcontactnumber1);

			$email1=isset($sheet['cells'][$x][$email]) ? $sheet['cells'][$x][$email] : '';
			$email2=str_replace("'", "", $email1);

			$siteaddress1=isset($sheet['cells'][$x][$siteaddress]) ? $sheet['cells'][$x][$siteaddress] : '';
			$siteaddress2=str_replace("'", "", $siteaddress1);

			$sitereference1=isset($sheet['cells'][$x][$sitereference]) ? $sheet['cells'][$x][$sitereference] : '';
			$sitereference2=str_replace("'", "", $sitereference1);

			/*$remarks1=isset($sheet['cells'][$x][$remarks]) ? $sheet['cells'][$x][$remarks] : '';
			$remarks2=str_replace("'", "", $remarks1);

			$feedback1=isset($sheet['cells'][$x][$feedback]) ? $sheet['cells'][$x][$feedback] : '';
			$feedback2=str_replace("'", "", $feedback1);*/

			$select=mysql_query("SELECT * FROM category WHERE catname='$category2'");
			$row_sel=mysql_fetch_array($select);
			$category_id=$row_sel['catid'];

			$d=mysql_query("select * from databaseclient_new where db_contact_name='$contact_name2'  and db_category='$category_id' and  db_project_name='$project_name2'");
			$count_d=mysql_num_rows($d);
			if($count_d>0) {

				echo "<script type=text/javascript>alert('Please check in Excel Details already Stored in database.');</script>";
			}

			else
			{
				mysql_query("insert into  databaseclient_new( `db_project_name`, `db_contact_name`,`db_category`,`db_contact_number`,  `db_email`,db_site_address,`db_site_reference`)values('$project_name2','$contact_name2','$category_id','$clientcontactnumber2','$email2','$siteaddress2','$sitereference2')")or die(mysql_error());

			}
			$x++;
		}
	}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM student_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='customer_import_dm1.php';</script>";
$excelid=mysql_query("select * from student_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
}
?>