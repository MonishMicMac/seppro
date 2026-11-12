<?php
include("connect23.php"); 

$repid=$_REQUEST['repid'];

$date = $_REQUEST['date'];


$strSQL = mysql_query("SELECT unapproveddoctors.id,unapproveddoctors.doctor_name,unapproveddoctors.doc_pincode,unapproveddoctors.doc_qualification FROM unapproveddoctors WHERE unapproveddoctors.id NOT IN (SELECT GROUP_CONCAT(`wp_dc_id`) FROM `unapprovedtbl_work_plan` WHERE `wp_date`='$date' AND `wp_dc`='D' AND `wp_rep_id`='$repid' AND `drunavailable`='0' GROUP BY `wp_dc_id`)")or die(mysql_error());






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