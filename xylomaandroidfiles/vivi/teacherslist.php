<?php
include("../includes/connect_db.php");

$Standard_id=$_REQUEST['Standard_id'];
$Section_id=$_REQUEST['Section_id'];
$strSQL = "SELECT Staff_id,Name,Image,Date_of_join,Handling_subject FROM  staff_profile where Standard_id='$Standard_id' and Section_id='$Section_id'";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
		if($i==4)
		{
		$handle_subject=$obResult[$i];
		if($handle_subject!='')
		{
		$subject_name='';
		$explode_handle_subject=explode(',',$handle_subject);
		foreach($explode_handle_subject as $value)
		{
		$a=mysql_query("select Subject_name from subject where sub_id='$value'");
		$row_a=mysql_fetch_array($a);
		$subject_name.=$row_a['Subject_name'].',';
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
	echo json_encode($resultArray);

?>