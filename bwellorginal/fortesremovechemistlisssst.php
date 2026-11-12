<?php

include("connect1.php");

$rep_id=$_REQUEST['rep_id'];
$dr_id=$_REQUEST['dr_id'];

$chemist='';

$strSQL = mysql_query("SELECT mapping FROM tbl_cds_master WHERE tbl_cds_status='D' and tbl_cds_dcsid='$dr_id' and tbl_cds_repid='$rep_id'");
while($row=mysql_fetch_array($strSQL)){
	if($row['mapping']!=0){
		$mapping[] = $row['mapping'];
	}
}

if($mapping!=0){
  if(count($mapping)>1){
    for ($i=0; $i < count($mapping); $i++) { 
      $imp_chem[]='\''.$mapping[$i].'\'';
    }
      $chemist=implode(',', $imp_chem);
  } elseif(count($mapping)==1) {
    $chemist='\''.$mapping[0].'\'';
  }
}



if($mapping > 0){
	
	$strSQL = "SELECT * FROM tbl_customer_master WHERE pin_id in (SELECT pin_id FROM rep_area WHERE rep_id='$rep_id' group by pin_id) and id in ($chemist)";

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
}
else
{
echo '[]';

}



?>