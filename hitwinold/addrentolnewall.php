<?php
include("connect.php"); 


date_default_timezone_set("Asia/Kolkata"); 
$cdate = date('Y-m-d');


	$clientid=$_REQUEST['clientid'];
$productid=$_REQUEST['productid'];
$paytype=$_REQUEST['paytype'];
$daysupply=$_REQUEST['daysupply'];
$rentamt=$_REQUEST['rentamt'];
$depositamt=$_REQUEST['depositamt'];
$access=$_REQUEST['access'];
$repid=$_REQUEST['repid'];
// $status=$_REQUEST['status'];
$assignid=$_REQUEST['assignid'];

$sqln5=mysql_query("SELECT MAX(rent_status) AS maxid FROM rental ");
$rown5=mysql_fetch_array($sqln5);
$maxidnum=$rown5['maxid']+1;
$expproid=explode(",",$_REQUEST['productid']);
for($i=0;$i<count($expproid);$i++)
{
		 	$sql=mysql_query("SELECT rep_name,id FROM representative WHERE rep_name!=''");
			while($row=mysql_fetch_array($sql))
			{

     mysql_query("insert into rental(r_clid,r_pro_id,r_pay_type,r_day_supply,r_ren_amt,r_dop_amt,r_accessories,r_repid,assignid,rent_status)values('$clientid','$expproid[$i]','$paytype','$daysupply','$rentamt','$depositamt','$access','$repid','".$row['id']."','".$maxidnum."')")or die(mysql_error());
 }
}



?>