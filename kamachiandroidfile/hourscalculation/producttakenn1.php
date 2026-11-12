<?php

include("connect.php"); 




$strSQL = "SELECT reorting.pickups,reorting.repservice,reorting.productrequested,reorting.reasonforservice,reorting.reporteddate,reorting.repid,reorting.reportedtime,clinetcreation.mobileno,clinetcreation.pincode,clinetcreation.companyname,reorting.id,clinetcreation.id as clientid,clinetcreation.name,reorting.repreportedpro FROM reorting,clinetcreation WHERE reorting.incompletecall ='1' AND clinetcreation.id=reorting.clientid";


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

              $sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
              $arrCol1='';
while($rows=mysql_fetch_array($sqls))
{
	$arrCol1.=$rows['pro_name'].',';
}
if(!$arrcol1='')
{
	 $arrCol1=substr($arrCol1, 0, -1);;
}


		
		$arrCol['pro_taken']=$arrCol1;

		
$sqls1=mysql_query("SELECT rep_name  FROM representative WHERE id =".$arrCol['repid']."");
		$rows1=mysql_fetch_array($sqls1);
		$arrCol['rep_name']=$rows1['rep_name'];



		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>