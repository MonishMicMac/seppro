<?php
include("../includes/connect_db.php"); 

$busno=$_REQUEST['busno'];
$driverno=$_REQUEST['driverno'];
$drivername=$_REQUEST['drivername'];
$latitude=$_REQUEST['latitude'];
$longitude=$_REQUEST['longitude'];
$imeino=$_REQUEST['imeino'];





$a=mysql_query("insert into busregister(busno,driverno,drivername,latitude,longitude,imeino)values('$busno','$driverno','$drivername','$latitude','$longitude','$imeino')")or die(mysql_error());

?>