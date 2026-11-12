<?php
include('connect.php');

//Service call
$wpid=$_REQUEST['wpid'];

$st=$_REQUEST['st'];

$proreq=$_REQUEST['proreq'];

$com=$_REQUEST['com'];

$amo=$_REQUEST['amo'];


$latt=$_REQUEST['latt'];

$longg=$_REQUEST['longg'];


$sp=$_REQUEST['sp'];

$pu=$_REQUEST['pu'];

$usp=$_REQUEST['usp'];

$remarkforrep=$_REQUEST['remarkforrep'];

$nextvisitdate=$_REQUEST['nextvisitdate'];

$reasonforservice=$_REQUEST['rfs'];
$resche=$_REQUEST['resche'];
$repid=$_REQUEST['repid'];
$rep_service_type = $_REQUEST['rep_service_type'];

$service_call_comp_status = $_REQUEST['service_call_comp_status'];

//$collectedamt=($_REQUEST['collectedamt'])?$_REQUEST['collectedamt']:'';
$collectedamt = $_REQUEST['amo'];

if($resche=='' || $resche=='null')
{
	mysql_query("UPDATE reorting SET repid='$repid',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0',rep_service_type = '$rep_service_type',service_call_comp_status='$service_call_comp_status' WHERE id='$wpid'")or die(mysql_error());
}
elseif($resche!='')
{
	$a = mysql_query("SELECT clientid,typeofcall,repid,call_stage FROM reorting WHERE  id='$wpid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);
	mysql_query("UPDATE reorting SET repid='$repid',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',reporteddate='".date('Y-m-d')."',nextvisitdate='$nextvisitdate',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0',rep_service_type = '$rep_service_type',service_call_comp_status='$service_call_comp_status' WHERE id='$wpid'")or die(mysql_error());
	
	//mysql_query("INSERT INTO reorting (tdate,scheduleddate,clientid,typeofcall,repid) VALUES ('".$resche."','".$resche."','".$jj["clientid"]."','".$jj["typeofcall"]."','".$jj["repid"]."')  ")or die(mysql_error());


	if($jj["call_stage"]=='Service')
	{
			$chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
			$cliid = mysql_fetch_array($chkarr);
			
			$trmobile=$cliid['mobileno'];
			
			$trcom_message =($collectedamt=='')?"Thank you availing our services. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Your product is served successfully. Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
		
			$trmessage=urlencode($trcom_message);
			$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$data = curl_exec($ch);
	}
	else if($jj["call_stage"]=="Supply")
	{
	
			$chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
			$cliid = mysql_fetch_array($chkarr);
			
			$trmobile=$cliid['mobileno'];
			
				$trcom_message =($collectedamt=='')?"Thank you availing our services. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";

			$trmessage=urlencode($trcom_message);
			$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$data = curl_exec($ch);
	}
	else if($jj["call_stage"]=='Payment Collection')
	{
			$chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
			$cliid = mysql_fetch_array($chkarr);
			
			$trmobile=$cliid['mobileno'];
				$trcom_message =($collectedamt=='')?"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us +919382266778 -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
			$trmessage=urlencode($trcom_message);
			$ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			$data = curl_exec($ch);
	} 

}

	//Updating the rep location in background 

	$rep_id_q=mysql_query("SELECT repid FROM reorting WHERE id='$wpid' ")or die(mysql_error());
	$rep_id = mysql_fetch_array($rep_id_q)['repid'];
	include("function_to_update_rep_location_in_geo_server.php");

	update_rep_latlong_geo_server($rep_id,$latt, $longg);


?>