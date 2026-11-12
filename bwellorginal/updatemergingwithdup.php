<?php
include("connect1.php");
$duplicateid=$_REQUEST['duplicateid'];
$orginalid=$_REQUEST['orginalid'];
$rep_id=$_REQUEST['rep_id'];

$proid = explode(",",$duplicateid);



date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("h:i:s A");






for($i=0;$i< count($proid);$i++){
 
$jjxx = mysql_query("SELECT * FROM mergingduplicatechemist WHERE orginal_id= '$orginalid' AND duplicate_id= '$proid[$i]'")or die(mysql_error());
$jjxx_count = mysql_num_rows($jjxx);
if($jjxx_count==0){
$jjsdzz = mysql_query("INSERT INTO mergingduplicatechemist(orginal_id,duplicate_id,repid,date,time)VALUES('$orginalid','$proid[$i]','$rep_id','$c_date','$c_time')");


mysql_query("UPDATE tbl_customer_master SET rep_id='0' WHERE id='$proid[$i]'");




}
}

?>
