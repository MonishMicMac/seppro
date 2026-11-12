<?php
include("connect2.php"); 



$id=$_REQUEST['id'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

global $leaverepid,$repname,$leavedate,$leavereason;

$jjxx = mysql_query("UPDATE doctors SET applyforedit='1' WHERE id = '$id'")or die(mysql_error());



$jjrepname = mysql_query("SELECT doctor_name FROM doctors WHERE id = '$id'")or die(mysql_error());
$jjrename_res = mysql_fetch_array($jjrepname);

$leaverepid= $id;

$repname= $jjrename_res['doctor_name'];
$leavedate= $c_date;
$leavereason= 'edit';

$a = mysql_query("SELECT managerid FROM assigningreptomanager WHERE repid='$id'")or die(mysql_error());

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
?>