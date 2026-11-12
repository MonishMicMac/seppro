<?php

include("connect1.php");

$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];
$expenses=$_REQUEST['expenses'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


$antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

   }
   else
   {
mysql_query("insert into repgivenasleave(repid,leaveapplieddate,reason,expenses,date,time)values('$repid','$leaveapplieddate','$reason','$expenses','$c_date','$c_time')")or die(mysql_error());

if($expenses=='leave')
{


$jjrepname = mysql_query("SELECT rep_name FROM representative WHERE id = '$repid'")or die(mysql_error());
$jjrename_res = mysql_fetch_array($jjrepname);

$leaverepid= $repid;

$repname= $jjrename_res['rep_name'];
$leavedate= $leaveapplieddate;
$leavereason= 'leave';



$a = mysql_query("SELECT assigningreptomanager.`managerid`,gcm_users.gcm_regid,gcm_users.name FROM `assigningreptomanager`,gcm_users WHERE assigningreptomanager.`repid`='$repid' and `assigningreptomanager`.managerid=gcm_users.name")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{

$gcmlen = strlen($jj['gcm_regid']);
    if($gcmlen <5)
    {
    }
    else
    {
          
           
    $regId = $jj['gcm_regid'];

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