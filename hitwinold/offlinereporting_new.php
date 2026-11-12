<?php
include('connect.php');


$wpid=$_REQUEST['wpid'];

$st=$_REQUEST['st'];

$proreq=$_REQUEST['proreq'];

$com=$_REQUEST['com'];

$amo=$_REQUEST['amo'];


$sp=$_REQUEST['sp'];

$pu=$_REQUEST['pu'];

$usp=$_REQUEST['usp'];

$remarkforrep=$_REQUEST['remarkforrep'];

$repid=$_REQUEST['repid'];

$tycall=$_REQUEST['tycall'];

$wat=$_REQUEST['wat'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');

$wpidd = explode("*",$wpid);

$stt = explode("*",$st);


$proreqq = explode("*",$proreq);

$comm = explode("*",$com);

$amoo = explode("*",$amo);

$spp = explode("*",$sp);

$puy = explode("*",$pu);

$usps = explode("*",$usp);
$remarkforrep1 = explode("*",$remarkforrep);

$exptycall = explode("*",$tycall);

$expwat = explode("*",$wat);



for($i=0;$i< count($wpidd);$i++)
{
mysql_query("INSERT INTO reorting(tdate,attendance,latt,longg,reporteddate,reportedtime,repreportedpro,reprepamount,billno,repservice,sparepartneeded,pickups,sparepartused,clientid,repid,typeofcall,reasonforservice,repremarks)VALUES('$c_date','1','0','0','$c_date','".date('H:i:s')."','$proreqq[$i]','$amoo[$i]','$comm[$i]','$stt[$i]','$spp[$i]','$puy[$i]','$usps[$i]','$wpidd[$i]','$repid','$exptycall[$i]','$expwat[$i]','$remarkforrep1[$i]')")or die(mysql_error());
}

?>