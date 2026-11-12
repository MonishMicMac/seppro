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

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");






 $jjxx = mysql_query("SELECT * FROM temp_doctor_store WHERE hospitalname='$hospitalname' AND drname='$drname' AND repid='$repid' AND specialist= '$specialist' AND qualification='$qualification' AND docpinid='$docpinid' AND docaddress='$docaddress'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into temp_doctor_store(hospitalname,drname,repassign,repid,specialist,qualification,patientpervisit,docpincode,docaddress,docpinid,prescriber,repname)values('$hospitalname','$drname','$repid','$repid','$specialist','$qualification','$patientpervisit','$docpincode','$docaddress','$docpinid','$prescriber','$repname')")or die(mysql_error());





$leaverepid= $repid;

$repname= $repname;
$leavedate= $c_date;
$leavereason= 'addd';

$a = mysql_query("SELECT managerid FROM assigningreptomanager WHERE repid='$repid'")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{

$jjgcm  = mysql_query("SELECT * FROM gcm_users WHERE name='".$jj['managerid']."'")or die(mysql_error());
while($jjgcm_res = mysql_fetch_array($jjgcm))
{

$gcmlen = strlen($jjgcm_res['gcm_regid']);
    if($gcmlen <5)
    {
    }
    else
    {
          // echo $jjgcm_res['gcm_regid'];echo "<br>";
           
    $regId = $jjgcm_res['gcm_regid'];

    $message = $leaverepid.",".$leavedate.",".$leavereason.",".$repname;
     
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;

    }
}

}
}





?>
