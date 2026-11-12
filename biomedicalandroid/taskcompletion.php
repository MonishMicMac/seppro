<?php
include('connect.php');

$chkcomp=mysql_query("SELECT task_status FROM mst_task_scheduling WHERE ts_id='".$_REQUEST['tsid']."'")or die(mysql_error());
$chkcomp_res=mysql_fetch_array($chkcomp);
if($chkcomp_res['task_status']=='1')
{
	mysql_query("UPDATE mst_task_scheduling SET task_status='1',latti='".$_REQUEST['lat']."',longtiu='".$_REQUEST['lon']."' WHERE ts_id='".$_REQUEST['tsid']."'")or die(mysql_error());

}
if($chkcomp_res['task_status']=='0')
{
	mysql_query("UPDATE mst_task_scheduling SET task_status='1',latti='".$_REQUEST['lat']."',longtiu='".$_REQUEST['lon']."' WHERE ts_id='".$_REQUEST['tsid']."'")or die(mysql_error());

       echo "Completed";
}


?>