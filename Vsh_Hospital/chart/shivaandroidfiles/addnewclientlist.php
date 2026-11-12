<?php

include("connect23.php"); 

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

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");






 $jjxx = mysql_query("SELECT * FROM client WHERE  doctor_name='$drname' AND rep_assign='$repid' AND doc_pin_id='$docpinid' AND doctor_addrs='$docaddress'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into client(doctor_name,rep_assign,rep_id,doc_pincode,doctor_addrs,doc_pin_id,doc_contact_no)values('$drname','$repid','$repid','$docpincode','$docaddress','$docpinid','$doc_contact_no')")or die(mysql_error());


}





?>