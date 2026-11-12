<?php
include('connect.php');

date_default_timezone_set('Asia/Calcutta'); 
$created_date_new = date("Y-m-d");


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

$collectedamt=$_REQUEST['collectedamt'];
$collected_autofare=$_REQUEST['autofare'];
$paymentmode = $_REQUEST['paymentmode'];
$rental_advance_amt_received = $_REQUEST['rental_advance_amt_received'];
$rental_deposit_amt_received = $_REQUEST['rental_deposit_amt_received'];

$ert='0';

$incom = explode(",",$pu);



for($i=0;$i< count($incom);$i++)
{
if($incom[$i]=='1')
{
$ert='1';
}

}


//Both resche and nextvisitdate were same






if($resche=='' || $resche=='null')
{
    mysql_query("UPDATE reorting SET rentalfromdate='$rentalfromdate',rentaltodate='$rentaltodate',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',reasonforservice='$wat',incompletecall='$ert',other_pdt='$otherpdt',paymentmode='$paymentmode',collected_auto_fare='$collected_autofare', collected_amount='$collectedamt', rental_advance_amt_received='$rental_advance_amt_received', rental_deposit_amt_received= '$rental_deposit_amt_received' WHERE id='$wpid'")or die(mysql_error());

    $clid=mysql_query("SELECT clientid,repid FROM reorting WHERE id='$wpid'")or die(mysql_error());
    $clid_res=mysql_fetch_array($clid);

    $clid=$clid_res['clientid'];

    $repid=$clid_res['repid'];

    $chkall=mysql_query("SELECT * FROM clinetcreation WHERE id='$clid' AND latts='' AND longgs=''")or die(mysql_error());
    $cli = mysql_fetch_array($chkall);
    if(mysql_num_rows($chkall)>0)
    {
        mysql_query("UPDATE clinetcreation SET latts='$latt',longgs='$longg' WHERE id='$clid'")or die(mysql_error());
    }

    if($nextvisitdate != ''){
        mysql_query("insert into reorting(clientid,scheduleddate,repid,tdate,attendance,typeofcall)values('$clid','$nextvisitdate','$repid','$nextvisitdate','0','Marketing')")or die(mysql_error());
    }

}
elseif($resche!='')
{
    //echo "SELECT clientid,typeofcall,repid,call_stage FROM reorting WHERE  id='$wpid'";

	$a = mysql_query("SELECT clientid,typeofcall,repid,call_stage FROM reorting WHERE  id='$wpid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);
	
	mysql_query("UPDATE reorting SET rentalfromdate='$rentalfromdate',rentaltodate='$rentaltodate',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0',paymentmode='$paymentmode',collected_auto_fare='$collected_autofare', collected_amount='$collectedamt', rental_advance_amt_received='$rental_advance_amt_received', rental_deposit_amt_received= '$rental_deposit_amt_received' WHERE id='$wpid'")or die(mysql_error());
	

    $clid=mysql_query("SELECT clientid,repid FROM reorting WHERE id='$wpid'")or die(mysql_error());
    $clid_res=mysql_fetch_array($clid);

    $clid=$clid_res['clientid'];

    $repid=$clid_res['repid'];


    if($nextvisitdate != ''){
        mysql_query("insert into reorting(clientid,scheduleddate,repid,tdate,attendance,typeofcall)values('$clid','$nextvisitdate','$repid','$nextvisitdate','0','Marketing')")or die(mysql_error());
    }

    if($jj["call_stage"]=="Demo")
    {
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
        
                $trmobile=$cliid['mobileno'];
                //echo $trmobile;
                $trcom_message="Thank you for giving your appointment. Hope you are satisfied with our service. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
    }
    if($jj["call_stage"]=="Supply")
    {
        
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
                
                $trmobile=$cliid['mobileno'];
                
                
                $trcom_message="Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
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
                $trcom_message="Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
    }
     else if($jj["call_stage"]=='Return Pickup')
    {
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
                
                $trmobile=$cliid['mobileno'];
                $trcom_message="Thank you availing our services. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
    }
}


?>