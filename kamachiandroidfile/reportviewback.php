<?php

include("connect2.php"); 

$pid=$_REQUEST['pid'];



date_default_timezone_set("Asia/Kolkata"); 

$cdate = date('Y-m-d');



$strSQL = "SELECT IFNULL((select GROUP_CONCAT(intimestatus,outtimestatus) from sampletimeinandout where clientid=doctors.id AND c_date='$cdate' order by id asc limit 1),'0') as intime,doctors.id,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_pincode,doctors.rep_id,sampletimeinandout.scheduledate FROM doctors,sampletimeinandout WHERE sampletimeinandout.repid='$pid' AND sampletimeinandout.attenstatus='0' and sampletimeinandout.scheduledate='$cdate' AND doctors.id=sampletimeinandout.clientid ";



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



		
             $sqls1=mysql_query("SELECT attenstatus  FROM sampletimeinandout WHERE clientid =".$arrCol['id']."");
		$rows1=mysql_fetch_array($sqls1);
		$arrCol['attenstatus']=$rows1['attenstatus'];


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>