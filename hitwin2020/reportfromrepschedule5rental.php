<?php
include('connect.php');


$wpid=$_REQUEST['wpid'];

$st=$_REQUEST['st'];

$proreq=$_REQUEST['proreq'];

$com=$_REQUEST['com'];

$amo=$_REQUEST['amo'];


$latt=$_REQUEST['latt'];

$longg=$_REQUEST['longg'];


$sp=$_REQUEST['sp'];

$pu=$_REQUEST['pu'];

$wat=$_REQUEST['wat'];

$resche=$_REQUEST['resche'];
$otherpdt=$_REQUEST['otherpdt'];
$rentalfromdate=$_REQUEST['rescheFROM'];
$nextvisitdate=$_REQUEST['nextvisitdate'];
$rentaltodate=$_REQUEST['rescheTO'];

// $collectedamt=$_REQUEST['collectedamt'];
$collectedamt=$_REQUEST['rentalamt'];
$collected_autofare=$_REQUEST['autofare'];
$paymentmode = $_REQUEST['paymentmode'];
$rental_advance_amt_received = $_REQUEST['rental_advance_amt_received'];
$rental_deposit_amt_received = $_REQUEST['rental_deposit_amt_received'];

$next_action = $_REQUEST['next_action'];

$ert='0';

$incom = explode(",",$pu);



for($i=0;$i< count($incom);$i++)
{
if($incom[$i]=='1')
{
$ert='1';
}

}



if($collectedamt == '' && $rental_advance_amt_received == '' && $rental_deposit_amt_received == ''){
    $paymentmode = '';
}

$rental_collected_amount_status = 0;
if($collectedamt  != '' && $collectedamt != 0){
    $rental_collected_amount_status = 1;
}

$rental_advance_amt_received_status = 0;
if($rental_advance_amt_received != '' && $rental_advance_amt_received != 0){
    $rental_advance_amt_received_status = 1;
}

$rental_deposit_amt_received_status = 0;
if($rental_deposit_amt_received != '' && $rental_deposit_amt_received != 0){
    $rental_deposit_amt_received_status = 1;
}

$collectedamt_n = ($collectedamt  != '' && $collectedamt != 0)?($collectedamt):0;
$rental_advance_amt_received_n = ($rental_advance_amt_received != '' && $rental_advance_amt_received != 0)?($rental_advance_amt_received):0;
$rental_deposit_amt_received_n = ($rental_deposit_amt_received != '' && $rental_deposit_amt_received != 0)?($rental_deposit_amt_received):0;

if($resche=='' || $resche=='null')
{

    
	$a = mysql_query("SELECT clientid,typeofcall,repid,call_stage,tracking_id FROM reorting WHERE  id='$wpid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);

    $clientid = $jj['clientid'];
    $tracking_id = $jj['tracking_id'];


    mysql_query("UPDATE reorting SET rentalfromdate='$rentalfromdate',rentaltodate='$rentaltodate',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',reasonforservice='$wat',incompletecall='$ert',other_pdt='$otherpdt',paymentmode='$paymentmode',collected_auto_fare='$collected_autofare', collected_amount='$collectedamt',rental_collected_amount_status = '$rental_collected_amount_status', rental_advance_amt_received='$rental_advance_amt_received', rental_advance_amt_received_status = '$rental_advance_amt_received_status', rental_deposit_amt_received= '$rental_deposit_amt_received',	rental_deposit_amt_received_status='$rental_deposit_amt_received_status', next_action='$next_action' WHERE id='$wpid'")or die(mysql_error());

    $clid=mysql_query("SELECT clientid FROM reorting WHERE id='$wpid'")or die(mysql_error());
    $clid_res=mysql_fetch_array($clid);

    $clid=$clid_res['clientid'];

    $chkall=mysql_query("SELECT * FROM clinetcreation WHERE id='$clid' AND latts='' AND longgs=''")or die(mysql_error());
    $cli = mysql_fetch_array($chkall);
    if(mysql_num_rows($chkall)>0)
    {
        mysql_query("UPDATE clinetcreation SET latts='$latt',longgs='$longg' WHERE id='$clid'")or die(mysql_error());
    }

    mysql_query("UPDATE rental_amount_collection SET rental_due_amt_recivd_so_far=rental_due_amt_recivd_so_far+$collectedamt_n,	rental_advance_amt_rcd_so_far=rental_advance_amt_rcd_so_far+$rental_advance_amt_received_n, rental_deposit_amt_rcd_so_far=rental_deposit_amt_rcd_so_far+$rental_deposit_amt_received_n WHERE clientid='$clientid' AND tracking_id='$tracking_id'  ");

}
elseif($resche!='')
{


	$a = mysql_query("SELECT clientid,typeofcall,repid,call_stage,tracking_id FROM reorting WHERE  id='$wpid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);

    $clientid = $jj['clientid'];
    $tracking_id = $jj['tracking_id'];

	mysql_query("UPDATE reorting SET rentalfromdate='$rentalfromdate',rentaltodate='$rentaltodate',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0',paymentmode='$paymentmode',collected_auto_fare='$collected_autofare', collected_amount='$collectedamt',rental_collected_amount_status = '$rental_collected_amount_status', rental_advance_amt_received='$rental_advance_amt_received', rental_advance_amt_received_status = '$rental_advance_amt_received_status', rental_deposit_amt_received= '$rental_deposit_amt_received',	rental_deposit_amt_received_status='$rental_deposit_amt_received_status' , next_action='$next_action'  WHERE id='$wpid'")or die(mysql_error());

    

    mysql_query("UPDATE rental_amount_collection SET rental_due_amt_recivd_so_far=rental_due_amt_recivd_so_far+$collectedamt_n,	rental_advance_amt_rcd_so_far=rental_advance_amt_rcd_so_far+$rental_advance_amt_received_n, rental_deposit_amt_rcd_so_far=rental_deposit_amt_rcd_so_far+$rental_deposit_amt_received_n WHERE clientid='$clientid' AND tracking_id='$tracking_id'  ");

    mysql_query("UPDATE rental_amount_collection  SET rental_advance_amt_rcd_sts=1 WHERE (rental_advance_amt_rcd_so_far=rental_advance_amt_rcd_so_far+$rental_advance_amt_received_n) AND clientid='$clientid' AND tracking_id='$tracking_id' ");

    
    mysql_query("UPDATE rental_amount_collection  SET rental_deposit_amt_rcd_sts=1 WHERE (rental_deposit_amt_rcd_so_far=rental_deposit_amt_rcd_so_far+$rental_deposit_amt_received_n) AND clientid='$clientid' AND tracking_id='$tracking_id' ");

    // mysql_query("UPDATE ")
    
    // $client_or_enquiry_q = mysql_query("SELECT clientOrenquiry FROM clinetcreation WHERE id= '".$client_id."' ");

    // $client_or_enquiry = mysql_fetch_array($client_or_enquiry_q)['clientOrenquiry'];

    // if($client_or_enquiry == 1){

    //     mysql_query("UPDATE client_enquiry_product_list SET rental_collected_amount='$collectedamt',rental_collected_amount_status=1, rental_advance_amt_received='$rental_advance_amt_received', rental_advance_amt_received_status=1,rental_deposit_amt_received='$rental_deposit_amt_received', rental_deposit_amt_received_status=1 WHERE clientid='".$client_id."' AND tracking_id='".$tracking_id."' ");

    // }else{
        
    // }


	$msg = 'Thank you availing our services and making the payment of ';
    if($collectedamt != '' && $rental_advance_amt_received != '' && $rental_deposit_amt_received != ''){
        $msg_nor = $msg . "rental amount - Rs.$collectedamt, advance amount - Rs.$rental_advance_amt_received and deposit amount - Rs.$rental_deposit_amt_received.";
    }else if($collectedamt != '' && $rental_advance_amt_received != ''){
        $msg_nor = $msg . "rental amount - Rs.$collectedamt, advance amount - Rs.$rental_advance_amt_received.";
    }else if ($collectedamt != '' && $rental_deposit_amt_received != ''){
        $msg_nor = $msg . "rental amount - Rs.$collectedamt, deposit amount - Rs.$rental_deposit_amt_received.";
    }else if($rental_advance_amt_received != '' && $rental_deposit_amt_received != ''){
        $msg_nor = $msg . "advance amount - Rs.$rental_advance_amt_received and deposit amount - Rs.$rental_deposit_amt_received.";
    }else if($collectedamt != ''){
        $msg_nor = $msg . "rental amount - Rs.$collectedamt.";
    }
    $comp_msg = ' For feedback or complaint call us +919382266778.-Hitwin Healthcare';
    $msg_nor = $msg_nor . $comp_msg;
	
    if($jj["call_stage"]=="Demo")
    {
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
        
                $trmobile=$cliid['mobileno'];
                
                // $trcom_message =($collectedamt=='')?"Thank you for giving your appointment. Hope you are satisfied with our demo. For feedback or complaint call us  +919382266778.":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us +919382266778.";
                
                $trcom_message =($collectedamt=='')?"Thank you for giving your appointment. Hope you are satisfied with our service. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare": $msg_nor;
                
                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
    }else if($jj["call_stage"]=="Supply")
    {
        
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
                
                $trmobile=$cliid['mobileno'];

                // $trcom_message =($collectedamt=='')?"Thank you for renting our product, your product is delivered. For feedback or complaint call us  +919382266778.":"Thank you availing our services and making the payment of Rs.$collectedamt. Your product is delivered. For feedback or complaint call us @ +919382266778.";

                $trcom_message =($collectedamt=='')?"Thank you for renting our product, your product is delivered. For feedback or complaint call us  +919382266778. -Hitwin Healthcare": $msg_nor;

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

                // $trcom_message =($collectedamt=='')?"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us +919382266778":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us +919382266778.";

                $trcom_message =($collectedamt=='')?"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us +919382266778 -Hitwin Healthcare" : $msg_nor;

                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
    }
     else if($jj["call_stage"]=='Rental Pickup')
    {
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
                
                $trmobile=$cliid['mobileno'];

                $msg_nor = 'We have collected the product. ' . $msg_nor ;
                 $trcom_message =($collectedamt=='')?"Thank you availing our services. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare" : $msg_nor;

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