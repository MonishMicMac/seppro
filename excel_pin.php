<?php

	include("include/connect.php");
	session_start();
	$id=$_SESSION['id'];
	$m_id16=$_SESSION['m_id16'];
	$dist_id=$_SESSION['dist_id'];
	

$contents="Customer Code,Customer Name,Pincode,Area Name,Bill Number,Bill Date,Product Code,Product Name,Quantity,Sale Value,NetAmount,Replacement Qty,free Qty\n";


$user_query = mysql_query("select * from areawise_temp where invalid_pin='1' and m_id16='$m_id16' and dist_id='$dist_id'");

//While loop to fetch the records
while($row12 = mysql_fetch_array($user_query))
{
/*$r_id=$row['r_id'];

$user_query12 = mysql_query("SELECT * FROM areawise_temp where id='$r_id'");
$row12 = mysql_fetch_array($user_query12);*/


$cust_id=mysql_real_escape_string($row12['cust_id']);
$cust_name=mysql_real_escape_string($row12['cust_name']);

$cust_name1=str_replace(',', ' ', $cust_name);

$pincode=mysql_real_escape_string($row12['pincode']);
$area_name=mysql_real_escape_string($row12['area_name']);

$area_name1=str_replace(',', ' ', $area_name);

$bill_no=mysql_real_escape_string($row12['bill_no']);
$bill_date=mysql_real_escape_string($row12['bill_date']);
$pro_id=mysql_real_escape_string($row12['pro_id']);
$pro_name=mysql_real_escape_string($row12['pro_name']);

$pro_name1=str_replace(',', ' ', $pro_name);

$quantity=mysql_real_escape_string($row12['quantity']);
$sale_value=mysql_real_escape_string($row12['sale_value']);
$net_amount=mysql_real_escape_string($row12['net_amount']);
$replace_quantity=mysql_real_escape_string($row12['replace_quantity']);
$free_quantity=mysql_real_escape_string($row12['free_quantity']);


$contents.=$cust_id.",";
$contents.=$cust_name1.",";
$contents.=$pincode.",";
$contents.=$area_name1.",";

$contents.=$bill_no.",";
$contents.=$bill_date.",";
$contents.=$pro_id.",";
$contents.=$pro_name1.",";

$contents.=$quantity.",";
$contents.=$sale_value.",";
$contents.=$net_amount.",";
$contents.=$replace_quantity.",";
$contents.=$free_quantity."\n";



}

// remove html and php tags etc.
$contents = strip_tags($contents); 

//header to make force download the file
header("Content-Disposition: attachment; filename=pincode".date('d-m-Y').".csv");
print $contents;

//For more examples related PHP visit www.webinfoipedia.com and enjoy demo and free download..
?>