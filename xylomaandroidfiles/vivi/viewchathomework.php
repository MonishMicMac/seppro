<?php
include("connectsms.php");

$studid = $_REQUEST['studid'];

$stdid = $_REQUEST['stdid'];
$secid = $_REQUEST['secid'];

$combb=$stdid.', '.$secid.' ';

$acayear = $_REQUEST['date'];



$jjexam = "SELECT bulksms_id,msg,status,bulksms_time  FROM `tbl_bulksms_details` WHERE `section` LIKE '%$combb%' AND bulksms_type='HW' AND bulksms_date='$acayear'";

$objQuery = mysql_query($jjexam);

	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) :


		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) :
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
			$arrCol["Name"]="";
		endfor;

		array_push($resultArray,$arrCol);


		$arrCol = array();
		$subSms = "SELECT msg,status,time,senderid FROM `homeworkchat` WHERE bulksms_id='".$obResult["bulksms_id"]."'";
		$subQuery = mysql_query($subSms);

		while($subObject = mysql_fetch_array($subQuery)) :
			$arrCol["bulksms_id"] = $obResult["bulksms_id"];
			$arrCol["msg"] = $subObject["msg"];
                        $arrCol["status"] = $subObject["status"];
                        $arrCol["bulksms_time"] = $subObject["time"];
                        if($subObject["senderid"]=='0')
                        {
                        	$arrCol["Name"]="Admin";
                        }
                        else
                        {
                        	$chatname = mysql_query("SELECT Name,standard_name,section_name FROM student_profile WHERE stu_id='".$subObject["senderid"]."'")or die(mysql_error());
							$chatname_res = mysql_fetch_array($chatname);
							$arrCol["Name"] = $chatname_res["Name"]."-".$chatname_res["standard_name"]."-".$chatname_res["section_name"];
                        }

			array_push($resultArray,$arrCol);
		endwhile;


	endwhile;
	
	
	
	echo json_encode($resultArray);



?>