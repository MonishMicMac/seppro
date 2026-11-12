<?php

include("connect1.php"); 


  
$id=$_REQUEST['id'];
$rep_lat=$_REQUEST['rep_lat'];
$rep_long=$_REQUEST['rep_long'];

$latlong = $_REQUEST['rep_lat'].",".$_REQUEST['rep_long'].":";

date_default_timezone_set('Asia/Kolkata');

$cdate= date('Y-m-d');

$ctime= date("H:i");


if($rep_lat === '0.0' || '' || strlen($rep_lat) <= 2 || $rep_lat === '0'  )
{
mysql_query("UPDATE representative SET lastdate='$cdate',lasttime='$ctime',repcurrentstatus='1',waiting=' ' WHERE id= '$id'")or die(mysql_error());


}

else
{
$a = mysql_query("SELECT rep_lat,waiting FROM representative WHERE id='$id'")or die(mysql_error());
while($c = mysql_fetch_array($a))
{

if($rep_lat===$c['rep_lat'])
{
$w = $c['waiting']+1;

if($w > 10)
{



$y = mysql_query("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',waiting='$w',repcurrentstatus='2' WHERE id= '$id'")or die(mysql_error());


$Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['id']."' AND date='".date("Y/m/d")."'");
        $YCNT = mysql_num_rows($Y);
        if($YCNT==0){
          mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['id']."','".$_REQUEST['id']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");
echo mysql_error();
        }
        if($YCNT>0){
          $P = mysql_fetch_object($Y); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
          mysql_query("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['id']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
        }

}

else
{

$y = mysql_query("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',waiting='$w' WHERE id= '$id'")or die(mysql_error());


$Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['id']."' AND date='".date("Y/m/d")."'");
        $YCNT = mysql_num_rows($Y);
        if($YCNT==0){
          mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['id']."','".$_REQUEST['id']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");
echo mysql_error();
        }
        if($YCNT>0){
          $P = mysql_fetch_object($Y); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
          mysql_query("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['id']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
        }
}
}

else
{

$b = mysql_query("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',repcurrentstatus='3',waiting=' ' WHERE id= '$id'")or die(mysql_error());


$Y = mysql_query("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['id']."' AND date='".date("Y/m/d")."'");
        $YCNT = mysql_num_rows($Y);
        if($YCNT==0){
          mysql_query("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['id']."','".$_REQUEST['id']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");
echo mysql_error();
        }
        if($YCNT>0){
          $P = mysql_fetch_object($Y); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
          mysql_query("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['id']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
        }
}

}


}

?>