<?php

include("connect2.php"); 

$pid=$_REQUEST['pid'];



date_default_timezone_set("Asia/Kolkata"); 

$cdate = date('Y-m-d');

/*echo "SELECT IFNULL((select GROUP_CONCAT(intimestatus,outtimestatus) from sampletimeinandout where clientid=doctors.id AND c_date='$cdate' order by id asc limit 1),'0') as intime2,doctors.id,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_pincode,doctors.rep_id,sampletimeinandout.intime  FROM doctors,sampletimeinandout WHERE sampletimeinandout.repid='$pid' and attenstatus='1' and sampletimeinandout.scheduledate='$cdate' AND doctors.id=sampletimeinandout.clientid ";exit();*/

$strSQL = "SELECT IFNULL((select GROUP_CONCAT(intimestatus,outtimestatus) from sampletimeinandout where sampletimeinandout.clientid=doctors.id AND c_date='$cdate' order by id asc limit 1),'0') as intime1,doctors.id,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_pincode,doctors.rep_id,sampletimeinandout.intime,sampletimeinandout.outtime,sampletimeinandout.feedback,sampletimeinandout.outfeedback,sampletimeinandout.timediff,sampletimeinandout.c_date FROM doctors,sampletimeinandout WHERE sampletimeinandout.repid='$pid' and attenstatus='1' and outfeedback!='' and feedback!='' and sampletimeinandout.scheduledate='$cdate' AND doctors.id=sampletimeinandout.clientid ";



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