<?php



include("connect23.php"); 
$rep_id=$_REQUEST['rep_id'];


date_default_timezone_set("Asia/Kolkata");
$c_date=date('Y-m-d');



$strSQL = "SELECT rep_id,id,rep_name,admincontral,emailidtosend,deleteopen,managertourplanopen,managermoth,manageryear,manager_version,manager_playurl FROM representative WHERE rep_imeino='$rep_id'";



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
		array_push($resultArray,$arrCol);
	}
	
	
	
	echo json_encode($resultArray);






// $jjreprmgr = mysql_query("SELECT id FROM representative WHERE rep_imeino='$rep_id'")or die(mysql_error()); 
// $jjreprmgr_res = mysql_fetch_array($jjreprmgr);
// $ids=$jjreprmgr_res['id'];

// $jjreprmgr1 = mysql_query("SELECT GROUP_CONCAT(repid) AS GCR FROM managerjoinworkplans WHERE managerid='$ids' AND date='$c_date'")or die(mysql_error()); 
// $jjreprmgr_res1 = mysql_fetch_array($jjreprmgr1);




// $getids=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_rep_id IN(".$jjreprmgr_res1['GCR'].") AND wp_dc='D' AND wp_date='".date('Y-m-d')."'")or die(mysql_error());
// while($getids_res=mysql_fetch_array($getids))
// {
// 	$chk=mysql_query("SELECT * FROM tbl_work_plan WHERE wp_date='".date('Y-m-d')."' AND wp_dc='D' AND wp_dc_id='".$getids_res['wp_dc_id']."' AND wp_rep_id='$ids'")or die(mysql_error());
// 	if(mysql_num_rows($chk)>0)
// 	{}
// 	else
// 	{
// 		mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time,UP)VALUES('".date('Y-m-d')."','D','".$getids_res['wp_dc_id']."','$ids','".date('Y-m-d')."','".date('H:i:s')."','P')")or die(mysql_error());
// 	}
// }

	
?>