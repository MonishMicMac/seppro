<?php

include("../includes/connect_db.php");

 
$bus_ime_no= $_POST['bus_ime_no'];
$bus_latitude=$_POST['bus_latitude'];
$bus_longtitude=$_POST['bus_longtitude'];
$speed=$_POST['speed'];
$bus_no= $_REQUEST['bus_no'];
$latlong = $_REQUEST['bus_latitude'].",".$_REQUEST['bus_longtitude'].":";


$lengthoflat=strlen($bus_ime_no);
$lengthofstring=strlen($bus_latitude);

if($lengthofstring<5 || $lengthoflat<5)
{

}
else
{

$flag['code']=0;
date_default_timezone_set('Asia/Kolkata');	 
$cdate = date("Y-m-d");
$ctime = date("H:i:s");
	if($r=mysql_query("UPDATE bus_record SET bus_latitude='$bus_latitude',bus_longtitude='$bus_longtitude',speed='$speed',cdate='$cdate',ctime='$ctime' WHERE bus_ime_no='$bus_ime_no'",$con))
	{
		$flag['code']=1;
	}



$Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['bus_ime_no']."' AND date='".date("Y/m/d")."'");
        $YCNT = mysql_num_rows($Y);
        if($YCNT==0){
          mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['bus_ime_no']."','".$_REQUEST['bus_no']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");
echo mysql_error();
        }
        if($YCNT>0){
          $P = mysql_fetch_object($Y); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
          mysql_query("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['bus_ime_no']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
        }
	 
	print(json_encode($flag));
	mysql_close($con);
}



?>