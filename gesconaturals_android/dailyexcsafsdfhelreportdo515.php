<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];

// echo "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.c_time,doctors.doctor_addrs,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,stockistid,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name,GROUP_CONCAT(select productid from pobbooking group by pobbooking.client_id) as Name FROM doctors,tbl_work_plan,pobbooking where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.wp_dc_id=pobbooking.client_id and pobbooking.cdate='$date'";exit();



$dsr_client=mysql_query("SELECT * FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($date))."' AND attendancestatus='1' AND wp_rep_id='".$rep_id."' GROUP BY wp_dc_id ")or die(mysql_error());
$resultArray = array();
while($dsr_client_row=mysql_fetch_array($dsr_client))
{
	$arrCol = array();
	$dsr_second=mysql_query("SELECT *,COUNT(DISTINCT productid) AS gppdtid FROM pobbooking where repid='".$rep_id."' AND cdate ='".date("Y-m-d",strtotime($date))."' AND client_id='".$dsr_client_row['wp_dc_id']."'")or die(mysql_error());
	$dsr_second_count=mysql_num_rows($dsr_second);
	$dsr_second5=mysql_query("SELECT *,COUNT(DISTINCT productid) AS gppdtid FROM pobbooking where repid='".$rep_id."' AND cdate ='".date("Y-m-d",strtotime($date))."' AND client_id='".$dsr_client_row['wp_dc_id']."'")or die(mysql_error());
		// $dsr_second_count5=mysql_num_rows($dsr_second5);
	$dsr_second_row_new5=mysql_fetch_object($dsr_second5);
		// echo $dsr_second_row_new5->gppdtid;
	if($dsr_second_row_new5->gppdtid!='0')
	{

		// $objQuery = mysql_query($dsr_second);
		$intNumField = mysql_num_fields($objQuery);
		
		while($dsr_second_row = mysql_fetch_array($dsr_second))
		{

			$dsr_second1=mysql_query("SELECT (select name from beadname where beadname.id=doctors.beatid) AS beatname,drorchemist,doc_contact_no,id,doctor_name,doc_pincode,stockist_id,beatid FROM doctors where id='".$dsr_second_row['client_id']."'")or die(mysql_error());
			$dsr_second_row1=mysql_fetch_array($dsr_second1);
			
			$arrCol['doctorname'] = $dsr_second_row1['doctor_name'];
			$arrCol['pdtcount'] = $dsr_second_row['gppdtid'];
			$arrCol['status'] = "booked";
			$dsr_second2=mysql_query("SELECT productid,qty FROM pobbooking where client_id='".$dsr_second_row['client_id']."' AND cdate ='".date("Y-m-d",strtotime($date))."' AND repid='".$rep_id."'  GROUP BY pob_id")or die(mysql_error());
			$rttot1=0;
			$qtytot1=0;
			$sql3 = mysql_query("select sum( product.ptr * pobbooking.qty ) AS pdtsummrp from pobbooking,product where pobbooking.productid=product.id  AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'");
			$row3=mysql_fetch_array($sql3);
			while($dsr_second_row2=mysql_fetch_array($dsr_second2))
			{	

				$dsr_second3=mysql_query("SELECT pro_mrp,ptr,pro_name FROM product where id='".$dsr_second_row2['productid']."'");
				$dsr_second_row3=mysql_fetch_array($dsr_second3);


				$rttot1+=$dsr_second_row2['qty']*$dsr_second_row3['ptr'];
				$qtytot1+=$dsr_second_row2['qty'];

			}

			$sql1 = mysql_query("select doctor_name from doctors1 where id='".$dsr_second_row1['stockist_id']."'");
			$row1=mysql_fetch_array($sql1);
			$sql2 = mysql_query("select * from beadname where id='".$dsr_second_row1['beatid']."'");
			$row2=mysql_fetch_array($sql2);
			$sql12 = mysql_query("select * from representative where id='".$dsr_client_row['wp_rep_id']."'");
			$row12=mysql_fetch_array($sql12);
			$arrCol['totamount'] = $rttot1;
			$arrCol['totqry'] = $qtytot1;
			$arrCol['ostatus'] = "secondary";
			$arrCol['reportedtime'] = $dsr_client_row['reportedtime'];
			$arrCol['cdate'] = $dsr_second_row['cdate'];
			$arrCol['stockistname'] = $row1['doctor_name'];
			$arrCol['beatname'] = $row2['name'];
			$arrCol['repname'] = $row12['rep_name'];
			$arrCol['rephq'] = $row12['rep_pwd'];
			$arrCol['state'] = $row12['statename'];
			$arrCol['district'] = $row12['Districtname'];
			$arrCol['pdtsummrp'] = $row3['pdtsummrp'];

			
		}
	}
	else
	{
		$dsr_second_tbl=mysql_query("SELECT * FROM tbl_work_plan where wp_date='".date("Y-m-d",strtotime($date))."' AND attendancestatus='1' AND wp_rep_id='".$rep_id."' AND  wp_dc_id='".$dsr_client_row['wp_dc_id']."' ")or die(mysql_error());
		while($dsr_second_tbl_row=mysql_fetch_array($dsr_second_tbl))
		{

			$sql3 = mysql_query("select sum( product.ptr * pobbooking.qty ) AS pdtsummrp from pobbooking,product where pobbooking.productid=product.id  AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'");
			$row3=mysql_fetch_array($sql3);
			
			$dsr_second1_tbl=mysql_query("SELECT (select name from beadname where beadname.id=doctors.beatid) AS beatname,drorchemist,doc_contact_no,id,doctor_name,doc_pincode,stockist_id,beatid FROM doctors where id='".$dsr_second_tbl_row['wp_dc_id']."'")or die(mysql_error());
			$dsr_second_tbl_row1=mysql_fetch_array($dsr_second1_tbl);
			$arrCol['doctorname'] = $dsr_second_tbl_row1['doctor_name'];
			$arrCol['pdtcount'] = "0";
			$arrCol['status'] = "NO Order";
			$sql1 = mysql_query("select doctor_name from doctors1 where id='".$dsr_second_row1['stockist_id']."'");
			$row1=mysql_fetch_array($sql1);
			$sql2 = mysql_query("select * from beadname where id='".$dsr_second_row1['beatid']."'");
			$row2=mysql_fetch_array($sql2);
			$sql12 = mysql_query("select * from representative where id='".$dsr_client_row['wp_rep_id']."'");
			$row12=mysql_fetch_array($sql12);

			

			
			$arrCol['totamount'] = "0";
			$arrCol['totqry'] = "0";
			$arrCol['ostatus'] = "secondary";
			// $arrCol['reportedtime'] = $dsr_client_row['reportedtime'];
			$arrCol['reportedtime'] = $dsr_second_tbl_row['reportedtime'];
			$arrCol['cdate'] = "";
			$arrCol['stockistname'] = $row1['doctor_name'];
			$arrCol['beatname'] = $row2['name'];
			$arrCol['repname'] = $row12['rep_name'];
			$arrCol['rephq'] = $row12['rep_pwd'];
			$arrCol['state'] = $row12['statename'];
			$arrCol['district'] = $row12['Districtname'];
			$arrCol['pdtsummrp'] = $row3['pdtsummrp'];

		}
	}
	array_push($resultArray,$arrCol);
}

mysql_close($con);



echo json_encode($resultArray);






?>