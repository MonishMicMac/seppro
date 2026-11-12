<?php

include("../includes/connect_db.php");

 
$bus_ime_no= $_REQUEST['bus_ime_no'];
$bus_no= $_REQUEST['bus_no'];
$bus_latitude=$_REQUEST['bus_latitude'];
$bus_longtitude=$_REQUEST['bus_longtitude'];
$latlong = $_REQUEST['bus_latitude'].",".$_REQUEST['bus_longtitude'].":";


date_default_timezone_set("Asia/Kolkata");

$lengthofstring=strlen($bus_ime_no);
$lengthoflat=strlen($bus_latitude);

if($lengthofstring<5 || $lengthoflat<5)
{


}
else
{
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