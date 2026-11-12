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







mysql_query("UPDATE reorting SET attendance='1',latt='$latt',longg='$longg',reporteddate='".date('Y-m-d')."',reportedtime='".date('H:i:s')."',repreportedpro='$proreq',reprepamount='$amo',billno='$com',repservice='$st',sparepartneeded='$sp',pickups='$pu',usedsapreparts='$usp',repremarks='$remarkforrep',incompletecall='0' WHERE id='$wpid'")or die(mysql_error());



?>