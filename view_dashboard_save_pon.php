<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{

date_default_timezone_set('Asia/Calcutta'); 

 $res=mysql_query("SELECT * FROM representative WHERE rep_name='".$_REQUEST['repname']."'");
$row_res=mysql_fetch_array($res);
// $rescat=mysql_query("select *,(select catname from category where category.catid=representative.cat_id) AS catname from representative ");
// $row_res=mysql_fetch_array($rescat);
// echo "INSERT INTO mst_task_scheduling(taskname,taskdate,definition,taskowner,owner_type,cdatetime,tasktime)VALUES('".$_REQUEST['task']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".$_REQUEST['task']."','".$row_res['id']."','".$row_res['cat_id']."','".date('Y-m-d H:i:s')."','".date('H:i',strtotime($_REQUEST['scheduletime']))."')";
      mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,definition,taskowner,owner_type,cdatetime,tasktime)VALUES('".$_REQUEST['task']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".$_REQUEST['task']."','".$row_res['id']."','".$row_res['cat_id']."','".date('Y-m-d H:i:s')."','".date('H:i',strtotime($_REQUEST['scheduletime']))."')")or die(mysql_error());

    





        
} 
?>