<?php
include("connect23.php"); 

$pid=$_REQUEST['id'];
$pid=$_REQUEST['fromdate'];
$pid=$_REQUEST['todate'];


$date="'".$_REQUEST['fromdate']."','".$_REQUEST['todate']."'";
// echo "SELECT wp_id,wp_date FROM tbl_work_plan WHERE wp_rep_id ='".$_REQUEST['id']."' AND wp_date IN (".$date.")";
$wpdate=mysql_query("SELECT wp_id,wp_date FROM tbl_work_plan WHERE wp_rep_id ='".$_REQUEST['id']."' AND wp_date IN (".$date.")")or die(mysql_error());
while($wpdate_res=mysql_fetch_array($wpdate))
{

	if($_REQUEST['fromdate']==$wpdate_res['wp_date'])
	{
		// echo "UPDATE tbl_work_plan SET wp_date='".$_REQUEST['todate']."' WHERE wp_rep_id ='".$_REQUEST['id']."' AND wp_id='".$wpdate_res['wp_id']."'";
		mysql_query("UPDATE tbl_work_plan SET wp_date='".$_REQUEST['todate']."' WHERE wp_rep_id ='".$_REQUEST['id']."' AND wp_id='".$wpdate_res['wp_id']."'")or die(mysql_error());
		
	}

	if($_REQUEST['todate']==$wpdate_res['wp_date'])
	{
		// echo "UPDATE tbl_work_plan SET wp_date='".$_REQUEST['fromdate']."' WHERE wp_rep_id ='".$_REQUEST['id']."' AND wp_id='".$wpdate_res['wp_id']."'";
		mysql_query("UPDATE tbl_work_plan SET wp_date='".$_REQUEST['fromdate']."' WHERE wp_rep_id ='".$_REQUEST['id']."' AND wp_id='".$wpdate_res['wp_id']."'")or die(mysql_error());
		
	}
}



?>
