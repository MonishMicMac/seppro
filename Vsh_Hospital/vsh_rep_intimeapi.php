<?php



    include("connect23.php");

    
    $rep_id=$_REQUEST['rep_id'];

    $latt=$_REQUEST['latt'];
    $long=$_REQUEST['long'];
   
  
    date_default_timezone_set("Asia/Kolkata");
    $c_date=date('Y-m-d');
    $c_time=date("H:i:s");


    $jjxx = mysql_query("SELECT * FROM rep_inouttime WHERE rep_id='$rep_id' 
    AND cdate='$c_date' AND intime!='' ")or die(mysql_error());

$row12lt=mysql_fetch_array($jjxx);

    $jjxx_count = mysql_num_rows($jjxx);
   

// print_r($jjxx_count);exit();
if($jjxx_count > 0){
    $response = array(
        'status' => 'false',
        'data' => 'Intime already Submitted!'
        );
  echo json_encode($response);
}else{
    
    

    $jjxx1 = mysql_query("SELECT * FROM rep_inouttime WHERE rep_id='$rep_id' 
    AND cdate='$c_date'")or die(mysql_error());

    $jjxx_count1 = mysql_num_rows($jjxx1);

       
if($jjxx_count1 == 0){
$jjsdzz = mysql_query("insert into rep_inouttime(rep_id,intime,start_latitude,start_longtitude,cdate,status)
    values('$rep_id','$c_time','$latt','$long','$c_date','1')")or die(mysql_error());

    $response = array(
        'status' => 'true',
        'data' => 'Intime insert Sucessfully!'
        );
  echo json_encode($response);

}else{
        // print_r($jjxx_count1);exit();

    $jjsdzz = mysql_query("UPDATE rep_inouttime SET intime='$c_time',start_latitude='$latt',start_longtitude='$long' WHERE rep_id='$rep_id' 
    AND cdate='$c_date' ");



        $response = array(
            'status' => 'true',
            'data' => 'Intime insert Sucessfully!'
            );
      echo json_encode($response);
}
}




?>
