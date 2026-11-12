<?php
include('connect.php');


$wpid=$_REQUEST['wpid'];

$st=$_REQUEST['st'];

$proreq=$_REQUEST['proreq'];

$com=$_REQUEST['com'];

$amo=$_REQUEST['amo'];

$nextvisitdate=$_REQUEST['nextvisitdate'];

$latt=$_REQUEST['latt'];

$longg=$_REQUEST['longg'];

$prospect_stage=$_REQUEST['prospect_stage'];



$sp=$_REQUEST['sp'];

$pu=$_REQUEST['pu'];

$wat=$_REQUEST['wat'];

$resche=$_REQUEST['resche'];
$otherpdt=$_REQUEST['otherpdt'];

$ert='0';

$incom = explode(",",$pu);

$collectedamt=$_REQUEST['collectedamt'];
//$collectedamt= $_REQUEST['amo'];
$collected_autofare=$_REQUEST['autofare'];
$remarkforrep = $_REQUEST['repremarks'];
$paymenttype = $_REQUEST['paymenttype'];
$paymentmode = $_REQUEST['paymentmode'];

for($i=0;$i< count($incom);$i++)
{
if($incom[$i]=='1')
{
$ert='1';
}

}





if($resche=='' || $resche=='null')
{
mysql_query("UPDATE reorting SET prospect_stage='$prospect_stage',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',reasonforservice='$wat',incompletecall='$ert',other_pdt='$otherpdt',collected_auto_fare='$collected_autofare', collected_amount='$collectedamt', paymenttype='$paymenttype',paymentmode='$paymentmode'  WHERE id='$wpid'")or die(mysql_error());

$clid=mysql_query("SELECT clientid FROM reorting WHERE id='$wpid'")or die(mysql_error());
$clid_res=mysql_fetch_array($clid);

$clid=$clid_res['clientid'];

$chkall=mysql_query("SELECT * FROM clinetcreation WHERE id='$clid' AND latts='' AND longgs=''")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
mysql_query("UPDATE clinetcreation SET latts='$latt',longgs='$longg' WHERE id='$clid'")or die(mysql_error());
}

}
elseif($resche!='')
{

	$a = mysql_query("SELECT clientid,typeofcall,repid,call_stage FROM reorting WHERE id='$wpid' ")or die(mysql_error());
    
	$jj = mysql_fetch_array($a);
	mysql_query("UPDATE reorting SET prospect_stage='$prospect_stage',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0',collected_auto_fare='$collected_autofare', collected_amount='$collectedamt', paymenttype='$paymenttype',paymentmode='$paymentmode' WHERE id='$wpid'")or die(mysql_error());
    
	//mysql_query("INSERT INTO reorting (tdate,scheduleddate,clientid,typeofcall,repid) VALUES ('".$resche."','".$resche."','".$jj["clientid"]."','".$jj["typeofcall"]."','".$jj["repid"]."')  ")or die(mysql_error());
      if($jj["typeofcall"]=="Sales")
      {
    
         if($jj["call_stage"]=="Demo")
         {
            
                     $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                     $cliid = mysql_fetch_array($chkarr);
            
                     $trmobile=$cliid['mobileno'];
                    
                     $trcom_message =($collectedamt=='')?"Thank you for giving your appointment. Hope you are satisfied with our service. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                     
                     
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
                     
                        $trcom_message =($collectedamt=='')?"Thank you for purchasing our product, your product is delivered. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";


                     
                     //$trcom_message="Thank you for purchasing our product and making payment of Rs.$collectedamt, for feedback or complaint call us @ 9382266778.";
                     $trmessage=urlencode($trcom_message);
                     $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                     curl_setopt($ch, CURLOPT_POST, 1);
                     curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                     $data = curl_exec($ch);
         }
         if($jj["call_stage"]=='Payment Collection')
         {
                     $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                     $cliid = mysql_fetch_array($chkarr);
                     
                     $trmobile=$cliid['mobileno'];
                     
                     $trcom_message =($collectedamt=='')?"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us +919382266778 -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";

                     //"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us +919382266778

                  

                     $trmessage=urlencode($trcom_message);
                     $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                     curl_setopt($ch, CURLOPT_POST, 1);
                     curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                     $data = curl_exec($ch);
         }
         if($jj["call_stage"]=='Follow Up')
         {
                     $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                     $cliid = mysql_fetch_array($chkarr);
                     
                     $trmobile=$cliid['mobileno'];
                     
                     $trcom_message =($collectedamt=='')?"Thank you for giving your appointment. Hope you are satisfied with our service. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                     
                     $trmessage=urlencode($trcom_message);
                     $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                     curl_setopt($ch, CURLOPT_POST, 1);
                     curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                     $data = curl_exec($ch);
         }
         if($jj["call_stage"]=='Closure')
         {
                     $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                     $cliid = mysql_fetch_array($chkarr);
                     
                     $trmobile=$cliid['mobileno'];
                     
                     $trcom_message =($collectedamt=='')?"Thank you for giving your appointment. Hope you are satisfied with our service. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";

                     

                     $trmessage=urlencode($trcom_message);
                     $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                     curl_setopt($ch, CURLOPT_POST, 1);
                     curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                     $data = curl_exec($ch);
         }
         
      }
      else if($jj["typeofcall"]=="Rental")
      {
         if($jj["call_stage"]=="Demo")
         {
            ///echo "hi";
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
        
                $trmobile=$cliid['mobileno'];
                //echo $trmobile;
                $trcom_message =($collectedamt=='')?"Thank you for giving your appointment. Hope you are satisfied with our service. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                
                
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
                
                   $trcom_message =($collectedamt=='')?"Thank you for renting our product, your product is delivered. For feedback or complaint call us  +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";

                //$trcom_message="Thank you for purchasing our product and making payment of Rs.$collectedamt, for feedback or complaint call us @ 9382266778.";
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
                 $trcom_message =($collectedamt=='')?"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778.";
                //$trcom_message=".Thank you for renting our product, Rs.$collectedamt collected. For any further queries please call our office +914446845555.";
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
                $trcom_message =($collectedamt=='')?"Thank you availing our services. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"We have collected the product. Thank you availing our services and making the payment of rental amount - Rs.$collectedamt . For feedback or complaint call us +919382266778. -Hitwin Healthcare";


                
                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
         }
      }
      else if($jj["typeofcall"]=="Service")
      {
         if($jj["call_stage"]=='Service')
         {
                $chkarr=mysql_query("SELECT * FROM clinetcreation WHERE id='".$jj["clientid"]."'")or die(mysql_error());
                $cliid = mysql_fetch_array($chkarr);
                
                $trmobile=$cliid['mobileno'];
                
                $trcom_message =($collectedamt=='')?"Thank you availing our services. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare":"Your product is served successfully. Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare";
                
                //$trcom_message="Thank you for giving your appointment, for any complaints / Feedback kindly call us @ 9382266778.";
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

                //$trcom_message="Thank you for purchasing our product and making payment of Rs.$collectedamt, for feedback or complaint call us @ 9382266778.";
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
                 $trcom_message =($collectedamt=='')?"Our executive visited your house for payment collection but couldn't collected the amount as you were not available. Please let us know your availability. For feedback or complaint call us +919382266778 -Hitwin Healthcare":"Thank you availing our services and making the payment of Rs.$collectedamt. For feedback or complaint call us @ +919382266778. -Hitwin Healthcare.";
                $trmessage=urlencode($trcom_message);
                $ch = curl_init('http://hpsms.dial4sms.com/api/web2sms.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"workingkey=A60c12959318181080d62edb252e6a597&to=".$trmobile."&sender=HITWIN&message=".$trmessage);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                $data = curl_exec($ch);
         }   
    
      }
    
    
    
    
    
    
    
}

	//Updating the rep location in background 
   $rep_id_q=mysql_query("SELECT repid FROM reorting WHERE id='$wpid' ")or die(mysql_error());
   $rep_id = mysql_fetch_array($rep_id_q)['repid'];

   include("function_to_update_rep_location_in_geo_server.php");

   update_rep_latlong_geo_server($rep_id,$latt, $longg);
?>