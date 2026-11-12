<?php
include("connect23.php"); 
	
	
	$today = date("Y-m-d");

$wp_rep_id=$_REQUEST['wp_rep_id'];


global $dcid,$datee;

$strSQL = mysql_query("SELECT * FROM doctors WHERE rep_id='$wp_rep_id'")or die(mysql_error());
while($strres = mysql_fetch_array($strSQL))
{
//datee='0';
$dcid=$strres['id'];
echo $dcid;
echo "<br>";
$tbl = mysql_query("SELECT * FROM tbl_work_plan WHERE wp_dc_id = '$dcid' AND attendancestatus='1' ORDER BY wp_id DESC LIMIT 1")or die(mysql_error());

while($tbll = mysql_fetch_array($tbl))
{

$dcidd=$tbll['reporteddate'];
echo $dcidd;
//echo "<br>";

$today_time = strtotime($today);
$expire_time = strtotime($dcidd);
$dclen = strlen($dcidd);
if($expire_time=='')
{
echo $dcid.'0'."<br>";
}
else
{
echo $dcid.'no1'."<br>";


}

}




}
	



?>