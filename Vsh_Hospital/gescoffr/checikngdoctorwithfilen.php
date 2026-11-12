<?php
include("connect1.php"); 
$repid=$_REQUEST['repid'];
$leaveapplieddate=$_REQUEST['leaveapplieddate'];
$reason=$_REQUEST['reason'];
$expenses=$_REQUEST['expenses'];
$filename=$_REQUEST['filename'];
$docid=$_REQUEST['drid'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");


// $antony= mysql_query("SELECT * FROM repgivenasleave WHERE repid= '$repid' AND leaveapplieddate= '$leaveapplieddate'")or die(mysql_error());
//    $antony_count = mysql_num_rows($antony);
//    if($antony_count > 0)
//    {

//    }
//    else
//    {
mysql_query("UPDATE doctors SET applyforedit='1' WHERE  id='$docid'")or die(mysql_error());



$jjrepname = mysql_query("SELECT id,rep_name FROM representative WHERE id = (SELECT rep_id FROM doctors WHERE id='$docid') ")or die(mysql_error());
$jjrename_res = mysql_fetch_array($jjrepname);

$jjrepname5 = mysql_query("SELECT doctor_name FROM doctors WHERE id='$docid' ")or die(mysql_error());
$jjrename_res5 = mysql_fetch_array($jjrepname5);



 $doctorname= $jjrename_res5['doctor_name'];
$repname= $jjrename_res['rep_name'];
 $repid4= $jjrename_res['id'];
$leavedate= $leaveapplieddate;
$leavereason= 'edit';



$a = mysql_query("SELECT assigningreptomanager.`managerid`,gcm_users.gcm_regid,gcm_users.name FROM `assigningreptomanager`,gcm_users WHERE assigningreptomanager.`repid`='$repid4' and `assigningreptomanager`.managerid=gcm_users.name")or die(mysql_error());

while($jj = mysql_fetch_array($a))
{

$gcmlen = strlen($jj['gcm_regid']);
    if($gcmlen <5)
    {
    }
    else
    {
          
           
  $regId = $jj['gcm_regid'];
   // $message = $doctorname;
        $message = $repid4.",".$doctorname.",".$leavereason.",".$repname;
 
    include_once './GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
  $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
    
     
    }
}


// }







?>