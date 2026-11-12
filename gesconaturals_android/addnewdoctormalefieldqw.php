<?php



include("connect1.php");

$drname=$_REQUEST['drname'];
$hospitalname=$_REQUEST['hospitalname'];
$repid=$_REQUEST['repid'];
$specialist=$_REQUEST['specialist'];
$qualification=$_REQUEST['qualification'];
$patientpervisit=$_REQUEST['patientpervisit'];
$docpincode=$_REQUEST['docpincode'];
$docaddress=$_REQUEST['docaddress'];
$docpinid=$_REQUEST['docpinid'];
$prescriber=$_REQUEST['prescriber'];
$repname=$_REQUEST['repname'];
$doc_gender=$_REQUEST['doc_gender'];
$doc_contact_no=$_REQUEST['doc_contact_no'];
$stationtype=$_REQUEST['stationtype'];

$dremailid=$_REQUEST['dremailid'];
$website=$_REQUEST['website'];


$gender=$_REQUEST['gender'];
$core=$_REQUEST['core'];
$typedr=$_REQUEST['typedr'];
$corebrand=$_REQUEST['corebrand'];

$neww=$_REQUEST['neww'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$rno=$_REQUEST['rno'];
$em=$_REQUEST['em'];
$dob=$_REQUEST['dob'];
$ann=$_REQUEST['ann'];

$lasid=$_REQUEST['lasid'];
$disname=$_REQUEST['disname'];
$stockist_id=$_REQUEST['disid'];
$beatid=$_REQUEST['beatid'];

$jjxxhs = mysql_query("SELECT * FROM Hospitalname WHERE hos_name='$hospitalname' ")or die(mysql_error());
$jjxx_counths = mysql_num_rows($jjxxhs);
if($jjxx_counths > 0)
{
$jjxxhs_row = mysql_fetch_array($jjxxhs)
}
else
{

}

// doc_hospital_clinic_name='$hospitalname' AND
$jjxx = mysql_query("SELECT * FROM doctors WHERE  doctor_name='$drname' AND rep_assign='$repid' AND doc_specilist_id= '$specialist' AND doc_qualification='$qualification' AND doc_pin_id='$docpinid' AND doctor_addrs='$docaddress'")or die(mysql_error());
$jjxx_count = mysql_num_rows($jjxx);
if($jjxx_count > 0)
{

}
else
{
	$jjsdzz = mysql_query("insert into doctors(doc_hospital_clinic_name,doctor_name,rep_assign,rep_id,doc_specilist_id,doc_qualification,visitpermonth,doc_pincode,doctor_addrs,doc_pin_id,drorchemist,doc_contact_no,stationtype,managerapprovestatus,website,dremailid,doc_gender,prescriber,core,corebrand,exsnew,dob,anniversary,regino,email,dis_name,stockist_id,beatid)values('$hospitalname','$drname','$repid','$repid','$specialist','$qualification','$patientpervisit','$docpincode','$docaddress','$docpinid','$doc_gender','$doc_contact_no','$stationtype','1','$website','$dremailid','$gender','$typedr','$core','$corebrand','$neww','$dob','$ann','$rno','$em','$disname','$stockist_id','$beatid')")or die(mysql_error());
	$last_id=mysql_insert_id();

}


$jj = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date = '$c_date' AND wp_rep_id='$repid'  AND beatid = '".$beatid."'")or die(mysql_error());
$jj_count = mysql_num_rows($jj);
if($jj_count != '0')
{

mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_pin_id,wp_dc,wp_dc_id,wp_rep_id,UP,c_date,c_time,beat_status,wp_pin_code,beatid)VALUES('$c_date','0','D','".$last_id."','".$repid."','P','$c_date','$c_time','1','".$docpincode."','".$beatid."')")or die(mysql_error());

}
// else
// {
	
// }











$strSQL = "SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,(select hos_name from Hospitalname WHERE Hospitalname.id=doctors.doc_hospital_clinic_name) AS  doc_hospital_clinic_name,doc_hospital_clinic_name AS hospital_id,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_pin_id,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite FROM doctors WHERE rep_assign='$repid' AND id>'$lasid'";



$objQuery = mysql_query($strSQL);
$intNumField = mysql_num_fields($objQuery);
$resultArray = array();
while($obResult = mysql_fetch_array($objQuery))
{
	$arrCol = array();
	for($i=0;$i<$intNumField;$i++)
	{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
	}


	
	$arrCol['area_name']='no area name';


	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);






?>
