

<?php
include("connect1.php");


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');
$c_time=date("H:i:s");

$id=$_REQUEST['id'];
$repid=$_REQUEST['repid'];
$doctorid=$_REQUEST['doctorid'];
$purpose=$_REQUEST['purpose'];

/*echo "UPDATE doctors SET com_name='$id',com_status='1'where id='$doctorid'";
echo "UPDATE tbl_work_plan SET purposeofvisit='$purpose',purposestatus='1' WHERE  wp_dc_id='$doctorid' and wp_rep_id='$repid' and wp_date='$c_date'";exit();*/

mysql_query("UPDATE doctors SET com_name='$id',com_status='1'where id='$doctorid'")or die(mysql_error());

mysql_query("UPDATE tbl_work_plan SET purposeofvisit='$purpose',purposestatus='1' WHERE  wp_dc_id='$doctorid' and wp_rep_id='$repid' and wp_date='$c_date'")or die(mysql_error());


?>
