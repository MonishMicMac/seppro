<?php
include("connect23.php"); 

$repid=$_REQUEST['repid'];

$date = $_REQUEST['date'];


$strSQL = mysql_query("SELECT unapproveddoctors.id,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_qualification FROM unapproveddoctors WHERE unapproveddoctors.id AND unapproveddoctors.rep_assign='$repid'")or die(mysql_error());






	$intNumField = mysql_num_fields($strSQL);
	$resultArray = array();
	while($obResult = mysql_fetch_array($strSQL))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($strSQL,$i)] = $obResult[$i];
		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


	?>