<?php
include('connect.php');

if($_REQUEST['towner']=='ALL')
{
	$all=mysql_query("SELECT * FROM representative")or die(mysql_error());

		while($allinsert_res=mysql_fetch_array($all))
		{
			$chkall=mysql_query("SELECT * FROM mst_task_scheduling WHERE taskname='".$_REQUEST['tname']."' AND taskowner='".$allinsert_res['id']."'")or die(mysql_error());
   			if(mysql_num_rows($chkall)>0)
			{}
			else
			{

				mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,owner_type,hierachy_view,tracker,cdatetime,status,task_status,tasktime)VALUES('".$_REQUEST['tname']."','".date('Y-m-d',strtotime($_REQUEST['tdate']))."','".$_REQUEST['priority']."','".$_REQUEST['tdef']."','".$allinsert_res['id']."','".$_REQUEST['owner']."','','".$_REQUEST['ttracker']."','".date('Y-m-d H:i:s')."','".$_REQUEST['track_status']."','".$_REQUEST['task_status']."','".$_REQUEST['tasktime']."'")or die(mysql_error());

			}
		}

}
else
{
$taskowner=explode(",",$_REQUEST['towner']);
	for($j=0;$j<count($taskowner);$j++)
	{
   		$chk=mysql_query("SELECT * FROM mst_task_scheduling WHERE taskname='".$_REQUEST['tname']."' AND taskowner='".$_REQUEST['towner'][$j]."'")or die(mysql_error());
   		if(mysql_num_rows($chk)>0)
		{}
		else
		{
			mysql_query("INSERT INTO mst_task_scheduling(taskname,taskdate,priority,definition,taskowner,owner_type,hierachy_view,tracker,cdatetime,status,task_status,tasktime)VALUES('".$_REQUEST['tname']."','".date('Y-m-d',strtotime($_REQUEST['tdate']))."','".$_REQUEST['priority']."','".$_REQUEST['tdef']."','$taskowner[$j]','".$_REQUEST['owner']."','','".$_REQUEST['ttracker']."','".date('Y-m-d H:i:s')."','".$_REQUEST['track_status']."','".$_REQUEST['task_status']."','".$_REQUEST['tasktime']."')")or die(mysql_error());
		}
	}

}	
?>