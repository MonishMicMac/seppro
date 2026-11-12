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
	 if($_REQUEST['submitallt']=='insert'){
  $repid = $_REQUEST['taskowner'];   
   $tracker= print_r($_REQUEST["tracker"]); 
      foreach($repid as $repids)
    {
      mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,tracker,tasktime,cdatetime)VALUES('".$_REQUEST["taskname"]."','".date('Y/m/d',strtotime($_REQUEST['taskcompletedate']))."','".$_REQUEST["periority"]."','".$_REQUEST["taskdescription"]."','$repids','$tracker','".$_REQUEST["taskcompletetime"]."',NOW())")or die(mysql_error());
    }
  }

   if($_REQUEST['submitallnt']=='insert'){
  $repid = $_REQUEST['taskowner'];  
      foreach($repid as $repids)
    {      
      mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,tasktime,cdatetime)VALUES('".$_REQUEST["taskname"]."','".date('Y/m/d',strtotime($_REQUEST['taskcompletedate']))."','".$_REQUEST["periority"]."','".$_REQUEST["taskdescription"]."','$repids','".$_REQUEST["taskcompletetime"]."',NOW())")or die(mysql_error());
    }
  }

   if($_REQUEST['submitsept']=='insert'){
  $repid = $_REQUEST['taskowner'];  
   $tracker= print_r($_REQUEST["tracker"]);  
      foreach($repid as $repids)
    {
      mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,tracker,tasktime,cdatetime)VALUES('".$_REQUEST["taskname"]."','".date('Y/m/d',strtotime($_REQUEST['taskcompletedate']))."','".$_REQUEST["periority"]."','".$_REQUEST["taskdescription"]."','$repids','$tracker','".$_REQUEST["taskcompletetime"]."',NOW())")or die(mysql_error());
    }
  }

    if($_REQUEST['submitsept1']=='insert'){
  $repid = $_REQUEST['taskowner'];  
      foreach($repid as $repids)
    {      
      mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,tasktime,cdatetime)VALUES('".$_REQUEST["taskname"]."','".date('Y/m/d',strtotime($_REQUEST['taskcompletedate']))."','".$_REQUEST["periority"]."','".$_REQUEST["taskdescription"]."','$repids','".$_REQUEST["taskcompletetime"]."',NOW())")or die(mysql_error());
    }
  }
  
} ?>