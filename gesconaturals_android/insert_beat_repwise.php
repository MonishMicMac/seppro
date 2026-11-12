<?php

include("connect1.php");


// $wp_date=$_REQUEST['wp_date'];
// $wp_pin_id=$_REQUEST['wp_pin_id'];
// $wp_dc=$_REQUEST['wp_dc'];
// $wp_dc_id=$_REQUEST['wp_dc_id'];
$rep_id=$_REQUEST['rep_id'];
// $beatid=$_REQUEST['beatid'];
$beatname=$_REQUEST['beatname'];
$pincode=$_REQUEST['pincode'];
// 
// $UP=$_REQUEST['UP'];
// $morningevening=$_REQUEST['morningevening'];



date_default_timezone_set("Asia/Kolkata");

$c_date=date('Y-m-d');

$wpdate=date('Y-m-d',strtotime($_REQUEST['datee']));

// $c_time=date('h:i:s A');

$jj = mysql_query("SELECT * FROM beadname WHERE name = '$beatname'")or die(mysql_error());
$jj_count = mysql_num_rows($jj);
if($jj_count == 0)
{

	mysql_query("INSERT INTO beadname(name)VALUES('".$beatname."')")or die(mysql_error());

	$last_id=mysql_insert_id();

	$jj12 = mysql_query("SELECT * FROM Beatwiserep WHERE repid = '$rep_id' AND beadid='".$last_id."' AND pincode='".$pincode."' ")or die(mysql_error());
	$jj_count12 = mysql_num_rows($jj12);
	if($jj_count12 == 0)
	{
		mysql_query("INSERT INTO Beatwiserep(repid,beadid,pincode,assigndate)VALUES('$rep_id','".$last_id."','".$pincode."','$c_time')")or die(mysql_error());
	}




}
else
{
	$jj_row=mysql_fetch_array($jj);
	$jj1 = mysql_query("SELECT * FROM Beatwiserep WHERE repid = '$rep_id' AND beadid='".$jj_row['id']."' AND pincode='".$pincode."' ")or die(mysql_error());
	$jj_count1 = mysql_num_rows($jj1);
	if($jj_count1 == 0)
	{

		mysql_query("INSERT INTO Beatwiserep(repid,beadid,pincode,assigndate)VALUES('$rep_id','".$jj_row['id']."','".$pincode."','$c_time')")or die(mysql_error());
	}

}

// $jj1 = mysql_query("SELECT * FROM Beatwiserep WHERE repid = '$rep_id' AND beadid='$'")or die(mysql_error());
// 	$jj_count1 = mysql_num_rows($jj);
// 	if($jj_count1 == 0)
// 	{


// mysql_query("INSERT INTO Beatwiserep(repid,beadid,pincode,assigndate)VALUES('$rep_id','".$last_id."','".$pincode."','$c_time')")or die(mysql_error());




// }





?>
