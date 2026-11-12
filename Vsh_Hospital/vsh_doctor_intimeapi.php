<?php
    include("connect23.php");

    $wp_rep_id=$_REQUEST['wp_rep_id'];
    $wp_dc_id=$_REQUEST['wp_dc_id'];
    $latt=$_REQUEST['latt'];
    $long=$_REQUEST['long'];
   
    date_default_timezone_set("Asia/Kolkata");
    $c_date=date('Y-m-d');
    // $c_time=date("H:i:s");
    $c_time=date("h:i:s A");


    $jjxx = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id' AND wp_dc_id='$wp_dc_id'
    AND wp_date='$c_date' AND intime!='' ")or die(mysql_error());

    $row12lt=mysql_fetch_array($jjxx);

    $jjxx_count = mysql_num_rows($jjxx);

  if($jjxx_count > 0){
    $response = array(
        'status' => 'false',
        'data' => 'Intime already updated!'
        );
  echo json_encode($response);
  
 }else{
    
    $jjxx1 = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id='$wp_rep_id'  AND wp_dc_id='$wp_dc_id'
    AND wp_date='$c_date'")or die(mysql_error());

    $jjxx_count1 = mysql_num_rows($jjxx1);
// print_r($jjxx_count1);exit();
       
 if($jjxx_count1 != 0){
// $jjsdzz = mysql_query("UPDATE into rep_inouttime(rep_id,intime,latitude,longtitude,cdate,status)
//     values('$rep_id','$c_time','$latt','$long','$c_date','1')")or die(mysql_error());
    $jjsdzz = mysql_query("UPDATE tbl_work_plan SET `lat`='".$latt."' ,`long`='".$long."',`intime`='".$c_time."' ,`indate`='".$c_date."' WHERE wp_rep_id='$wp_rep_id' AND wp_dc_id='$wp_dc_id' AND wp_date='$c_date'")or die(mysql_error());

    $response = array(
        'status' => 'true',
        'data' => 'Intime insert Sucessfully!'
        );
  echo json_encode($response);

}
}

?>
