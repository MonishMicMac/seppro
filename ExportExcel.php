<?php
//This application is developed by www.webinfoipedia.com. || Copyright 2011.
//For more examples related PHP visit www.webinfoipedia.com and enjoy demo and free download..
//connect the database
require_once("include/connect.php");

$a=mysql_query("select * from invalid_total order by id desc");
$count_a=mysql_num_rows($a);
if($count_a>0)
{

while($row_a=mysql_fetch_array($a))
{
$r_id=$row_a['r_id'];

//Enter the headings of the excel columns
$contents="Customer Code,Customer Name,Pincode,Area Name,Bill Number,Bill Date,Product Code,Product Name,Quantity,Sale Value,NetAmount,Replacement Qty,free Qty,Error In Pin,Error In Customer,Error In Product\n";

//Mysql query to get records from datanbase
//You can customize the query to filter from particular date and month etc...Which will depends your database structure.
//echo "SELECT * FROM areawise_temp where id='$r_id'";

$user_query = mysql_query("SELECT * FROM areawise_temp where id='$r_id'");

//While loop to fetch the records
$row = mysql_fetch_array($user_query);

$contents.=$row['cust_id'].",";
$contents.=$row['cust_name'].",";
$contents.=$row['pincode'].",";
$contents.=$row['area_name'].",";

$contents.=$row['bill_no'].",";
$contents.=$row['bill_date'].",";
$contents.=$row['pro_id'].",";
$contents.=$row['pro_name'].",";

$contents.=$row['quantity'].",";
$contents.=$row['sale_value'].",";
$contents.=$row['net_amount'].",";
$contents.=$row['replace_quantity'].",";
$contents.=$row['free_quantity'].",";
$contents.=$row_a['status1'].",";
$contents.=$row_a['status2'].",";
$contents.=$row_a['status3']."\n";
}
// remove html and php tags etc.
$contents = strip_tags($contents); 
//header to make force download the file
header("Content-Disposition: attachment; filename=report".date('d-m-Y').".csv");
print $contents;
//For more examples related PHP visit www.webinfoipedia.com and enjoy demo and free download..
}
else
{


echo "<script type='text/javascript'>alert('No Invalid Entries');window.location.href='upload_areawise.php';</script>";



}
?>