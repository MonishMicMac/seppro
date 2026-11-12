
<?php
include('connect.php');



$strSQL = "SELECT representative.rep_name,representative.id FROM representative,assigningreptomanager where representative.id=assigningreptomanager.repid AND assigningreptomanager.managerid='".$_REQUEST['repid']."'";

// SELECT  * FROM assigningreptomanager WHERE managerid='".$_REQUEST['repid']."' AND admincontral='2'




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

		                                     $rep_ck=mysql_query("SELECT IFNULL(count(case when reorting.attendance='0' then 1 END),0) as pending,IFNULL(count(case when reorting.attendance='1' then 1 END),0) as visit,count(*) as planned FROM reorting where reorting.repid='".$obResult['id']."'  AND reorting.tdate LIKE '%".$_REQUEST['wpdate']."%'")or die(mysql_error());
		                                     $rep_row = mysql_fetch_array($rep_ck);
		                                     $arrCol['pending'] = $rep_row['pending'];
		                                     $arrCol['visit'] = $rep_row['visit'];
		                                     $arrCol['planned'] = $rep_row['planned'];

		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>