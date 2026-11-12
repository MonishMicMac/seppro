<?php
include("connect1.php"); 

$wp_id=$_REQUEST['wp_id'];
$leavee=$_REQUEST['leavee'];


$antony= mysql_query("SELECT repid,leaveapplieddate FROM repgivenasleave WHERE id='$wp_id'")or die(mysql_error());
  $antony_count = mysql_num_rows($antony);
  if($antony_count > 0)
  {
   	$antony_res=mysql_fetch_array($antony);
   	$repid=	$antony_res['repid'];
   	$leaveapplieddate=$antony_res['leaveapplieddate'];
   		
  }

if($_REQUEST['leavee']=='2')
{
	mysql_query("DELETE  FROM repgivenasleave WHERE  repid= '$repid' AND id='$wp_id'")or die(mysql_error());

	$jjrepname = mysql_query("SELECT rep_name FROM representative WHERE id = '$repid'")or die(mysql_error());
	$jjrename_res = mysql_fetch_array($jjrepname);

	$leaverepid= $repid;
	$repname= $jjrename_res['rep_name'];
	$leavedate= $leaveapplieddate;
	$leavereason= 'leaveapproval cancel';

	$a = mysql_query("SELECT gcm_users.gcm_regid,gcm_users.name FROM gcm_users WHERE name='$repid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);
	$gcmlen = strlen($jj['gcm_regid']);
    if($gcmlen <5)
    {
    }
    else
    {        
        $regId = $jj['gcm_regid'];
    	$message = $leaverepid.",".$leavedate.",".$leavereason.",".$leavereason;   

    //  echo   $regId;exit();
    	include_once './GCM.php';     
    	$gcm = new GCM(); 
    	$registatoin_ids = array($regId);
    	$message = array("price" => $message); 
 		$result = $gcm->send_notification($registatoin_ids, $message);
    	echo $result;   
    }

}
else
{
//	mysql_query("DELETE  FROM repgivenasleave WHERE  repid= '$repid' AND id='$wp_id'")or die(mysql_error());

	$jjrepname = mysql_query("SELECT rep_name FROM representative WHERE id = '$repid'")or die(mysql_error());
	$jjrename_res = mysql_fetch_array($jjrepname);

	$leaverepid= $repid;
	$repname= $jjrename_res['rep_name'];
	$leavedate= $leaveapplieddate;
	$leavereason= 'leaveapproval';




	$a = mysql_query("SELECT gcm_users.gcm_regid,gcm_users.name FROM gcm_users WHERE name='$repid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);
	$gcmlen = strlen($jj['gcm_regid']);


    if($gcmlen <5)
    {
    }
    else
    {        
        $regId = $jj['gcm_regid'];
    	$message = $leaverepid.",".$leavedate.",".$leavereason.",".$leavereason;    
      //echo  $message;exit();

    	include_once './GCM.php';     
    	$gcm = new GCM(); 
    	$registatoin_ids = array($regId);
    	$message = array("price" => $message); 
 		$result = $gcm->send_notification($registatoin_ids, $message);
    	echo $result;   
    }
}
?>