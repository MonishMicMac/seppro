<?php
include("connect1.php"); 

$id=$_REQUEST['id'];

$proid = explode(",",$id);
for($i=0;$i< count($proid);$i++)
{
mysql_query("UPDATE doctors SET applyforedit='2',managerapprovestatus='2' WHERE id = '$proid[$i]'")or die(mysql_error());

$jjrepname = mysql_query("SELECT id,doctor_name,rep_id FROM doctors WHERE id = '$proid[$i]'")or die(mysql_error());
	$jjrename_res = mysql_fetch_array($jjrepname);

	$leaverepid= $jjrename_res['id'];
	$repname= $jjrename_res['doctor_name'];
	$leavedate= "";
	$leavereason= 'editleaveapproval';



	$a = mysql_query("SELECT gcm_users.gcm_regid,gcm_users.name FROM gcm_users WHERE name='".$jjrename_res['rep_id']."' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);
	$gcmlen = strlen($jj['gcm_regid']);


    if($gcmlen <5)
    {
    }
    else
    {        
		$regId = $jj['gcm_regid'];
    	$message = $leaverepid.",".$leavedate.",".$leavereason.",".$repname;    
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
