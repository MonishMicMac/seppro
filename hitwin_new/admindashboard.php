<?php
include('connect.php');

if($_REQUEST['cmd']=='PEN')
{
$penres;
echo '[';
	$pending = mysql_query("SELECT id,rep_name,mobile,email,taskowner,COUNT(task_status) AS PTOT FROM mst_task_scheduling,representative WHERE representative.id=mst_task_scheduling.taskowner AND task_status='0'GROUP BY taskowner")or die(mysql_error());
	if(mysql_num_rows($pending)>0)
	{
		while($pending_res=mysql_fetch_array($pending))
		{	
			$penlow=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS PL FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$pending_res['taskowner']."' AND priority='Low' AND task_status='0'")or die(mysql_error());
			$penlow_res=mysql_fetch_array($penlow);
			//echo "ID&Name:".$penlow_res['id']."&".$penlow_res['rep_name']."COUNT PL".$penlow_res['PL'];echo "<br>";

			$penmedium=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS PM FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$pending_res['taskowner']."' AND priority='Medium' AND task_status='0'")or die(mysql_error());
			$penmedium_res=mysql_fetch_array($penmedium);
			//echo "MID&Name:".$penmedium_res['id']."&".$penmedium_res['rep_name']."COUNT PM".$penmedium_res['PM'];echo "<br>";

			$penhigh=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS PH FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$pending_res['taskowner']."' AND priority='High' AND task_status='0'")or die(mysql_error());
			$penhigh_res=mysql_fetch_array($penhigh);
			//echo "MID&Name:".$penhigh_res['id']."&".$penhigh_res['rep_name']."COUNT PH".$penhigh_res['PH'];echo "<br>";
			
			$penod=mysql_query("SELECT COUNT(ts_id) AS OD FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$pending_res['taskowner']."' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
			$penod_res=mysql_fetch_array($penod);


			$penres.='{"ID":"'.$pending_res['id'].'","Name":"'.$pending_res['rep_name'].'","Mobile":"'.$pending_res['mobile'].'","Email":"'.$pending_res['email'].'","Low":"'.$penlow_res['PL'].'","Medium":"'.$penmedium_res['PM'].'","High":"'.$penhigh_res['PH'].'","Total":"'.$pending_res['PTOT'].'","OD":"'.$penod_res['OD'].'"},';

			
		}

		echo substr($penres,0,-1).']';
	}
	else
	{
		echo ']';
	}
}


if($_REQUEST['cmd']=='COM')
{
$comres;
echo '[';
	$completed = mysql_query("SELECT id,rep_name,mobile,email,taskowner,COUNT(task_status) AS CTOT FROM mst_task_scheduling,representative WHERE representative.id=mst_task_scheduling.taskowner AND task_status='1'GROUP BY taskowner")or die(mysql_error());
	if(mysql_num_rows($completed)>0)
	{
		while($completed_res=mysql_fetch_array($completed))
		{	
			$comlow=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS CL FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$completed_res['taskowner']."' AND priority='Low' AND task_status='1' ")or die(mysql_error());
			$comlow_res=mysql_fetch_array($comlow);
		
			$commedium=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS CM FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$completed_res['taskowner']."' AND priority='Medium' AND task_status='1'")or die(mysql_error());
			$commedium_res=mysql_fetch_array($commedium);

			$comhigh=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS CH FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$completed_res['taskowner']."' AND priority='High' AND task_status='1'")or die(mysql_error());
			$comhigh_res=mysql_fetch_array($comhigh);

			$comres.='{"ID":"'.$completed_res['id'].'","Name":"'.$completed_res['rep_name'].'","Mobile":"'.$completed_res['mobile'].'","Email":"'.$completed_res['email'].'","Low":"'.$comlow_res['CL'].'","Medium":"'.$commedium_res['CM'].'","High":"'.$comhigh_res['CH'].'","Total":"'.$completed_res['CTOT'].'"},';

			
		}

		echo substr($comres,0,-1).']';
	}
	else
	{
		echo ']';
	}

}




if($_REQUEST['cmd']=='EXP')
{
$expres;
echo '[';
	$expired = mysql_query("SELECT id,rep_name,mobile,email,taskowner,COUNT(task_status) AS ETOT FROM mst_task_scheduling,representative WHERE representative.id=mst_task_scheduling.taskowner AND task_status='0' AND taskdate<'".date('Y-m-d')."' GROUP BY taskowner")or die(mysql_error());
	if(mysql_num_rows($expired)>0)
	{
		while($expired_res=mysql_fetch_array($expired))
		{	
			$explow=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS EL FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$expired_res['taskowner']."' AND priority='Low' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
			$explow_res=mysql_fetch_array($explow);


			$expmedium=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS EM FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$expired_res['taskowner']."' AND priority='Medium' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
			$expmedium_res=mysql_fetch_array($expmedium);


			$exphigh=mysql_query("SELECT id,rep_name,mobile,COUNT(priority) AS EH FROM representative,mst_task_scheduling WHERE representative.id=mst_task_scheduling.taskowner AND representative.id='".$expired_res['taskowner']."' AND priority='High' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
			$exphigh_res=mysql_fetch_array($exphigh);


			$expres.='{"ID":"'.$expired_res['id'].'","Name":"'.$expired_res['rep_name'].'","Mobile":"'.$expired_res['mobile'].'","Email":"'.$expired_res['email'].'","Low":"'.$explow_res['EL'].'","Medium":"'.$expmedium_res['EM'].'","High":"'.$exphigh_res['EH'].'","Total":"'.$expired_res['ETOT'].'"},';

			
		}

		echo substr($expres,0,-1).']';
	}
	else
	{
		echo ']';
	}

}

?>