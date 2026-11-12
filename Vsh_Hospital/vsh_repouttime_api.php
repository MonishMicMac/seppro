<?php



    include("connect23.php");

    $rep_id=$_REQUEST['rep_id'];
   
    $latt=$_REQUEST['latt'];
    $long=$_REQUEST['long'];
 


    date_default_timezone_set("Asia/Kolkata");
    $c_date=date('Y-m-d');
    $c_time=date("H:i:s");


    // print('kj');
    // die();
    $jjxx = mysql_query("SELECT * FROM rep_inouttime WHERE rep_id='$rep_id' 
    AND cdate='$c_date'  ")or die(mysql_error());

$row12lt=mysql_fetch_array($jjxx);

    $jjxx_count = mysql_num_rows($jjxx);
   

// print_r($jjxx_count);exit();
if($jjxx_count == "0"){
	$response = array(
		'status' => 'false',
		'data' => 'Intime is Empty!'
		);
  echo json_encode($response);
}
    
    if($jjxx_count > 0)
    {
        
        $sql12lat = mysql_query("SELECT * FROM rep_inouttime where rep_id='".$rep_id."' AND cdate='".$c_date."'");
        // $row12lt=mysql_fetch_array($sql12lat);
    
            
        if($row12lt['status']== '1'){
            $jjsdzz = mysql_query("UPDATE `rep_inouttime` SET `outtime`='".$c_time."',`end_lat`='".$latt."',`end_long`='".$long."',
            `status`='2' WHERE rep_id='".$rep_id."' AND cdate='".$c_date."' AND status='1'")or die(mysql_error());
    
    
            $jjxxo = mysql_query("SELECT * FROM rep_inouttime WHERE outtime!='' AND rep_id='".$rep_id."' AND `status`='1' AND cdate='".$c_date."'")or die(mysql_error());
    
            $jjxxo_count = mysql_num_rows($jjxxo);
            // print_r($jjxxo_count);exit();
            // if($jjsdzz){
                if($jjxxo_count == 0)
                {
                    $response = array(
                        'status' => 'true',
                        'data' => 'Outtime Updated Sucessfully!'
                        );
                  echo json_encode($response);
                }
            // }
            
            }
            if($row12lt['status']== '2'){
    
        $sql12lat = mysql_query("SELECT * FROM rep_inouttime where rep_id='".$rep_id."'");
        $row12lt=mysql_fetch_array($sql12lat);
    
        $status=$row12lt['status'];
    
        if($status =='2'){
            $response = array(
                'status' => 'false',
                'data' => 'Already updated Sucessfully!'
                );
          echo json_encode($response);
        }else{
            $response = array(
                'status' => 'false',
                'data' => 'Outtime Already Submitted!'
                );
          echo json_encode($response);
        }
          
            }
            
        
    }
  



?>
