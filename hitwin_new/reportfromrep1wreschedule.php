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

$usp=$_REQUEST['usp'];

$remarkforrep=$_REQUEST['remarkforrep'];

$nextvisitdate=$_REQUEST['nextvisitdate'];

$reasonforservice=$_REQUEST['rfs'];
$resche=$_REQUEST['resche'];
$repid=$_REQUEST['repid'];


if($resche=='' || $resche=='null')
{
mysql_query("UPDATE reorting SET repid='$repid',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',reasonforservice='$reasonforservice',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0' WHERE id='$wpid'")or die(mysql_error());
}
elseif($resche!='')
{
	$a = mysql_query("SELECT clientid,typeofcall,repid FROM reorting WHERE  id='$wpid' ")or die(mysql_error());
	$jj = mysql_fetch_array($a);
	mysql_query("UPDATE reorting SET repid='$repid',attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',reporteddate='".date('Y-m-d')."',nextvisitdate='$nextvisitdate',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0' WHERE id='$wpid'")or die(mysql_error());
	mysql_query("INSERT INTO reorting (tdate,scheduleddate,clientid,typeofcall,repid) VALUES ('".$resche."','".$resche."','".$jj["clientid"]."','".$jj["typeofcall"]."','".$jj["repid"]."')  ")or die(mysql_error());

}


?>