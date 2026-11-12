<?php

include("connectsms.php");

$std_id=$_REQUEST['std_id'];
$sec_id=$_REQUEST['sec_id'];

$sql = mysql_query("SELECT sub_id FROM tbl_stc_stn_sec_assign_sub as a WHERE sn_id='$std_id' AND sec_id='$sec_id'");
$row=mysql_fetch_array($sql);
$sub_id=explode(',',$row['sub_id']);

if(count($sub_id)>1){
    for ($i=0; $i < count($sub_id); $i++) { 
      $imp_sub[]='\''.$sub_id[$i].'\'';
    }
      $subject=implode(',', $imp_sub);
  } elseif(count($sub_id)==1) {
    $subject='\''.$sub_id[0].'\'';
  }

$strSQL="SELECT * FROM mst_sub WHERE sub_id in ($subject)";
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
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>