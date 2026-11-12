<?php



    include("connect1.php");

    $nurse_id=$_REQUEST['nurse_id'];
    // $id=$_REQUEST['id'];

    $patient_id=$_REQUEST['patient_id'];
    $lat=$_REQUEST['latitude'];
    $long=$_REQUEST['latitude'];
    $status=$_REQUEST['status'];
    $remarks=$_REQUEST['remarks'];
    // $rescheduledate=$_REQUEST['rescheduledate'];

  
    
  

    date_default_timezone_set("Asia/Kolkata");
    $c_date=date('Y-m-d');
    $c_time=date("H:i:s");


    // print('kj');
    // die();
    $jjxx = mysql_query("SELECT * FROM inouttime_nurse WHERE nurse_id='$nurse_id' 
    AND date='$c_date'")or die(mysql_error());

$row12lt=mysql_fetch_array($jjxx);

    $jjxx_count = mysql_num_rows($jjxx);
   

// print_r($jjxx_count);exit();
if($jjxx_count == "0"){
	$response = array(
		'status' => 'true',
		'data' => 'Intime is Empty!'
		);
  echo json_encode($response);
}
    
    if($jjxx_count > 0)
    {
      
    
            
        if($row12lt['status']== '1'){
            $jjsdzz = mysql_query("UPDATE `inouttime_nurse` SET `outtime`='".$c_time."',remarks='".$remarks."',
            `status`='2' WHERE nurse_id='".$nurse_id."' AND date='".$c_date."' AND status='1'")or die(mysql_error());
    
    
            $jjxxo = mysql_query("SELECT * FROM inouttime_nurse WHERE outtime!='' AND nurse_id='".$nurse_id."' AND patient_id='".$patient_id."' AND `status`='1' AND date='".$c_date."'")or die(mysql_error());
    
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
    
        $sql12lat = mysql_query("SELECT * FROM inouttime_nurse where nurse_id='".$nurse_id."' AND patient_id='".$patient_id."'");
        $row12lt=mysql_fetch_array($sql12lat);
    
        $status=$row12lt['status'];
    
        if($status =='2'){
            $response = array(
                'status' => 'true',
                'data' => 'Already updated Sucessfully!'
                );
          echo json_encode($response);
        }else{
            $response = array(
                'status' => 'true',
                'data' => 'Outtime Already Submitted!'
                );
          echo json_encode($response);
        }
            // $customer_map_p_id_q = mysql_query("SELECT id FROM mst_customer_mapping WHERE user_id ='$repid' AND date_c='$c_date' ORDER BY id DESC LIMIT 1 ");
    
            // $customer_map_p_id = mysql_fetch_array($customer_map_p_id_q)['id'];
    
            // $update_last_shop = mysql_query("UPDATE mst_customer_mapping SET each_day_last_shop='1' WHERE id='$customer_map_p_id' ");
            }
            
        
    }
 




?>