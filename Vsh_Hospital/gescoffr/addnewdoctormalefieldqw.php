<?php



include("connect1.php");

$drname=$_REQUEST['drname'];
$hospitalname=$_REQUEST['hospitalname'];
$repid=$_REQUEST['repid'];
$specialist=$_REQUEST['specialist'];
$qualification=$_REQUEST['qualification'];
$patientpervisit=$_REQUEST['patientpervisit'];
$govtcategory=$_REQUEST['govtcategory'];
$exportcategory=$_REQUEST['exportcategory'];
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
$dis=$_REQUEST['dis'];

$neww=$_REQUEST['neww'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$rno=$_REQUEST['rno'];
$em=$_REQUEST['em'];
$dob=$_REQUEST['dob'];
$ann=$_REQUEST['ann'];
$visit_time=$_REQUEST['visit_time'];
$day_schedule=$_REQUEST['day_schedule'];
$lasid=$_REQUEST['lasid'];

$jjxxhs = mysql_query("SELECT * FROM Hospitalname WHERE hos_name='$hospitalname' AND rep_id='".$repid."' ")or die(mysql_error());
$jjxx_counths = mysql_num_rows($jjxxhs);
if($jjxx_counths > 0)
{
$jjxxhs_row = mysql_fetch_array($jjxxhs);
$dis_id=$jjxxhs_row['id'];
}
else
{
	$jjxxhsnew = mysql_query("SELECT * FROM mst_category WHERE main_cat='$patientpervisit' AND category_name='".$govtcategory."' ")or die(mysql_error());
	$jjxxhsnew_row = mysql_fetch_array($jjxxhsnew);

// $dis_id=$jjxxhs_row['id'];
mysql_query("insert into Hospitalname(hos_name,rep_id,degignation,hos_category)values('$hospitalname','$repid','$patientpervisit','".$jjxxhsnew_row['category_id']."')")or die(mysql_error());
$dis_id = mysql_insert_id();
}
// doc_hospital_clinic_name='$hospitalname' AND
$jjxx = mysql_query("SELECT * FROM doctors WHERE  doctor_name='$drname' AND rep_assign='$repid' AND doc_specilist_id= '$specialist' AND doc_qualification='$qualification' AND doc_pin_id='$docpinid' AND doctor_addrs='$docaddress'")or die(mysql_error());
$jjxx_count = mysql_num_rows($jjxx);
if($jjxx_count > 0)
{

}
else
{
	$jjsdzz = mysql_query("insert into doctors(day_schedule,visit_time,doc_hospital_clinic_name,doctor_name,rep_assign,rep_id,doc_specilist_id,doc_qualification,visitpermonth,govt_category,export_category,doc_pincode,doctor_addrs,doc_pin_id,doc_classification,doc_contact_no,stationtype,managerapprovestatus,website,emailidd,doc_gender,prescriber,core,corebrand,exsnew,dob,anniversary,regino,email,unapprovedoctor,distributor_id)values('$day_schedule','$visit_time','$dis_id','$drname','$repid','$repid','$specialist','$qualification','$patientpervisit','$govtcategory','$exportcategory','$docpincode','$docaddress','$docpinid','$doc_gender','$doc_contact_no','$stationtype','0','$website','$dremailid','$gender','$typedr','$core','$corebrand','$neww','$dob','$ann','$rno','$em','1','$dis')")or die(mysql_error());


}











$strSQL = "SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,distributor_id,doc_qualification,doc_classification,doc_gender,doc_specilist_id,(select doctor_name from doctors1 WHERE doctors1.id=doctors.distributor_id) AS distributor_id,(select hos_name from Hospitalname WHERE Hospitalname.id=doctors.doc_hospital_clinic_name) AS  hospital_id,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_pin_id,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,govt_category,export_category,visitpermonth FROM doctors WHERE rep_assign='$repid' AND id>'$lasid'";



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
