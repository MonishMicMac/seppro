<?php

include("connect23.php"); 

$month=$_REQUEST['month'];
$repid=$_REQUEST['repid'];
$year=$_REQUEST['year'];

$date =$year."-".$month; 





$erql = mysql_query("SELECT rep_id FROM representative where id='$repid'");
$row=mysql_fetch_array($erql);
$reid=$row['rep_id'];






$strSQL = "SELECT tbl_work_plan.jointworkby,tbl_work_plan.wp_date,tbl_work_plan.reporteddate,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doctor_addrs,doctors.favourite,IFNULL((select area_name from pincode_list where pincode=doctors.doc_pincode order by id asc limit 1),'No area name') as area_name, doctors.id as doc FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_date LIKE '$date%' AND tbl_work_plan.wp_rep_id='$repid'  AND doctors.id=tbl_work_plan.wp_dc_id order by tbl_work_plan.wp_date asc";

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

		$SQL2newfav=mysql_query("SELECT sum(tbl_work_plan.pobvalue) AS pobvaluefav from doctors,tbl_work_plan WHERE id IN (".$obResult['doc'].") AND doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.pobvalue!='0' AND doctors.favourite='1'");

		$num_rows2newfav=mysql_fetch_array($SQL2newfav);

		$SQL2newfav1=mysql_query("SELECT sum(tbl_work_plan.pobvalue) AS pobvalue from doctors,tbl_work_plan WHERE doctors.id IN (".$obResult['doc'].") AND tbl_work_plan.pobvalue!='0' AND doctors.favourite='0' AND doctors.id=tbl_work_plan.wp_dc_id");

		$num_rows2newfav1=mysql_fetch_array($SQL2newfav1);

		$pobvaluefavnew =$num_rows2newfav['pobvaluefav'];
		$pobvaluenew = $num_rows2newfav1['pobvalue'];
		if($pobvaluenew=='')
		{
			$arrCol["pob"]=0;
		}
		else
		{
			$arrCol["pob"]=$pobvaluenew;
		}
		if($pobvaluefavnew=='')
		{
			$arrCol["pobfav"]=0;
		}
		else
		{
			$arrCol["pobfav"]=$pobvaluefavnew;

		}
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);

?>