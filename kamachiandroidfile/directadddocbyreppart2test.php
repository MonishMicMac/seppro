<?php


include("connect2.php"); 

$customername=$_REQUEST['customername'];
$contactperson=$_REQUEST['contactperson'];
$repid=$_REQUEST['repid'];


$mobile=$_REQUEST['mobile'];
$pincode=$_REQUEST['pincode'];
$client_pinid=$_REQUEST['client_pinid'];
$custometype=$_REQUEST['custometype'];
$address=$_REQUEST['address'];

date_default_timezone_set("Asia/Kolkata");
$cdate=date('Y-m-d');
$c_time=date("H:i:s");






 $jjxx = mysql_query("SELECT * FROM  newlead WHERE customername='$customername' AND contactperson='$contactperson' AND repid='$repid' AND mobile= '$mobile' AND address='$address' AND client_pinid='$client_pinid' AND pincode='$pincode'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into newlead(customername,contactperson,repid,mobile,address,pincode,client_pinid,custometype,cdate)values('$customername','$contactperson','$repid','$mobile','$address','$pincode','$client_pinid','$custometype','$cdate')")or die(mysql_error());


}





?>
