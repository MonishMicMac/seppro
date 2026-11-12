<?php
include("connect.php"); 

$chemistordoctor=$_REQUEST['chemistordoctor'];
$chemistordoctorid=$_REQUEST['chemistordoctorid'];
$distrubutorordirect=$_REQUEST['distrubutorordirect'];
$distrubutorordirectid=$_REQUEST['distrubutorordirectid'];
$productid=$_REQUEST['productid'];
$qty=$_REQUEST['qty'];
$mrp=$_REQUEST['mrp'];
$value=$_REQUEST['value'];
$repid=$_REQUEST['repid'];

date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");

$proid = explode(",",$productid);
$qtyid = explode(",",$qty);
$mrpid= explode(",",$mrp);
$valueid= explode(",",$value);

for($i=0;$i< count($proid);$i++)
{

$a=$je->prepare("insert into pobtable(chemistordoctor,chemistordoctorid,distrubutorordirect,distrubutorordirectid,productid,qty,mrp,value,date,time,repid)values('$chemistordoctor','$chemistordoctorid','$distrubutorordirect','$distrubutorordirectid','$proid[$i]','$qtyid[$i]','$mrpid[$i]','$valueid[$i]','$c_date','$c_time','$repid')")or die(mysql_error());
$a->execute();
}






?>
