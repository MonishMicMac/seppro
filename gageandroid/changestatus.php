<?php
include("../includes/connect_db.php");

$teacherid=$_REQUEST['teacherid'];
$s_id=$_REQUEST['s_id'];

$strSQL = "SELECT * FROM  teachersparentchat where teacherid='$teacherid'  and id<='$s_id'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		if($i==0)
		{
		$handle_subject=$obResult[$i];
		if($handle_subject!='')
		{
		$subject_name='';
		$explode_handle_subject=explode(',',$handle_subject);
		foreach($explode_handle_subject as $value)
		{

		mysql_query("update teachersparentchat set Teacherstatus='1' where id='$value' ");
		
		}
		$org_subject_name=rtrim($subject_name, ",");
		$arrCol[mysql_field_name($objQuery,$i)] = $org_subject_name;
		}
		else
		{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
		}
		else
		{
		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
			
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	//echo json_encode($resultArray);

?>