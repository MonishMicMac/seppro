<?php
include('connect.php');

if($_REQUEST['listview']=='A')
{

	// echo "SELECT  * FROM mst_feed_back WHERE  fe_datetime LIKE '%".$_REQUEST['fmonth']."%' ";
	// echo "SELECT  mst_feed_back.fe_id,mst_feed_back.fe_feedback,mst_feed_back.fe_title,representative.id,representative.rep_name,representative.admincontral,DATE_FORMAT(mst_feed_back.fe_datetime, '%H:%i') AS fetime,DATE_FORMAT(mst_feed_back.fe_datetime, '%Y-%m-%d') AS fedate FROM mst_feed_back,representative WHERE mst_feed_back.fe_repid=representative.id AND  mst_feed_back.fe_repid IN (select repid from assigningreptomanager where managerid='".$_REQUEST['repid']."')   ORDER BY fedate ASC";
	$strSQL = "SELECT  mst_feed_back.fe_id,mst_feed_back.fe_feedback,mst_feed_back.fe_title,representative.id,representative.rep_name,representative.admincontral,DATE_FORMAT(mst_feed_back.fe_datetime, '%H:%i') AS fetime,DATE_FORMAT(mst_feed_back.fe_datetime, '%Y-%m-%d') AS fedate FROM mst_feed_back,representative WHERE mst_feed_back.fe_repid=representative.id ";
}

elseif($_REQUEST['listview']=='M')
{
	// echo "SELECT  mst_feed_back.fe_repid,mst_feed_back.fe_feedback,mst_feed_back.fe_title,representative.rep_id,representative.admincontral FROM mst_feed_back,representative WHERE  fe_datetime LIKE '%".$_REQUEST['fmonth']."%' AND representative.id IN (select repid from assigningreptomanager where managerid='".$_REQUEST['repid']."') ";
	$strSQL = "SELECT  mst_feed_back.fe_id,mst_feed_back.fe_feedback,mst_feed_back.fe_title,representative.id,representative.rep_name,representative.admincontral,DATE_FORMAT(mst_feed_back.fe_datetime, '%H:%i') AS fetime,DATE_FORMAT(mst_feed_back.fe_datetime, '%Y-%m-%d') AS fedate FROM mst_feed_back,representative WHERE  mst_feed_back.fe_repid=representative.id AND representative.id IN (select repid from assigningreptomanager where managerid='".$_REQUEST['repid']."') ORDER BY fedate ASC";
}
elseif($_REQUEST['listview']=='R')
{

// 	echo "SELECT mst_feed_back.fe_id,mst_feed_back.fe_feedback,mst_feed_back.fe_title,representative.id,representative.admincontral,DATE_FORMAT(mst_feed_back.fe_datetime, '%H:%i') AS fetime,DATE_FORMAT(mst_feed_back.fe_datetime, '%Y-%m-%d') AS fedate FROM mst_feed_back,representative WHERE mst_feed_back.fe_repid=representative.id AND representative.id IN (select repid from assigningreptomanager where managerid IN(select managerid from assigningreptomanager where repid='".$_REQUEST['repid']."'))
// ORDER BY `fedate` ASC";
	$strSQL = "SELECT mst_feed_back.fe_id,mst_feed_back.fe_feedback,mst_feed_back.fe_title,representative.id,representative.rep_name,representative.admincontral,DATE_FORMAT(mst_feed_back.fe_datetime, '%H:%i') AS fetime,DATE_FORMAT(mst_feed_back.fe_datetime, '%Y-%m-%d') AS fedate FROM mst_feed_back,representative WHERE mst_feed_back.fe_repid=representative.id AND representative.id IN (select repid from assigningreptomanager where managerid IN(select managerid from assigningreptomanager where repid='".$_REQUEST['repid']."'))
ORDER BY `fedate` ASC";
}



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

	if($obResult['admincontral']=='2')
	{
		$arrCol['admincontral'] = 'A';
	}
	else
	{
		if($obResult['rep_id']!='0')
		{
			$arrCol['admincontral'] = 'M';
		}
		elseif($obResult['rep_id']=='0')
		{
			$arrCol['admincontral'] = 'R';
		}
	}
	array_push($resultArray,$arrCol);
}

mysql_close($con);

echo json_encode($resultArray);

?>