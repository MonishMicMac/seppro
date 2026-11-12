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
 
  
if($_REQUEST['type']=='ALL')
{
  $all=mysql_query("SELECT * FROM representative")or die(mysql_error());

  while($allinsert_res=mysql_fetch_array($all))
  {
    $chkall=mysql_query("SELECT * FROM mst_task_scheduling WHERE taskname='".$_REQUEST['taskname']."' AND taskowner='".$allinsert_res['id']."'")or die(mysql_error());
    if(mysql_num_rows($chkall)>0)
    {}
  else
  {

    mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,definition,taskowner,owner_type,cdatetime,tasktime)VALUES('".$_REQUEST['taskname']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".$_REQUEST['taskdes']."','".$allinsert_res['id']."','".$allinsert_res['cat_id']."','".date('Y-m-d H:i:s')."','".date('H:i',strtotime($_REQUEST['tasktime']))."')")or die(mysql_error());

   
  }
}
 header("location:client_creation_pon.php");
}
else
{
  $taskowner=explode(",",$_REQUEST['empname']);
  for($j=0;$j<count($taskowner);$j++)
  {
    $chk=mysql_query("SELECT * FROM mst_task_scheduling WHERE taskname='".$_REQUEST['taskname']."' AND taskowner='".$taskowner[$j]."'")or die(mysql_error());
    if(mysql_num_rows($chk)>0)
    {}
  else
  {
    // mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,owner_type,hierachy_view,tracker,cdatetime,status,task_status,tasktime)VALUES('".$_REQUEST['tname']."','".date('Y-m-d',strtotime($_REQUEST['tdate']))."','".$_REQUEST['priority']."','".$_REQUEST['tdef']."','$taskowner[$j]','".$_REQUEST['owner']."','','".$_REQUEST['ttracker']."','".date('Y-m-d H:i:s')."','".$_REQUEST['track_status']."','".$_REQUEST['task_status']."','".$_REQUEST['tasktime']."')")or die(mysql_error());

      mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,definition,taskowner,owner_type,cdatetime,tasktime)VALUES('".$_REQUEST['taskname']."','".date('Y-m-d',strtotime($_REQUEST['scheduledate']))."','".$_REQUEST['taskdes']."','".$taskowner[$j]."','".$allinsert_res['cat_id']."','".date('Y-m-d H:i:s')."','".date('H:i',strtotime($_REQUEST['tasktime']))."')")or die(mysql_error());

    
  }
}
 header("location:client_creation_pon.php");
} 



        
} 
?>