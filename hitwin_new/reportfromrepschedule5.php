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

for($i=0;$i< count($incom);$i++)
{
if($incom[$i]=='1')
{
$ert='1';
}

}





if($resche=='' || $resche=='null')
{
mysql_query("UPDATE reorting SET prospect_stage='$prospect_stage',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',reasonforservice='$wat',incompletecall='$ert',other_pdt='$otherpdt' WHERE id='$wpid'")or die(mysql_error());

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

	$a = mysql_query("SELECT clientid,typeofcall,repid FROM reorting WHERE id='$wpid' ")or die(mysql_error());
    
	$jj = mysql_fetch_array($a);
	mysql_query("UPDATE reorting SET prospect_stage='$prospect_stage',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',nextvisitdate='$nextvisitdate',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0' WHERE id='$wpid'")or die(mysql_error());
    
	mysql_query("INSERT INTO reorting (tdate,scheduleddate,clientid,typeofcall,repid) VALUES ('".$resche."','".$resche."','".$jj["clientid"]."','".$jj["typeofcall"]."','".$jj["repid"]."')  ")or die(mysql_error());
}


?>