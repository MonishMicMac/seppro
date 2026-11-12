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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='customer_import_next_dm.php?last_id=".$last_id."&&rep_id=".$rep_id."&&category=".$categoryid."';</script>";
}

if($command=='match_insert_excel_rows')
{

	$record_id=$_POST['record_id'];
	$rep_id=$_REQUEST['rep_id'];
	$category=$_POST['category'];

	$contactname=$_POST['contactname'];
	$contactnumber=$_POST['contactnumber'];
	$clientname=$_POST['clientname'];
	$clientcontactnumber=$_POST['clientcontactnumber'];
	$buildername=$_POST['buildername'];
	$buildercontactnumber=$_POST['buildercontactnumber'];
	$buildercontactperson=$_POST['buildercontactperson'];
	$projectname=$_POST['projectname'];
	$projectmanager=$_POST['projectmanager'];
	$architectname=$_POST['architectname'];
	$architectcontactname=$_POST['architectcontactname'];
	$architectcontactnumber=$_POST['architectcontactnumber'];
	$email=$_POST['email'];
	$sitedetails=$_POST['sitedetails'];
	$siteaddress=$_POST['siteaddress'];
	$sitereference=$_POST['sitereference'];
	$remarks=$_POST['remarks'];
	$feedback=$_POST['feedback'];
	

//echo "select * from excel_record where id='$record_id'";
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
			global $record_id,$rep_id,$category,$contactname,$contactnumber,$clientname,$clientcontactnumber,$buildername,$buildercontactnumber,$buildercontactperson,$projectname,$projectmanager,$architectname,$architectcontactname,$architectcontactnumber,$email,$sitedetails,$siteaddress,$sitereference,$remarks,$feedback;

			$contactname1=isset($sheet['cells'][$x][$contactname]) ? $sheet['cells'][$x][$contactname] : '';
			$contactname2=str_replace("'", "", $contactname1);
						
			$contactnumber1=isset($sheet['cells'][$x][$contactnumber]) ? $sheet['cells'][$x][$contactnumber] : '';
			$contactnumber2=str_replace("'", "", $contactnumber1);

			$clientname1=isset($sheet['cells'][$x][$clientname]) ? $sheet['cells'][$x][$clientname] : '';
			$clientname2=str_replace("'", "", $clientname1);

			$clientcontactnumber1=isset($sheet['cells'][$x][$clientcontactnumber]) ? $sheet['cells'][$x][$clientcontactnumber] : '';
			$clientcontactnumber2=str_replace("'", "", $clientcontactnumber1);

			$buildername1=isset($sheet['cells'][$x][$buildername]) ? $sheet['cells'][$x][$buildername] : '';
			$buildername2=str_replace("'", "", $buildername1);

			$buildercontactnumber1=isset($sheet['cells'][$x][$buildercontactnumber]) ? $sheet['cells'][$x][$buildercontactnumber] : '';
			$buildercontactnumber2=str_replace("'", "", $buildercontactnumber1);

			$buildercontactperson1=isset($sheet['cells'][$x][$buildercontactperson]) ? $sheet['cells'][$x][$buildercontactperson] : '';
			$buildercontactperson2=str_replace("'", "", $buildercontactperson1);

			$projectname1=isset($sheet['cells'][$x][$projectname]) ? $sheet['cells'][$x][$projectname] : '';
			$projectname2=str_replace("'", "", $projectname1);

			$projectmanager1=isset($sheet['cells'][$x][$projectmanager]) ? $sheet['cells'][$x][$projectmanager] : '';
			$projectmanager2=str_replace("'", "", $projectmanager1);

			$architectname1=isset($sheet['cells'][$x][$architectname]) ? $sheet['cells'][$x][$architectname] : '';
			$architectname2=str_replace("'", "", $architectname1);

			$architectcontactname1=isset($sheet['cells'][$x][$architectcontactname]) ? $sheet['cells'][$x][$architectcontactname] : '';
			$architectcontactname2=str_replace("'", "", $architectcontactname1);


			$architectcontactnumber1=isset($sheet['cells'][$x][$architectcontactnumber]) ? $sheet['cells'][$x][$architectcontactnumber] : '';
			$architectcontactnumber2=str_replace("'", "", $architectcontactnumber1);

			$email1=isset($sheet['cells'][$x][$email]) ? $sheet['cells'][$x][$email] : '';
			$email2=str_replace("'", "", $email1);

			$sitedetails1=isset($sheet['cells'][$x][$sitedetails]) ? $sheet['cells'][$x][$sitedetails] : '';
			$sitedetails2=str_replace("'", "", $sitedetails1);

			$siteaddress1=isset($sheet['cells'][$x][$siteaddress]) ? $sheet['cells'][$x][$siteaddress] : '';
			$siteaddress2=str_replace("'", "", $siteaddress1);

			$sitereference1=isset($sheet['cells'][$x][$sitereference]) ? $sheet['cells'][$x][$sitereference] : '';
			$sitereference2=str_replace("'", "", $sitereference1);

			$remarks1=isset($sheet['cells'][$x][$remarks]) ? $sheet['cells'][$x][$remarks] : '';
			$remarks2=str_replace("'", "", $remarks1);

			$feedback1=isset($sheet['cells'][$x][$feedback]) ? $sheet['cells'][$x][$feedback] : '';
			$feedback2=str_replace("'", "", $feedback1);

		


// $ac=mysql_query("select district_name,district_id from master_district where district_name='$district_name2'")or die(mysql_error());
// $row_ac=mysql_fetch_array($ac);
// $dis=$row_ac['district_id'];


// $pc=mysql_query("select * from pincode_list where pincode='$doc_pincode2' ")or die(mysql_error());
// $row_pc=mysql_fetch_array($pc);
// $pinid=$row_pc['pin_id'];
// $area_id=$row_pc['id'];
// $state_id=$row_pc['state_id'];



//$sc=mysql_query("select state_id,state_name from master_state where state_name='$state2' ")or die(mysql_error());
//$row_sc=mysql_fetch_array($sc);
//$state_id=$row_sc['state_id'];

// 			contactname2
// contactnumber2
// clientname2
// clientcontactnumber2
// buildername2
// buildercontactnumber2
// buildercontactperson2
// projectname2
// projectmanager2
// architectname2
// architectcontactname2
// architectcontactnumber2
// email2
// sitedetails2
// siteaddress2
// sitereference2
// remarks2
// feedback2
			// echo"select * from databaseclient_new where db_contact_name='$contactname2' and db_builder_name='$buildername2' and db_project_name='$projectname2' and db_project_manager='$projectmanager2' and db_client_name='$clientname2' and db_contact_number='$contactnumber2' and db_client_contact_number='$clientcontactnumber2' and db_builder_contact_number='$buildercontactnumber2'  and db_builder_contact_person='$buildercontactperson2' and db_architect_name='$architectname2' and db_architect_contact_name='$architectcontactname2' and db_architect_contact_number='$architectcontactnumber2' and db_category='$category'  ";

			$d=mysql_query("select * from databaseclient_new where db_contact_name='$contactname2' and db_builder_name='$buildername2' and db_project_name='$projectname2' and db_project_manager='$projectmanager2' and db_client_name='$clientname2' and db_contact_number='$contactnumber2' and db_client_contact_number='$clientcontactnumber2' and db_builder_contact_number='$buildercontactnumber2'  and db_builder_contact_person='$buildercontactperson2' and db_architect_name='$architectname2' and db_architect_contact_name='$architectcontactname2' and db_architect_contact_number='$architectcontactnumber2' and db_category='$category'  ");
			$count_d=mysql_num_rows($d);
			if($count_d>0) {

				echo "<script type=text/javascript>alert('Please check in Excel Details already Stored in database.');</script>";
			}

			else
			{
		//echo "insert into  tbl_customer_master(shop_name,customer_name,mobile_no,customer_address,district_id,pincode,pin_id,rep_id,state_id)values('$shop_name2','$cus_name2','$mob2','$address2','$dis','$doc_pincode2','$pinid','$rep_id','$state_id')";
		//exit;
				mysql_query("insert into  databaseclient_new( `db_contact_name`, `db_contact_number`, `db_site_address`, `db_email`, `db_builder_name`, `db_project_name`, `db_project_manager`, `db_remarks`, `db_site_details`, `db_client_name`, `db_client_contact_number`, `db_feedback`, `db_builder_contact_number`, `db_builder_contact_person`, `db_architect_name`, `db_architect_contact_name`, `db_architect_contact_number`, `db_site_reference`, `db_category`)values('$contactname2','$contactnumber2','$siteaddress2','$email2','$buildername2','$projectname2','$projectmanager2','$remarks2','$sitedetails2','$clientname2','$clientcontactnumber2','$feedback2','$buildercontactnumber2','$buildercontactperson2','$architectname2','$architectcontactname2','$architectcontactnumber2','$sitereference2','$category')")or die(mysql_error());

			}
			$x++;
		}
	}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
//mysql_query(" DELETE FROM student_excel_record WHERE id='$idm' ");
echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='customer_import_dm.php';</script>";
$excelid=mysql_query("select * from student_excel_record order by id desc limit 1");
$na=mysql_fetch_array($excelid);
$idm=$na['id'];
$ma=$na['sheet_name'];
$path = "upload/$ma";
unlink($path);
}
?>