<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');


$productidd=$_REQUEST['productidd'];
$customerid=$_REQUEST['customerid'];
$repidd=$_REQUEST['repidd'];


$rtd;
$exp = explode(',',$productidd);

$count = count($exp);

for($i=0;$i<$count;$i++)
{

$jj = mysql_query("SELECT * FROM client_product_list WHERE product_id= '$exp[$i]' AND clientid='$customerid' AND rep_id= '$repidd'")or die(mysql_error());
      
    if(mysql_num_rows($jj)>0)
   {

   }
   else
   {

     mysql_query("insert into client_product_list(product_id,clientid,rep_id,date,purchase_date)values('$exp[$i]','$customerid','$repidd','$cdate','$cdate')")or die(mysql_error());



}




}











?>