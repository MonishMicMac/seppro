<?php
//This application is developed by www.webinfoipedia.com. || Copyright 2011.
//For more examples related PHP visit www.webinfoipedia.com and enjoy demo and free download..


//connect the database
require_once("include/connect.php");

//Enter the headings of the excel columns
$contents="Customer Code,Customer Name,Pincode,Area Name,Bill Number,Bill Date,Product Code,Product Name,Quantity,Sale Value,NetAmount,Replacement Qty,free Qty,Error In Pin,Error In Customer,Error In Product\n";

//Mysql query to get records from datanbase
//You can customize the query to filter from particular date and month etc...Which will depends your database structure.
$user_query = mysql_query('select * from invalid_total order by id desc');

//While loop to fetch the records
while($row = mysql_fetch_array($user_query))
{
$r_id=$row['r_id'];

$user_query12 = mysql_query("SELECT * FROM areawise_temp where id='$r_id'");
$row12 = mysql_fetch_array($user_query12);


$cust_id=mysql_real_escape_string($row12['cust_id']);
$cust_name=mysql_real_escape_string($row12['cust_name']);
$pincode=mysql_real_escape_string($row12['pincode']);
$area_name=mysql_real_escape_string($row12['area_name']);
$bill_no=mysql_real_escape_string($row12['bill_no']);
$bill_date=mysql_real_escape_string($row12['bill_date']);
$pro_id=mysql_real_escape_string($row12['pro_id']);
$pro_name=mysql_real_escape_string($row12['pro_name']);
$quantity=mysql_real_escape_string($row12['quantity']);
$sale_value=mysql_real_escape_string($row12['sale_value']);
$net_amount=mysql_real_escape_string($row12['net_amount']);
$replace_quantity=mysql_real_escape_string($row12['replace_quantity']);
$free_quantity=mysql_real_escape_string($row12['free_quantity']);


$contents.=$cust_id.",";
$contents.=$cust_name.",";
$contents.=$pincode.",";
$contents.=$area_name.",";

$contents.=$bill_no.",";
$contents.=$bill_date.",";
$contents.=$pro_id.",";
$contents.=$pro_name.",";

$contents.=$quantity.",";
$contents.=$sale_value.",";
$contents.=$net_amount.",";
$contents.=$replace_quantity.",";
$contents.=$free_quantity.",";
$contents.=$row['status1'].",";
$contents.=$row['status2'].",";
$contents.=$row['status3']."\n";



}

// remove html and php tags etc.
$contents = strip_tags($contents); 

//header to make force download the file
header("Content-Disposition: attachment; filename=report".date('d-m-Y').".csv");
print $contents;

//For more examples related PHP visit www.webinfoipedia.com and enjoy demo and free download..
?>