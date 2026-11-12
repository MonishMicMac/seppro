<?php
include("connect23.php");  

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'].'-';
$status1=$_REQUEST['status'];
$docstatus=$_REQUEST['docstatus'];
$manager=$_REQUEST['manager'];
// echo "SELECT * FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%'  ";
// $resultArray = array();
	// $resultArray = array();
// $arrCol = array();

$strSQL10 = "SELECT count(*) AS favdoc FROM `doctors` WHERE `rep_id` IN (SELECT `repid` FROM `assigningreptomanager` WHERE `managerid`='$manager') AND `favourite`='1' ";
$objQuery10 = mysql_query($strSQL10);	
	$obResult10 = mysql_fetch_array($objQuery10);
	  $count10=$obResult10['favdoc'];

$strSQL11 = "SELECT GROUP_CONCAT(id) AS docid FROM `doctors` WHERE `rep_id` IN (SELECT `repid` FROM `assigningreptomanager` WHERE `managerid`='$manager') AND `favourite`='1' ";
$objQuery11 = mysql_query($strSQL11);	
	$obResult11 = mysql_fetch_array($objQuery11);
	 $count11=$obResult11['docid'];


$strSQL1 = "SELECT Count(Distinct `wp_dc_id`) AS docter FROM tbl_work_plan WHERE wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN ($count11) ";
$objQuery1 = mysql_query($strSQL1);	
	$obResult1 = mysql_fetch_array($objQuery1);
	 $count1=$obResult1['docter'];	
	 
	// $arrCol["doctors"] = $count1;

$unvisitdc=$count10-$count1;
	

$strSQL7 = "SELECT GROUP_CONCAT(DISTINCT `wp_dc_id`) AS docter5 FROM tbl_work_plan WHERE wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' AND wp_dc_id IN ($count11)  ";
$objQuery7 = mysql_query($strSQL7);	
	$obResult7 = mysql_fetch_array($objQuery7);
	  $count7=$obResult7['docter5'];



// echo "SELECT Count(`wp_dc_id`) AS onevisit,wp_dc_id FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' group by wp_dc_id HAVING onevisit=1";



if($status1==1)
{
$strSQL6 = "SELECT id,doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE `rep_id` IN (SELECT `repid` FROM `assigningreptomanager` WHERE `managerid`='$manager') AND `favourite`='1'   ";
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
			// $strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',jointworkby,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_rep_id='$rep_id'  AND wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			// $objQueryj = mysql_query($strSQLj);
			// $intNumFieldj= mysql_fetch_array($objQueryj);

			// $arrCol["docdate"]=$intNumFieldj["dat"];
			// $arrCol["joint"]=$intNumFieldj["jon"];
			// $arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["fvdoctor"]=$count10;
			$arrCol["visit"]=$count1;
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}

}
if($status1==2)
{
	
$strSQL6 = "SELECT id,doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE `id` IN ($count7) AND `favourite`='1'   ";
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
			// echo "SELECT GROUP_CONCAT(DAY(wp_date),'(',IFNULL((select rep_name from representative where id=jointworkby order by id asc limit 1),'No Joint Work') ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',IFNULL((select rep_name from representative where id=jointworkby order by id asc limit 1),'NO JOINT WORK')  ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			$objQueryj = mysql_query($strSQLj);
			$intNumFieldj= mysql_fetch_array($objQueryj);
			
			$arrCol["docdate"]=$intNumFieldj["dat"];
			$arrCol["joint"]=$intNumFieldj["jon"];
			$arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["fvdoctor"]=$count10;
			$arrCol["visit"]=$count1;
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}

}
if($status1==3)
{
	// echo "SELECT id,doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE `id` NOT  IN ($count7) AND `favourite`='1' AND  `rep_id` IN (SELECT `repid` FROM `assigningreptomanager` WHERE `managerid`='$manager') ";
$strSQL6 = "SELECT id,doctor_name,favourite,doc_specilist_id,doc_qualification,doctor_addrs,doc_pincode,doc_contact_no FROM doctors WHERE `id` NOT IN ($count7) AND `favourite`='1' AND  `rep_id` IN (SELECT `repid` FROM `assigningreptomanager` WHERE `managerid`='$manager') ";
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
			// echo "SELECT GROUP_CONCAT(DAY(wp_date),'(',IFNULL((select rep_name from representative where id=jointworkby order by id asc limit 1),'No Joint Work') ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			// $strSQLj = "SELECT GROUP_CONCAT(DAY(wp_date),'(',IFNULL((select rep_name from representative where id=jointworkby order by id asc limit 1),'NO JOINT WORK')  ,')') AS dat,GROUP_CONCAT(DAY(wp_date)) AS ondat,GROUP_CONCAT(jointworkby) AS jon FROM tbl_work_plan WHERE wp_date like '%".$date."%' AND attendancestatus='1' AND wp_dc='D' AND drunavailable='0' and wp_dc_id='".$obResult6["id"]."'";
			// $objQueryj = mysql_query($strSQLj);
			// $intNumFieldj= mysql_fetch_array($objQueryj);
			
			// $arrCol["docdate"]=$intNumFieldj["dat"];
			// $arrCol["joint"]=$intNumFieldj["jon"];
			// $arrCol["ondate"]=$intNumFieldj["ondat"];

			$arrCol["fvdoctor"]=$count10;
			$arrCol["visit"]=$count1;
			$arrCol["unvisit"]=$unvisitdc;
			$arrCol["status"]=$status1;
		
		array_push($resultArray,$arrCol);
	}

}



	// echo '[{"unvisitdoctors":"'.$unvisitdc.'","report":"'.$count.'","doctors":"'.$count1.'","onevisit":"'.$obResult2.'","twovisit":"'.$obResult3.'","threevisit":"'.$obResult4.'","status":"'.$status1.'"}]';
	// array_push($resultArray,$arrCol);
	
	mysql_close($con);
	
	
	echo json_encode($resultArray);
	
	
	
	
	
	
	
	
	
?>