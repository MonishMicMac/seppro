<?php
include('connect.php');


$rid=$_REQUEST['rid'];
$proid=$_REQUEST['proid'];
$clid=$_REQUEST['clid'];
$paytype=$_REQUEST['paytype'];
$paydate=$_REQUEST['paydate'];
$payamt=$_REQUEST['payamt'];
$feedback=$_REQUEST['feedback'];

// echo "INSERT INTO `rentol_historp`(`rethis_pay_type`,repthis_clid,repthis_proid, `ret_id`, `rethis_pay_date`, `rethis_pay_amt`,  `rethis_feedback`) VALUES ('".$paytype."','".$proid."','".$clid."','".$rid."','".$paydate."','".$payamt."','".$feedback."')";

mysql_query("INSERT INTO `rentol_historp`(`rethis_pay_type`,repthis_clid,repthis_proid, `ret_id`, `rethis_pay_date`, `rethis_pay_amt`,  `rethis_feedback`) VALUES ('".$paytype."','".$proid."','".$clid."','".$rid."','".$paydate."','".$payamt."','".$feedback."')");
// echo "DELETE FROM rental WHERE r_id!='".$rid."' AND rent_status = (select rent_status FROM rental WHERE r_id='".$rid."')";

$sql=mysql_query("select rent_status FROM rental WHERE r_id='".$rid."'");
$row=mysql_fetch_array($sql);

mysql_query("DELETE FROM rental WHERE r_id!='".$rid."' AND rent_status = '".$row['rent_status']."'");             
         

// mysql_query("UPDATE rentol_historp SET ret_pay_type='$paytype',ret_pay_date='$paydate',ret_pay_amt='$payamt',r_status='1',r_feedback='$feedback' WHERE r_id='$rid'")or die(mysql_error());


?>