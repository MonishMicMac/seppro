<?php
include("connect.php"); 

$id=$_REQUEST['id'];
$rep_id=$_REQUEST['rep_id'];
$rep_lat=$_REQUEST['rep_lat'];
$rep_long=$_REQUEST['rep_long'];

$latlong = $_REQUEST['rep_lat'].",".$_REQUEST['rep_long'].":";

date_default_timezone_set('Asia/Kolkata');

$cdate= date('Y-m-d');

$ctime= date("H:i");


if($rep_lat === '0.0' || '' || strlen($rep_lat) <= 2 )
{
$x = $je->prepare("UPDATE representative SET lastdate='$cdate',lasttime='$ctime',repcurrentstatus='1',waiting=' ' WHERE id= '$rep_id'")or die(mysql_error());
$x->execute();
}

else
{
$a = $je->prepare("SELECT rep_lat,waiting FROM representative WHERE rep_imeino='$id'")or die(mysql_error());
$a->execute();
$jj=$a->fetchAll();
foreach($jj as $ar)
{
$ar['rep_lat'];
if($rep_lat===$ar['rep_lat'])
{
$w = $ar['waiting']+1;

if($w > 10)
{
$y = $je->prepare("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',waiting='$w',repcurrentstatus='2' WHERE id= '$rep_id'")or die(mysql_error());
$y->execute();


$Y = $je->prepare("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['rep_id']."' AND date='".date("Y/m/d")."'");
$Y->execute();
        echo "1:".$YCNT =$Y->rowCount();
        if($YCNT==0){
        
          $x=$je->prepare("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['rep_id']."','".$_REQUEST['rep_id']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");
echo mysql_error();

$x->execute();
        }
        if($YCNT>0){
        echo "count:". $YCNT;
        
          $P = $Y->fetchObject(); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
          
          $r = $je->prepare("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['rep_id']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
          $r->execute();
        }

}

else
{
$y = $je->prepare("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',waiting='$w' WHERE id= '$rep_id'")or die(mysql_error());
$y->execute();

$Y = $je->prepare("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['rep_id']."' AND date='".date("Y/m/d")."'");
$Y->execute();
       echo "2:".$YCNT = $Y->rowCount();
        if($YCNT==0){
         $YCNT;
         
          $z = $je->prepare("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['rep_id']."','".$_REQUEST['rep_id']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");


$z->execute();
        }
        if($YCNT>0){

          $P = $Y->fetchObject(); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
         
         $alpha =  $je->prepare("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['rep_id']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
         
         $alpha->execute();
        }
}
}

else
{
$b = $je->prepare("UPDATE representative SET rep_lat='$rep_lat',rep_long='$rep_long',lastdate='$cdate',lasttime='$ctime',repcurrentstatus='3',waiting=' ' WHERE id= '$rep_id'")or die(mysql_error());
$b->execute();

$Y = $je->prepare("SELECT * FROM busdayrecord WHERE time='".$_REQUEST['rep_id']."' AND date='".date("Y/m/d")."'");
$Y->execute();
      echo "3:".  $YCNT = $Y->rowCount();
        
        if($YCNT==0){
        
          $in = $je->prepare("INSERT INTO busdayrecord(busid,time,latandlong,latlog,date,travel_time) VALUES('".$_REQUEST['rep_id']."','".$_REQUEST['rep_id']."','".$latlong."','".$latlong."','".date("Y/m/d")."','".date("H:i")."')");
echo mysql_error();

$in->execute();
        }
        if($YCNT>0){
        
          $P = $Y->fetchObject(); $CONCAT = $P->latandlong."".$latlong; $CONTRAVELTIME = $P->travel_time.",".date("H:i");
          
          $up = $je->prepare("UPDATE busdayrecord SET latandlong='".$CONCAT."',latlog='".$latlong."',travel_time='".$CONTRAVELTIME."' WHERE time='".$_REQUEST['rep_id']."' AND date='".date("Y/m/d")."' AND latlog<>'".$latlong."' ");
          $up->execute();
        }
}

}


}

?>