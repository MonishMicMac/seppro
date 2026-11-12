<?php

include("connect2.php"); 

$pid=$_REQUEST['pid'];



date_default_timezone_set("Asia/Kolkata"); 

$cdate = date('Y-m-d');


$strSQL = "select doctors.id,doctors.doctor_name,doctors.doc_specilist_id,doctors.doc_contact_no,doctors.doctor_addrs,doctors.doc_pincode,doctors.rep_id,sampletimeinandout.intime,sampletimeinandout.outtime,sampletimeinandout.feedback,sampletimeinandout.outfeedback,sampletimeinandout.timediff,sampletimeinandout.c_date FROM doctors,sampletimeinandout WHERE sampletimeinandout.clientid='$pid' and outfeedback!='' and feedback!=''AND doctors.id=sampletimeinandout.clientid ORDER BY doctors.id DESC LIMIT 15 ";



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

		$sqls=mysql_query("SELECT timediff FROM sampletimeinandout WHERE sampletimeinandout.clientid='$pid' and outfeedback!='' and feedback!='' ")or die(mysql_error());

            $sum = strtotime('00:00:00'); $sum2=0;
              while($rows=mysql_fetch_array($sqls))
               {
			$sum1=strtotime($rows['timediff'])-$sum;
			$sum2 = $sum2+$sum1;
           	}
          $sum3=$sum+$sum2;  $td= date("H:i:s",$sum3);

        $arrCol['sumtime']=$td;


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>