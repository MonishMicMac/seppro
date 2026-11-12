<?php
include('connect.php');

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

function rand_num_gen($call_type){
    $rand = rand(10,100000);
    
    if($call_type == 'Service'){
      $trackingid = 'HSER'.$rand;
    }

    $td_id_q = mysql_query("SELECT tracking_id FROM clinetcreation WHERE tracking_id='".$trackingid."' AND tracking_id != '' ");
    $td_id_exist = mysql_num_rows($td_id_q);
    if($td_id_exist >0){
        $trackingid = rand_num_gen($call_type);
       
    }else{
      return $trackingid;
    }
}

$clientid = $_REQUEST['clientid'];
$proid = $_REQUEST['product_id'];
$remarks = $_REQUEST['remarks'];

$call_type = 'Service';
$tracking_id = rand_num_gen($call_type);
//$user_otp = rand(1000, 9999);

mysql_query("INSERT INTO service_req_clients_from_mble(clientid,tracking_id,product_id,remarks_cus,status)VALUES('$clientid','$tracking_id','$proid','$remarks','0')")or die(mysql_error());


?>