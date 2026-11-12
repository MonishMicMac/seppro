<?php
include("connect2.php"); 


$year='2016-05-';
$repid='2';

$repids = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date LIKE  '$year%' AND wp_rep_id='$repid' AND wp_dc='D' AND attendancestatus='1'")or die(mysql_error());

while($repid_res = mysql_fetch_array($repids))
{
//echo $repid_res['wp_dc_id'];
//echo "<br>";
echo $repid_res['wp_date'];
//echo "<br>";

$docpind = mysql_query("SELECT doc_pin_id FROM doctors WHERE id='".$repid_res['wp_dc_id']."'")or die(mysql_error());

$docpind_res = mysql_fetch_array($docpind);

//echo $repid_res['wp_dc_id']." - ".$docpind_res['doc_pin_id'];
//echo "<br>";



$amount = mysql_query("SELECT pin_amt FROM rep_area WHERE rep_id='$repid' AND pin_id='".$docpind_res['doc_pin_id']."'")or die(mysql_error());

$amount_res = mysql_fetch_array($amount);

echo $amount_res['pin_amt'];
echo "<br>";

}
?>
