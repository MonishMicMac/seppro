<?php
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 15000);

include("../includes/connect_db.php");
include "../includes/function.php";

$command=$_POST['command'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');
include 'excel_reader.php';
require 'class.phpmailer.php';
include("email_send.php");
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

$std_id=$_POST['standard_id'];
$sec_id=$_POST['section_id'];

	$target_path = "ramu/";
$uploaded_files=$random_no."_".$_FILES['logo']['name'];
move_uploaded_file($_FILES['logo']['tmp_name'], $target_path .$random_no."_".$_FILES['logo']['name']);

mysql_query("insert into student_excel_record(sheet_name,excel_type,file_size,head_no,c_date,c_time)values('$uploaded_files','$ext','$file_mb','$head_no','$c_date','$c_time')")or die(mysql_error());

$last_id=mysql_insert_id();

$excel->read('ramu/'.$uploaded_files);
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

echo "<script type=text/javascript>alert('Files Uploaded');window.location.href='example_next.php?last_id=".$last_id."&&std_id=".$std_id."&&sec_id=".$sec_id."';</script>";
}

if($command=='match_insert_excel_rows')
{


$std_id=$_POST['std_id'];
$sec_id=$_POST['sec_id'];
$std_name=get_standard($_POST['std_id']);
$sec_name=get_section($_POST['sec_id']);


$record_id=$_POST['record_id'];
$first_name=$_POST['first_name'];
$reg_no=$_POST['reg_no'];
$ref_id=$_POST['ref_id'];
$dob=$_POST['dob'];
$city=$_POST['city'];
$state=$_POST['state'];

$present_add=$_POST['present_add'];
$perm_add=$_POST['perm_add'];
$pin_code=$_POST['pin_code'];
$sex=$_POST['sex'];
$blood_gr=$_POST['blood_gr'];
$acadamic_y=$_POST['acadamic_y'];

$father_name=$_POST['father_name'];
$father_ph=$_POST['father_ph'];
$mother_name=$_POST['mother_name'];
$mother_ph_no=$_POST['mother_ph_no'];
$father_email=$_POST['father_email'];
$yearly_in=$_POST['yearly_in'];
$religion=$_POST['religion'];

$nationality=$_POST['nationality'];
$mother_tong=$_POST['mother_tong'];
$caste=$_POST['caste'];
$comm=$_POST['comm'];
$comm_no=$_POST['comm_no'];
$hostel=$_POST['hostel'];

$guard_name=$_POST['guard_name'];
$guard_ph=$_POST['guard_ph'];
$guard_email=$_POST['guard_email'];
$place_of_birth=$_POST['place_of_birth'];
$father_occu=$_POST['father_occu'];
$guard_address=$_POST['guard_address'];

$adm_date=$_POST['adm_date'];




//echo "select * from excel_record where id='$record_id'";
$b=mysql_query("select * from student_excel_record where id='$record_id'")or die(mysql_error());
$row_b=mysql_fetch_array($b);
$file_name=$row_b['sheet_name'];
$head_no=$row_b['head_no'];


$excel->read('ramu/'.$file_name);
function sheetData($sheet,$head_no) 
{
$x = $head_no+1;
$userData = array();
while($x <= $sheet['numRows']) 
{


global $first_name,$reg_no,$ref_id,$dob,$city,$state,$record_id,$head_no,$present_add,$perm_add,$pin_code,$sex,$blood_gr,$acadamic_y,$father_name,$father_ph,$mother_name,
$mother_ph_no,$father_email,$yearly_in,$religion,$nationality,$mother_tong,$caste,
$comm,$comm_no,$hostel,$guard_name,$guard_ph,$guard_email,$place_of_birth,$father_occu,$guard_address,$adm_date,
$std_id,$sec_id,$std_name,$sec_name;









$first_name1=isset($sheet['cells'][$x][$first_name]) ? $sheet['cells'][$x][$first_name] : '';
$first_name2=str_replace("'", "", $first_name1);

$reg_no1=isset($sheet['cells'][$x][$reg_no]) ? $sheet['cells'][$x][$reg_no] : '';
$reg_no2=str_replace("'", "", $reg_no1);
$ref_id1=isset($sheet['cells'][$x][$ref_id]) ? $sheet['cells'][$x][$ref_id] : '';
$ref_id2=str_replace("'", "", $ref_id1);
$dob1=isset($sheet['cells'][$x][$dob]) ? $sheet['cells'][$x][$dob] : '';
$dob2=str_replace("'", "", $dob1);




$city1=isset($sheet['cells'][$x][$city]) ? $sheet['cells'][$x][$city] : '';
$city2=str_replace("'", "", $city1);
$state1=isset($sheet['cells'][$x][$state]) ? $sheet['cells'][$x][$state] : '';
$state2=str_replace("'", "", $state1);

$present_add1=isset($sheet['cells'][$x][$present_add]) ? $sheet['cells'][$x][$present_add] : '';
$present_add2=str_replace("'", "", $present_add1);
$perm_add1=isset($sheet['cells'][$x][$perm_add]) ? $sheet['cells'][$x][$perm_add] : '';
$perm_add2=str_replace("'", "", $perm_add1);
$pin_code1=isset($sheet['cells'][$x][$pin_code]) ? $sheet['cells'][$x][$pin_code] : '';
$pin_code2=str_replace("'", "", $pin_code1);
$sex1=isset($sheet['cells'][$x][$sex]) ? $sheet['cells'][$x][$sex] : '';
$sex2=str_replace("'", "", $sex1);
$blood_gr1=isset($sheet['cells'][$x][$blood_gr]) ? $sheet['cells'][$x][$blood_gr] : '';
$blood_gr2=str_replace("'", "", $blood_gr1);
$acadamic_y1=isset($sheet['cells'][$x][$acadamic_y]) ? $sheet['cells'][$x][$acadamic_y] : '';
$acadamic_y2=str_replace("'", "", $acadamic_y1);

$father_name1=isset($sheet['cells'][$x][$father_name]) ? $sheet['cells'][$x][$father_name] : '';
$father_name2=str_replace("'", "", $father_name1);
$father_ph1=isset($sheet['cells'][$x][$father_ph]) ? $sheet['cells'][$x][$father_ph] : '';
$father_ph2=str_replace("'", "", $father_ph1);
$mother_name1=isset($sheet['cells'][$x][$mother_name]) ? $sheet['cells'][$x][$mother_name] : '';
$mother_name2=str_replace("'", "", $mother_name1);

$mother_ph_no1=isset($sheet['cells'][$x][$mother_ph_no]) ? $sheet['cells'][$x][$mother_ph_no] : '';
$mother_ph_no2=str_replace("'", "", $mother_ph_no1);

$father_email1=isset($sheet['cells'][$x][$father_email]) ? $sheet['cells'][$x][$father_email] : '';
$father_email2=str_replace("'", "", $father_email1);
$yearly_in1=isset($sheet['cells'][$x][$yearly_in]) ? $sheet['cells'][$x][$yearly_in] : '';
$yearly_in2=str_replace("'", "", $yearly_in1);
$religion1=isset($sheet['cells'][$x][$religion]) ? $sheet['cells'][$x][$religion] : '';
$religion2=str_replace("'", "", $religion1);



$nationality1=isset($sheet['cells'][$x][$nationality]) ? $sheet['cells'][$x][$nationality] : '';
$nationality2=str_replace("'", "", $nationality1);
$mother_tong1=isset($sheet['cells'][$x][$mother_tong]) ? $sheet['cells'][$x][$mother_tong] : '';
$mother_tong2=str_replace("'", "", $mother_tong1);
$caste1=isset($sheet['cells'][$x][$caste]) ? $sheet['cells'][$x][$caste] : '';
$caste2=str_replace("'", "", $caste1);
$comm1=isset($sheet['cells'][$x][$comm]) ? $sheet['cells'][$x][$comm] : '';
$comm2=str_replace("'", "", $comm1);
$comm_no1=isset($sheet['cells'][$x][$comm_no]) ? $sheet['cells'][$x][$comm_no] : '';
$comm_no2=str_replace("'", "", $comm_no1);
$hostel1=isset($sheet['cells'][$x][$hostel]) ? $sheet['cells'][$x][$hostel] : '';
$hostel2=str_replace("'", "", $hostel1);




$guard_name1=isset($sheet['cells'][$x][$guard_name]) ? $sheet['cells'][$x][$guard_name] : '';
$guard_name2=str_replace("'", "", $guard_name1);
$guard_ph1=isset($sheet['cells'][$x][$guard_ph]) ? $sheet['cells'][$x][$guard_ph] : '';
$guard_ph2=str_replace("'", "", $guard_ph1);
$guard_email1=isset($sheet['cells'][$x][$guard_email]) ? $sheet['cells'][$x][$guard_email] : '';
$guard_email2=str_replace("'", "", $guard_email1);
$place_of_birth1=isset($sheet['cells'][$x][$place_of_birth]) ? $sheet['cells'][$x][$place_of_birth] : '';
$place_of_birth2=str_replace("'", "", $place_of_birth1);
$father_occu1=isset($sheet['cells'][$x][$father_occu]) ? $sheet['cells'][$x][$father_occu] : '';
$father_occu2=str_replace("'", "", $father_occu1);
$guard_address1=isset($sheet['cells'][$x][$guard_address]) ? $sheet['cells'][$x][$guard_address] : '';
$guard_address2=str_replace("'", "", $guard_address1);

$adm_date1=isset($sheet['cells'][$x][$adm_date]) ? $sheet['cells'][$x][$adm_date] : '';
$adm_date2=str_replace("'", "", $adm_date1);

/*           Student id start                */
$a = mysql_query("SELECT  MAX(s_id) FROM student_profile")or die(mysql_error());
	 
while($row = mysql_fetch_array($a)){

		$s_id_before=$row['MAX(s_id)'];
		
		if($s_id_before=="")
		{
		$s_id=1000001;
		$f_word="KRM";
		$student_id=$f_word.$s_id;
	    }
		else
		{
		$s_id=$s_id_before+1;
		$f_word="KRM";
		$student_id=$f_word.$s_id;
		}
}
/*           Student id  end               */


/*          Standard name from classes Start             */
$c = mysql_query("SELECT  * FROM classes where class_name='$std_name'")or die(mysql_error());
$row_c = mysql_fetch_array($c);
$standard_name=$row_c['class_name'];
/*          Standard name from classes end             */

/*          section name from tbl_section end             */
$d = mysql_query("SELECT  * FROM  tbl_section where id='$sec_id'")or die(mysql_error());
$row_d = mysql_fetch_array($d);
$section_name=$row_d['sectionname'];
/*          section name from tbl_section end             */



/*       Loop Based on Section name and Standard Name  Start*/
if($std_name==$standard_name && $sec_name==$section_name)
{

$b = mysql_query("SELECT MAX(Roll_no) FROM  student_profile where standard_name='$standard_name' and section_name='$section_name'")or die(mysql_error());


while($row_b = mysql_fetch_array($b))
                {

		$Roll_no=$row_b['MAX(Roll_no)'];
		
		if($Roll_no=="")
		{
		$Roll_no2=1;
		}
		else
		{
		$Roll_no2=$Roll_no+1;
		}
}
}

/*       Loop Based on Section name and Standard Name  End */



/*  Find duplicate Student data and  wont store duplicate data  Remaining data will be sotre   */
$d = mysql_query("SELECT  *  FROM  student_profile where  Name='$first_name2' and standard_name='$std_name' and section_name='$sec_name'  ")or die(mysql_error());
$count_d=mysql_num_rows($d);
$row_d=mysql_fetch_array($d);
if($count_d>0) 
{

echo "<script type=text/javascript>alert('Please check in Excel   '+'$first_name2'+' $std_name'+' $section_name'+' Details already Stored in database.');</script>";
}
else
{
mysql_query("insert into  student_profile(Name,admission_no,Roll_no,student_id,s_id,Reference_id,DOB,City,State,Present_address,Permanent_address,Pin_code,Sex,Blood_group,Academic_year,Father_name,
Father_phone_no,Mother_name,Mother_phone_no,Father_email,Yearly_income,Religion,
Nationality,Mother_tongue,Caste,Community,Community_no,hostel,
Guardian_name,Guardian_phone_no,Guardian_email,Place_birth,Father_occupation,Guardian_address,
Date_admission,status,confirm,Image)values
('$first_name2','$reg_no2','$Roll_no2','$student_id','$s_id','$ref_id2','$dob2','$city2','$state2',
'$present_add2','$perm_add2','$pin_code2','$sex2','$blood_gr2','$acadamic_y2',
'$father_name2','$father_ph2','$mother_name2','$mother_ph_no2','$father_email2','$yearly_in2','$religion2',
'$nationality2','$mother_tong2','$caste2','$comm2','$comm_no2','$hostel2',
'$guard_name2','$guard_ph2','$guard_email2','$place_of_birth2','$father_occu2','$guard_address2',
'$adm_date2','1','1','profile.png')")or die(mysql_error());
  $last_id=mysql_insert_id();

 mysql_query("insert into student_history(stu_id,Standard_id,Section_id,standard_name,section_name,academicyear,student_promote,status)values('$last_id','$std_id','$sec_id','$std_name','$sec_name','','0','0')");
}
/* End  */
$x++;
}


}
$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet
$i=0;
sheetData($excel->sheets[$i],$head_no); 
 echo "<script type=text/javascript>alert('Values Stored into DB Successfully');window.location='example_send.php';</script>";
}


?>