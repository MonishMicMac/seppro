<?php
include("connect23.php");  

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];
$start_date=date("Y-m",strtotime($_REQUEST["date"]))."-01";
$status1=$_REQUEST['status'];
$docstatus=$_REQUEST['docstatus'];

// echo "SELECT * FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%'  ";
// $resultArray = array();
	// $resultArray = array();
// $arrCol = array();

if($docstatus=='1')
{

$strSQL5 = "SELECT count(*) AS unvisit FROM doctors WHERE rep_id='$rep_id'   ";
$objQuery5 = mysql_query($strSQL5);	
	$obResult5 = mysql_fetch_array($objQuery5);
	 $count5=$obResult5['unvisit'];

$strSQL = "SELECT count(*) AS report FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' ";
$objQuery = mysql_query($strSQL);	
	$obResult = mysql_fetch_array($objQuery);
	 $count=$obResult['report'];
	// $arrCol["report")] = $count;

$strSQL1 = "SELECT Count(Distinct `wp_dc_id`) AS docter FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0'  ";
$objQuery1 = mysql_query($strSQL1);	
	$obResult1 = mysql_fetch_array($objQuery1);
	 $count1=$obResult1['docter'];	
	 echo $obResult1['DC'];	
	// $arrCol["doctors"] = $count1;

$unvisitdc=$count5-$count1;
	
$strSQL2 = "SELECT Count(`wp_dc_id`) AS onevisit FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit=1";
$objQuery2 = mysql_query($strSQL2);	
	$obResult2 = mysql_num_rows($objQuery2);	


	// $arrCol["onevisit"] = $obResult2;


$strSQL3 = "SELECT Count(`wp_dc_id`) AS twovisit FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING twovisit=2";
$objQuery3 = mysql_query($strSQL3);	
	$obResult3 = mysql_num_rows($objQuery3);	
	// $arrCol["twovisit"] = $obResult2;

$strSQL4 = "SELECT Count(`wp_dc_id`) AS threevisit FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING threevisit >=3";
$objQuery4 = mysql_query($strSQL4);	
	$obResult4 = mysql_num_rows($objQuery4);	
	// $arrCol["twovisit"] = $obResult4;

$strSQL7 = "SELECT GROUP_CONCAT(DISTINCT `wp_dc_id`) AS docter5 FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0'  ";
$objQuery7 = mysql_query($strSQL7);	
	$obResult7 = mysql_fetch_array($objQuery7);
	 $count7=$obResult7['docter5'];

// echo "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit=1";



if($status1==1)
{
$strSQL6 = "SELECT id,doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE id IN  ($count7) AND rep_id='$rep_id' ORDER BY doctor_name ASC ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{
		
			
			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];
			}
			// echo "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN ''
   //      WHEN '2' THEN 'bpm' END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";

			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN'  END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}

}
elseif($status1==2)
{
$strSQL6 = "SELECT doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE id NOT IN  ($count7) AND rep_id='$rep_id' ORDER BY doctor_name ASC  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];
			}
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==3)
{
	
$strSQL6 = "SELECT doctors.favourite,doctors.doctor_name,doctors.doc_specilist_id,doctors.doctor_addrs,doctors.doc_qualification,doctors.doc_pincode,doctors.doc_contact_no,tbl_work_plan.wp_date,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.drunavailablereason,tbl_work_plan.jointworkby,doctors.dr_latitude,doctors.dr_longitude FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$rep_id'  AND (tbl_work_plan.wp_date BETWEEN '".$start_date."' AND '".$date."') AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.drunavailable='0' and tbl_work_plan.wp_dc_id=doctors.id ORDER BY doctors.doctor_name ASC ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==4)
{
	$strSQL8 = "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit=1";
$objQuery8 = mysql_query($strSQL8);	
	while($obResult8 = mysql_fetch_array($objQuery8))
	{
	  $count8.=$obResult8['wp_dc_id'].',';
	}
	// echo $count8;
	 $opt = substr($count8,0,-1);
$strSQL6 = "SELECT id,doctor_name,doc_specilist_id,favourite,doctor_addrs,doc_qualification,doc_pincode,doc_contact_no FROM doctors WHERE id  IN  ($opt) AND rep_id='$rep_id' ORDER BY doctor_name ASC  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN'  END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==5)
{
	$strSQL8 = "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit=2";
$objQuery8 = mysql_query($strSQL8);	
	while($obResult8 = mysql_fetch_array($objQuery8))
	{
	  $count8.=$obResult8['wp_dc_id'].',';
	}
	// echo $count8;
	 $opt = substr($count8,0,-1);
$strSQL6 = "SELECT id,doctor_name,doc_specilist_id,doctor_addrs,favourite,doc_qualification,doc_pincode,doc_contact_no FROM doctors WHERE id  IN  ($opt) AND rep_id='$rep_id' ORDER BY doctor_name ASC  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN'  END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==6)
{
	$strSQL8 = "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit>=3";
$objQuery8 = mysql_query($strSQL8);	
	while($obResult8 = mysql_fetch_array($objQuery8))
	{
	  $count8.=$obResult8['wp_dc_id'].',';
	}
	// echo $count8;
	 $opt = substr($count8,0,-1);
$strSQL6 = "SELECT id,doctor_name,doc_specilist_id,favourite,doctor_addrs,doc_pincode,doc_qualification,doc_contact_no FROM doctors WHERE id  IN  ($opt) AND rep_id='$rep_id' ORDER BY doctor_name ASC  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN'  END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
}
elseif($docstatus=='2')
{
	$strSQL5 = "SELECT count(*) AS unvisit FROM doctors WHERE rep_id='$rep_id' AND favourite='1'  ";
$objQuery5 = mysql_query($strSQL5);	
	$obResult5 = mysql_fetch_array($objQuery5);
	 $count5=$obResult5['unvisit'];

$strSQL = "SELECT count(*) AS report FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) ";
$objQuery = mysql_query($strSQL);	
	$obResult = mysql_fetch_array($objQuery);
	 $count=$obResult['report'];
	// $arrCol["report")] = $count;

$strSQL1 = "SELECT Count(Distinct `wp_dc_id`) AS docter FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) ";
$objQuery1 = mysql_query($strSQL1);	
	$obResult1 = mysql_fetch_array($objQuery1);
	 $count1=$obResult1['docter'];	
	 echo $obResult1['DC'];	
	// $arrCol["doctors"] = $count1;

$unvisitdc=$count5-$count1;
	
$strSQL2 = "SELECT Count(`wp_dc_id`) AS onevisit FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) group by wp_dc_id HAVING onevisit=1";
$objQuery2 = mysql_query($strSQL2);	
	$obResult2 = mysql_num_rows($objQuery2);	


	// $arrCol["onevisit"] = $obResult2;


$strSQL3 = "SELECT Count(`wp_dc_id`) AS twovisit FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) group by wp_dc_id HAVING twovisit=2";
$objQuery3 = mysql_query($strSQL3);	
	$obResult3 = mysql_num_rows($objQuery3);	
	// $arrCol["twovisit"] = $obResult2;

$strSQL4 = "SELECT Count(`wp_dc_id`) AS threevisit FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) group by wp_dc_id HAVING threevisit >=3";
$objQuery4 = mysql_query($strSQL4);	
	$obResult4 = mysql_num_rows($objQuery4);	
	// $arrCol["twovisit"] = $obResult4;
// echo "SELECT GROUP_CONCAT(DISTINCT `wp_dc_id`) AS docter5 FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND wp_dc_id=(SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) AND drunavailable='0'  ";
$strSQL7 = "SELECT GROUP_CONCAT(DISTINCT `wp_dc_id`) AS docter5 FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) AND drunavailable='0'  ";
$objQuery7 = mysql_query($strSQL7);	
	$obResult7 = mysql_fetch_array($objQuery7);
	 $count7=$obResult7['docter5'];

// echo "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit=1";



if($status1==1)
{
$strSQL6 = "SELECT id,doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE id IN  ($count7) AND rep_id='$rep_id'  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{
		
			
			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];
			}
			
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN' WHEN '2' THEN 'bpm' END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}

}
elseif($status1==2)
{
$strSQL6 = "SELECT doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE id NOT IN  ($count7) AND rep_id='$rep_id'  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];
			}
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==3)
{
	
$strSQL6 = "SELECT doctors.favourite,doctors.doctor_name,doctors.doc_specilist_id,doctors.doctor_addrs,doctors.doc_qualification,doctors.doc_pincode,doctors.doc_contact_no,tbl_work_plan.wp_date,tbl_work_plan.latitude,tbl_work_plan.longitude,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,tbl_work_plan.drunavailablereason,tbl_work_plan.jointworkby,doctors.dr_latitude,doctors.dr_longitude FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$rep_id'  AND (tbl_work_plan.wp_date BETWEEN '".$start_date."' AND '".$date."') AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.drunavailable='0' and doctors.favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==4)
{
	$strSQL8 = "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) AND drunavailable='0'  group by wp_dc_id HAVING onevisit=1";
$objQuery8 = mysql_query($strSQL8);	
	while($obResult8 = mysql_fetch_array($objQuery8))
	{
	  $count8.=$obResult8['wp_dc_id'].',';
	}
	// echo $count8;
	 $opt = substr($count8,0,-1);
$strSQL6 = "SELECT id,doctor_name,doc_specilist_id,favourite,doctor_addrs,doc_qualification,doc_pincode,doc_contact_no FROM doctors WHERE id  IN  ($opt) AND rep_id='$rep_id'  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN' WHEN '2' THEN 'bpm' END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==5)
{
	$strSQL8 = "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) AND drunavailable='0'  group by wp_dc_id HAVING onevisit=2";
$objQuery8 = mysql_query($strSQL8);	
	while($obResult8 = mysql_fetch_array($objQuery8))
	{
	  $count8.=$obResult8['wp_dc_id'].',';
	}
	// echo $count8;
	 $opt = substr($count8,0,-1);
$strSQL6 = "SELECT id,doctor_name,doc_specilist_id,doctor_addrs,favourite,doc_qualification,doc_pincode,doc_contact_no FROM doctors WHERE id  IN  ($opt) AND rep_id='$rep_id'  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN' WHEN '2' THEN 'bpm' END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
elseif($status1==6)
{
	$strSQL8 = "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN (SELECT id FROM  `doctors` WHERE  `favourite` ='1' ) AND drunavailable='0'  group by wp_dc_id HAVING onevisit>=3";
$objQuery8 = mysql_query($strSQL8);	
	while($obResult8 = mysql_fetch_array($objQuery8))
	{
	  $count8.=$obResult8['wp_dc_id'].',';
	}
	// echo $count8;
	 $opt = substr($count8,0,-1);
$strSQL6 = "SELECT id,doctor_name,doc_specilist_id,favourite,doctor_addrs,doc_pincode,doc_qualification,doc_contact_no FROM doctors WHERE id  IN  ($opt) AND rep_id='$rep_id'  ";
$objQuery6 = mysql_query($strSQL6);
$intNumField6 = mysql_num_fields($objQuery6);
	$resultArray = array();

	while($obResult6 = mysql_fetch_array($objQuery6))
	{
		// echo "1";
		$arrCol = array();	
		for($i=0;$i<$intNumField6;$i++)
		{

			$arrCol[mysql_field_name($objQuery6,$i)] = $obResult6[$i];

			}
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',CASE jointworkby WHEN '2' THEN 'BPM' WHEN '13' THEN 'BPM' WHEN '25' THEN 'BPM' WHEN '28' THEN 'BPM' WHEN '39' THEN 'BPM' WHEN '42' THEN 'BPM' WHEN '49' THEN 'RSM' WHEN '7' THEN 'GM' WHEN '26' THEN 'PMT' WHEN '0' THEN 'IN' WHEN '2' THEN 'bpm' END ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND (wp_date BETWEEN '".$start_date."' AND '".$date."') AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["report"]=$count;
			$arrCol["doctors"]=$count1;
			$arrCol["onevisit"]=$obResult2;
			$arrCol["twovisit"]=$obResult3;
			$arrCol["threevisit"]=$obResult4;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}
}
}
	// echo '[{"unvisitdoctors":"'.$unvisitdc.'","report":"'.$count.'","doctors":"'.$count1.'","onevisit":"'.$obResult2.'","twovisit":"'.$obResult3.'","threevisit":"'.$obResult4.'","status":"'.$status1.'"}]';
	// array_push($resultArray,$arrCol);
	
	mysql_close($con);
	
	
	echo json_encode($resultArray);
	
	
	
	
	
	
	
	
	
?>