<?php
include("connect1.php"); 

$id=$_REQUEST['id'];
$qualifica=$_REQUEST['qualifica'];
$clinopen=$_REQUEST['clinopen'];
$landline=$_REQUEST['landline'];
$email=$_REQUEST['email'];
$shirtsizze=$_REQUEST['shirtsizze'];
$trousersizze=$_REQUEST['trousersizze'];
$sheosizze=$_REQUEST['sheosizze'];
$doctormobibrand=$_REQUEST['doctormobibrand'];
$doctorlapbrand=$_REQUEST['doctorlapbrand'];
$strradio1=$_REQUEST['strradio1'];
$doctorhobby=$_REQUEST['doctorhobby'];
$doctorfriendcircle=$_REQUEST['doctorfriendcircle'];
$hosclinic=$_REQUEST['hosclinic'];
$noofbuds=$_REQUEST['noofbuds'];
$ownpharmacy=$_REQUEST['ownpharmacy'];
$memberdoc=$_REQUEST['memberdoc'];
$cardoc=$_REQUEST['cardoc'];


$jjxx = mysql_query("UPDATE doctors SET `doc_qualification`='$qualifica',`email`='$email',`cli_openingday`='$clinopen',`lanline`='$landline',`docshirtsize`='$shirtsizze',`doctrousersize`='$trousersizze',`docshoesize`='$sheosizze',`mobilebrandname`='$doctormobibrand',`lapbrandname`='$doctorlapbrand',`doc_interestarea`='$strradio1',`doc_hobby`='$doctorhobby',`doc_frd`='$doctorfriendcircle',`hosclinicname`='$hosclinic',`noofbuds`='$noofbuds',`ownpharmacy`='$ownpharmacy',`memberdoc`='$memberdoc',`cardoc`='$cardoc' WHERE id = '$id'")or die(mysql_error());


?>