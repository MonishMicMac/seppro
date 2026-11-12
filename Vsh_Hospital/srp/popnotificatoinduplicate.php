<?php
include("connect2.php"); 

	$repid='30';
	
	
$a = mysql_query("SELECT managerid FROM assigningreptomanager WHERE repid='$repid'")or die(mysql_error());


while($jj = mysql_fetch_array($a))
{
     //echo "MG:".$jj['managerid']; echo "<br>";echo "<br>";
     
     


//$mgrid = implode(",",$jj['managerid']);
//echo "SELECT * FROM gcm_users WHERE name='".$jj['managerid']."'";
//echo "<br>";

   $jjgcm = mysql_query("SELECT * FROM gcm_users WHERE name= '".$jj['managerid']."'")or die(mysql_error());
   
   $gcm_count = mysql_num_rows($jjgcm);

if($gcm_count > 0)
{

//echo "ID:".$jj['managerid']."CNT:".$gcm_count;echo "<br>";
  while($gcm_res = mysql_fetch_array($jjgcm))
{

$gcmlen = strlen($gcm_res['gcm_regid']);
//echo $gcm_res['gcm_regid'];echo "<br>";
     if($gcmlen <5)
    {
    }
    else
    {
          // echo $gcm_res['gcm_regid'];echo "<br>";
           
            $regId = $gcm_res['gcm_regid'];

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