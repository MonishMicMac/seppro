<?php
include('connect.php');


$wpid=$_REQUEST['wpid'];

$st=$_REQUEST['st'];

$proreq=$_REQUEST['proreq'];

$com=$_REQUEST['com'];

$amo=$_REQUEST['amo'];


$sp=$_REQUEST['sp'];

$pu=$_REQUEST['pu'];





$wpidd = explode("*",$wpid);

$stt = explode("*",$st);


$proreqq = explode("*",$proreq);

$comm = explode("*",$com);

$amoo = explode("*",$amo);

$spp = explode("*",$sp);

$puy = explode("*",$pu);





for($i=0;$i< count($wpidd);$i++)
{

mysql_query("UPDATE reorting SET attendance='1',latt='0',longg='0',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',repreportedpro='$proreqq[$i]',reprepamount='$amoo[$i]',billno='$comm[$i]',repservice='$stt[$i]',sparepartneeded='$spp[$i]',pickups='$puy[$i]' WHERE id='$wpidd[$i]'")or die(mysql_error());

}

?>