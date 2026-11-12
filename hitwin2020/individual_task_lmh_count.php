<?php
include('connect.php');

if($_REQUEST['cmd']=='PEN')
{
	if($_REQUEST['pri']=='PT')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND mst_task_scheduling.taskowner=representative.id ";
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

				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' ")or die(mysql_error());
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
				$arrCol['Trackername'] = $trackername;

				array_push($resultArray,$arrCol);
			}
		
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}


	if($_REQUEST['pri']=='PH')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='High' AND task_status='0' AND mst_task_scheduling.taskowner=representative.id";
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
				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

				array_push($resultArray,$arrCol);
			}
			
		mysql_close($con);
	
		echo json_encode($resultArray);
	}


	if($_REQUEST['pri']=='PM')
	{
 
		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='Medium' AND task_status='0' AND mst_task_scheduling.taskowner=representative.id";
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
				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

				array_push($resultArray,$arrCol);
			}
		
		mysql_close($con);
	
		echo json_encode($resultArray);
	}




	if($_REQUEST['pri']=='PL')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='Low' AND task_status='0' AND mst_task_scheduling.taskowner=representative.id";
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
				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

				array_push($resultArray,$arrCol);
			}
		
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}

}







if($_REQUEST['cmd']=='COM')
{
	if($_REQUEST['pri']=='CT')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status,latti,longtiu  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND task_status='1' AND mst_task_scheduling.taskowner=representative.id";
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
				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='1'")or die(mysql_error());
				if(mysql_num_rows($tracker)>0)
				{
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
			}else{ $trackername='No Name';}
				$arrCol['Trackername'] = $trackername;

				array_push($resultArray,$arrCol);
			}
		
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}




	if($_REQUEST['pri']=='CH')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status,latti,longtiu  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='High' AND task_status='1' AND mst_task_scheduling.taskowner=representative.id";
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
				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='1'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

				array_push($resultArray,$arrCol);
			}
		
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}


	if($_REQUEST['pri']=='CM')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status,latti,longtiu  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='Medium' AND task_status='1' AND mst_task_scheduling.taskowner=representative.id";
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
			$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='1'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

			array_push($resultArray,$arrCol);
		}
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}




	if($_REQUEST['pri']=='CL')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status,latti,longtiu  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='Low' AND task_status='1' AND mst_task_scheduling.taskowner=representative.id";
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
			$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='1'")or die(mysql_error());
			if(mysql_num_rows($tracker)>0)
				{

				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
}
else
{ $trackername='No Name';
}
				$arrCol['Trackername'] = $trackername;

			array_push($resultArray,$arrCol);
		}
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}

}











if($_REQUEST['cmd']=='EXP')
{

	if($_REQUEST['pri']=='ET')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND taskdate<'".date('Y-m-d')."' AND mst_task_scheduling.taskowner=representative.id";
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

			$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

			array_push($resultArray,$arrCol);
		}
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}


	if($_REQUEST['pri']=='EH')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='High' AND task_status='0' AND taskdate<'".date('Y-m-d')."' AND mst_task_scheduling.taskowner=representative.id";
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
				$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

			array_push($resultArray,$arrCol);
		}
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}


	if($_REQUEST['pri']=='EM')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='Medium' AND task_status='0' AND taskdate<'".date('Y-m-d')."' AND mst_task_scheduling.taskowner=representative.id";
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
			$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."'")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

			array_push($resultArray,$arrCol);
		}
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}




	if($_REQUEST['pri']=='EL')
	{

		$strSQL = "SELECT id,rep_name,ts_id,taskname,taskdate,priority,definition,owner_type,hierachy_view,taskowner,tracker,task_status  FROM mst_task_scheduling,representative WHERE taskowner='".$_REQUEST['towner']."' AND priority='Low' AND task_status='0' AND taskdate<'".date('Y-m-d')."' AND mst_task_scheduling.taskowner=representative.id";
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
			$tracker=mysql_query("SELECT tracker FROM mst_task_scheduling WHERE taskowner='".$_REQUEST['towner']."' AND task_status='0' AND taskdate<'".date('Y-m-d')."'")or die(mysql_error());
				$tracker_res=mysql_fetch_array($tracker);
				if($tracker_res['tracker']=='0')
				{
					$trackername='No Tracker';
				}
				if($tracker_res['tracker']!='0')
				{
					$trname=mysql_query("SELECT rep_name  FROM representative WHERE id='".$tracker_res['tracker']."' ")or die(mysql_error());
					$trname_res=mysql_fetch_array($trname);
					$trackername=$trname_res['rep_name'];

				}
				$arrCol['Trackername'] = $trackername;

			array_push($resultArray,$arrCol);
		}
	
		mysql_close($con);
	
		echo json_encode($resultArray);
	}

}
?>