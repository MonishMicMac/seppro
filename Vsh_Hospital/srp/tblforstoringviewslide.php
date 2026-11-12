<?php
include("connect2.php"); 



date_default_timezone_set("Asia/Kolkata"); 

$productid=$_REQUEST['productid'];
$wpid=$_REQUEST['wpid'];
$dc_id=$_REQUEST['dc_id'];

$cdate=date('Y-m-d');
$ctime=date("h:i:s A");


$proid = explode(",",$productid);

for($i=0;$i< count($proid);$i++)
{

$antony= mysql_query("SELECT * FROM tblforstoringviewslide WHERE wpid='$wpid' AND productid='$proid[$i]'")or die(mysql_error());
   $antony_count = mysql_num_rows($antony);
   if($antony_count > 0)
   {

   }
   else
   {
mysql_query("insert into tblforstoringviewslide(productid,wpid,dc_id,cdate,ctime)values('$proid[$i]','$wpid','$dc_id','$cdate','$ctime')")or die(mysql_error());

}

}









?>