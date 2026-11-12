<?php



include("connect1.php");


$id=$_REQUEST['id'];
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


$accountname=$_REQUEST['accountname'];
$bankbranch=$_REQUEST['bankbranch'];
$panno=$_REQUEST['panno'];
$ifsccode=$_REQUEST['ifsccode'];




if($docpinid=='0')
{

$jjsdzz = mysql_query("UPDATE doctors SET doc_hospital_clinic_name='$hospitalname',doctor_name='$drname',rep_assign='$repid',rep_id='$repid',doc_specilist_id='$specialist',doc_qualification='$qualification',visitpermonth='$patientpervisit',doctor_addrs='$docaddress',drorchemist='$doc_gender',doc_contact_no='$doc_contact_no',stationtype='$stationtype',managerapprovestatus='1',website='$website',dremailid='$dremailid',doc_gender='$gender',prescriber='$typedr',core='$core',corebrand='$corebrand',exsnew='$neww',dob='$dob',anniversary='$ann',regino='$rno',email='$em' WHERE id='$id'")or die(mysql_error());


}
else
{

$jjsdzz = mysql_query("UPDATE doctors SET doc_hospital_clinic_name='$hospitalname',doctor_name='$drname',rep_assign='$repid',rep_id='$repid',doc_specilist_id='$specialist',doc_qualification='$qualification',visitpermonth='$patientpervisit',doc_pincode='$docpincode',doctor_addrs='$docaddress',doc_pin_id='$docpinid',drorchemist='$doc_gender',doc_contact_no='$doc_contact_no',stationtype='$stationtype',managerapprovestatus='1',website='$website',dremailid='$dremailid',doc_gender='$gender',prescriber='$typedr',core='$core',corebrand='$corebrand',exsnew='$neww',dob='$dob',anniversary='$ann',regino='$rno',email='$em',accountname='$accountname',bankbranch='$bankbranch',panno='$panno',ifsccode='$ifsccode' WHERE id='$id'")or die(mysql_error());


}












?>
