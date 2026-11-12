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



date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");






 $jjxx = mysql_query("SELECT * FROM doctors WHERE doc_hospital_clinic_name='$hospitalname' AND doctor_name='$drname' AND rep_assign='$repid' AND doc_specilist_id= '$specialist' AND doc_qualification='$qualification' AND doc_pin_id='$docpinid' AND doctor_addrs='$docaddress'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into doctors(doc_hospital_clinic_name,doctor_name,rep_assign,rep_id,doc_specilist_id,doc_qualification,visitpermonth,doc_pincode,doctor_addrs,doc_pin_id,prescriber,doc_gender,doc_contact_no,stationtype,managerapprovestatus,website,dremailid)values('$hospitalname','$drname','$repid','$repid','$specialist','$qualification','$patientpervisit','$docpincode','$docaddress','$docpinid','$prescriber','$doc_gender','$doc_contact_no','$stationtype','1','$website','$dremailid')")or die(mysql_error());


}





?>
