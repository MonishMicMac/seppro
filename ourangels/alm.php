<?php
include("connectsms.php");

if($_REQUEST['ALM']=='stdsecnameid')
{
$str="";
echo '[';
$assign=mysql_query("SELECT * FROM tbl_stc_stn_assign_sec")or die(mysql_error());
while($assign_res=mysql_fetch_array($assign))
{
	$stname=mysql_query("SELECT * FROM mst_st_names WHERE sn_id='".$assign_res['sn_id']."'")or die(mysql_error());
	$stname_res=mysql_fetch_array($stname);
	$secname=mysql_query("SELECT sec_id,sec_name FROM mst_sec WHERE sec_id IN (".$assign_res['sec_id'].")")or die(mysql_error());
	while($secname_res=mysql_fetch_array($secname))
	{
		$str.='{"Standardname":"'.$stname_res['s_names'].'","Sectionname":"'.$secname_res['sec_name'].'","standardid":"'.$stname_res['sn_id'].'","sectionid":"'.$secname_res['sec_id'].'"},';
	}
}
echo substr($str,0,-1).']';
/*$stdsecnameid="SELECT `standard_name` , `section_name` , `Standard_id` , `Section_id` FROM `student_profile` GROUP BY `Standard_id` , `Section_id` ";
	$objQuery = mysql_query($stdsecnameid);
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
	mysql_close($con);	
	echo json_encode($resultArray);*/
}
?>