<?php
include('connect.php');

if($_REQUEST['cmd']=='PEN')
{
	if($_REQUEST['pri']=='PT')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tasktime,tracker,task_status FROM mst_task_scheduling,representative WHERE  mst_task_scheduling.taskdate='".$_REQUEST['date']."'


 AND mst_task_scheduling.taskowner=representative.id AND mst_task_scheduling.taskowner='".$_REQUEST['repid']."'";
		$objQuery = mysql_query($strSQL);
                
			$intNumField = mysql_num_fields($objQuery);
			$resultArray = array();
			while($obResult = mysql_fetch_array($objQuery))
			{
				$arrCol = array();
				for($i=0;$i<$intNumField;$i++)
				{
		 			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
				}

				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE mst_task_scheduling.taskdate='".$_REQUEST['date']."' AND AND mst_task_scheduling.taskowner='".$_REQUEST['repid']."'


")or die(mysql_error());
				if(mysql_num_rows($tracker)>0)
				{
					$tracker_res=mysql_fetch_array($tracker);
					if($tracker_res['tracker']=='0')
					{
						$trackername='No Tracker';
					}
					if($tracker_res['tracker']!=0)
					{
						$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
						$trname_res=mysql_fetch_array($trname);
						$trackername=$trname_res['rep_name'];

					}
				
				}
				else
				{$trackername='No name';
				}

				$subtask=mysql_query("SELECT GROUP_CONCAT('$$$',descrip,'-',cdatetime)  AS stdesc FROM subtask WHERE task_id='".$obResult['ts_id']."'")or die(mysql_error());
				if(mysql_num_rows($subtask)>0)
				{
					$subtask_res=mysql_fetch_array($subtask);
					$sbtsk=$subtask_res['stdesc'];
				}
				else
				{
					$sbtsk="NIL";
				}
				$arrCol['Trackername'] = $trackername;
				$arrCol['Subtask'] = $sbtsk;

				array_push($resultArray,$arrCol);
			}
		
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	


	
}


}





?>