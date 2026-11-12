<?php
include('connect.php');


$wpid=$_REQUEST['wpid'];

$repid=$_REQUEST['repid'];

$resche=$_REQUEST['resche'];
$nextvisitdate=$_REQUEST['nextvisitdate'];



$st=$_REQUEST['st'];

$proreq=$_REQUEST['proreq'];

$com=$_REQUEST['com'];

$amo=$_REQUEST['amo'];

$prospect_stage=$_REQUEST['prospect_stage'];

$latt=$_REQUEST['latt'];

$longg=$_REQUEST['longg'];


$sp=$_REQUEST['sp'];

$pu=$_REQUEST['pu'];

$wat=$_REQUEST['wat'];




$ert='0';

$incom = explode(",",$pu);

for($i=0;$i< count($incom);$i++)
{
if($incom[$i]=='1')
{
$ert='1';
}

}


$chkall2=mysql_query("SELECT id FROM reorting WHERE clientid='$wpid' AND attendance='1' AND tdate='".date('Y-m-d')."'")or die(mysql_error());
if(mysql_num_rows($chkall2)>0)
{
}
else
{


/*echo "INSERT INTO reorting(tdate,clientid,scheduleddate,scheduledtime,repid,typeofcall,servicetype,productrequested,attendance,latt,longg,reporteddate,reportedtime,repservice,repreportedpro,billno)VALUES('".date('Y-m-d')."','$wpid','".date('Y-m-d')."','".date('H:i:s')."','$repid','SALES CALL','SALES','$proreq','1','$latt','$longg','".date('Y-m-d')."','".date('H:i:s')."','$st','$proreq','$com')";*/
if($resche=='' || $resche=='null')
{
mysql_query("INSERT INTO reorting(tdate,prospect_stage,clientid,scheduleddate,scheduledtime,nextvisitdate,repid,typeofcall,servicetype,productrequested,attendance,latt,longg,reporteddate,reportedtime,repservice,repreportedpro,billno,incompletecall,reasonforservice,pickups)VALUES('".date('Y-m-d')."','$prospect_stage','$wpid','$resche','".date('H:i:s')."','$nextvisitdate','$repid','SALES CALL','SALES','$proreq','1','$latt','$longg','".date('Y-m-d')."','".date('H:i:s')."','$st','$proreq','$com','$ert','$wat','$pu')")or die(mysql_error());
}
elseif($resche!='')
{
    	$a = mysql_query("SELECT clientid,typeofcall,repid FROM reorting WHERE id='$wpid' ")or die(mysql_error());
    
	$jj = mysql_fetch_array($a);
    
	//mysql_query("UPDATE reorting SET prospect_stage='$prospect_stage',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0' WHERE id='$wpid'")or die(mysql_error());
    
    
    mysql_query("INSERT INTO reorting(tdate,prospect_stage,clientid,scheduleddate,scheduledtime,nextvisitdate,repid,typeofcall,servicetype,productrequested,attendance,latt,longg,reporteddate,reportedtime,repservice,repreportedpro,billno,incompletecall,reasonforservice,pickups)VALUES('".date('Y-m-d')."','$prospect_stage','$wpid','".date('Y-m-d')."','".date('H:i:s')."','$nextvisitdate','$repid','SALES CALL','SALES','$proreq','1','$latt','$longg','".date('Y-m-d')."','".date('H:i:s')."','$st','$proreq','$com','$ert','$wat','$pu')")or die(mysql_error());
    
    	mysql_query("INSERT INTO reorting (tdate,scheduleddate,clientid,typeofcall,repid) VALUES ('".$resche."','".$resche."','".$wpid."','SALES CALL','$repid')  ")or die(mysql_error());
    
    
}


	
    
    //echo "INSERT INTO reorting(tdate,prospect_stage,clientid,scheduleddate,scheduledtime,repid,typeofcall,servicetype,productrequested,attendance,latt,longg,reporteddate,reportedtime,repservice,repreportedpro,billno,incompletecall,reasonforservice,pickups)VALUES('$resche','$prospect_stage','$wpid','".date('Y-m-d')."','".date('H:i:s')."','$repid','SALES CALL','SALES','$proreq','1','$latt','$longg','".date('Y-m-d')."','".date('H:i:s')."','$st','$proreq','$com','$ert','$wat','$pu')";
	
}


mysql_query("UPDATE representative SET schedule_status='0' WHERE id='".$_REQUEST['repid']."'")or die(mysql_error());




$clid=mysql_query("SELECT clientid FROM reorting WHERE id='$wpid'")or die(mysql_error());
$clid_res=mysql_fetch_array($clid);

$clid=$clid_res['clientid'];

$chkall=mysql_query("SELECT * FROM clinetcreation WHERE id='$clid' AND latts='' AND longgs=''")or die(mysql_error());
if(mysql_num_rows($chkall)>0)
{
mysql_query("UPDATE clinetcreation SET latts='$latt',longgs='$longg' WHERE id='$clid'")or die(mysql_error());
}
else
{
}


?>