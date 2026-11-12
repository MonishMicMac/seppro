<?php



    include("connect1.php");

    $nurse_id=$_REQUEST['nurse_id'];
    $patient_id=$_REQUEST['patient_id'];

    $task_id=$_REQUEST['task_id'];
    $lat=$_REQUEST['latitude'];
    $long=$_REQUEST['longtitude'];
    $status=$_REQUEST['status'];
    // $image=$_REQUEST['site_photo'];
  
    
    date_default_timezone_set("Asia/Kolkata");
    $c_date=date('Y-m-d');
    $c_time=date("H:i:s");

    // print('kj');
    // die();
    $jjxx = mysql_query("SELECT * FROM inouttime_nurse WHERE nurse_id='$nurse_id' AND task_id='$task_id'
    AND date='$c_date' AND status='1' ")or die(mysql_error());

    $row12lt=mysql_fetch_array($jjxx);

    $jjxx_count = mysql_num_rows($jjxx);
   
    $jjxxo = mysql_query("SELECT * FROM nurse_assign WHERE  nurse_id='".$nurse_id."' AND id='".$task_id."' ")or die(mysql_error());
    
    $row1=mysql_fetch_array($jjxxo);
    // print_r($row1);exit();
    $fromdate=$row1['fromdate'];

    // echo ($fromdate);


    // exit();


// print_r($jjxx_count);exit();
if($jjxx_count > 0){
    $response = array(
        'status' => 'false',
        'data' => 'Intime already Submitted!'
        );
  echo json_encode($response);
}else{

    

   

    
    $jjsdzz = mysql_query("insert into inouttime_nurse(nurse_id,patient_id,intime,date,latitude,longtitude,status,task_id)
    values('$nurse_id','$patient_id','$c_time','$c_date','$lat','$long','1','$task_id')")or die(mysql_error());


    if($fromdate == $c_date)
    {
      $jjsdzz = mysql_query("UPDATE `nurse_assign` SET `job_started`='1' WHERE nurse_id='".$nurse_id."' AND id='".$task_id."'")or die(mysql_error());
    }

    if($jjxx_count == 0)
    {
        $response = array(
            'status' => 'true',
            'data' => 'Intime insert Sucessfully!'
            );
      echo json_encode($response);
    }

    
}




?>