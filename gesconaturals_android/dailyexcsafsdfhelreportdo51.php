<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];

// // echo "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.c_time,doctors.doctor_addrs,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,stockistid,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name,GROUP_CONCAT(select productid from pobbooking group by pobbooking.client_id) as Name FROM doctors,tbl_work_plan,pobbooking where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.wp_dc_id=pobbooking.client_id and pobbooking.cdate='$date'";exit();



// $strSQL = "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,doctors.doctor_addrs,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,tbl_work_plan.wp_dc_id,stockistid,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors,tbl_work_plan,pobbooking where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id AND tbl_work_plan.wp_dc_id=pobbooking.client_id and pobbooking.cdate='$date' GROUP BY pobbooking.client_id";



// $objQuery = mysql_query($strSQL);
// $intNumField = mysql_num_fields($objQuery);
// $resultArray = array();
// while($obResult = mysql_fetch_array($objQuery))
// {
// 	$arrCol = array();
// 	for($i=0;$i<$intNumField;$i++)
// 	{
// 		$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
// 	}
// // echo "select GROUP_CONCAT(productid) AS pdtid from pobbooking where client_id='".$obResult['wp_dc_id']."' ";
// 	$sql = mysql_query("select GROUP_CONCAT(product.pro_name) AS pdtname,GROUP_CONCAT(pobbooking.qty) AS pdtqty,sum(pobbooking.qty) AS totqty,GROUP_CONCAT(product.ptr) AS pdtmrp,GROUP_CONCAT((product.ptr*pobbooking.qty)) AS pdttotmrp,sum(product.ptr*pobbooking.qty) AS pdtsummrp from pobbooking,product where pobbooking.productid=product.id AND pobbooking.client_id='".$obResult['wp_dc_id']."' AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'");
// 	$row=mysql_fetch_array($sql);

// 	$arrCol['pdtname'] = $row['pdtname'];
// 	$arrCol['pdtqty'] = $row['pdtqty'];
// 	$arrCol['totqty'] = $row['totqty'];
// 	$arrCol['pdtmrp'] = $row['pdtmrp'];
// 	$arrCol['pdttotmrp'] = $row['pdttotmrp'];
// 	$arrCol['pdtsummrp'] = $row['pdtsummrp'];


// 	array_push($resultArray,$arrCol);
// }

// mysql_close($con);



// echo json_encode($resultArray);

// echo "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,doctors.doctor_addrs,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,tbl_work_plan.wp_dc_id,stockistid,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name,pobbooking.pob_id,pobbooking.cdate,doctors.stockist_id,doctors.beatid,tbl_work_plan.wp_rep_id FROM doctors,tbl_work_plan,pobbooking where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id    GROUP BY pobbooking.pob_id";

$strSQL = "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reportedtime,doctors.doctor_addrs,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,tbl_work_plan.wp_dc_id,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name,doctors.stockist_id,doctors.beatid,tbl_work_plan.wp_rep_id FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.wp_rep_id='$rep_id' AND doctors.id=tbl_work_plan.wp_dc_id  ";



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
// echo "select GROUP_CONCAT(productid) AS pdtid from pobbooking where client_id='".$obResult['wp_dc_id']."' ";
	// echo "select product.pro_name AS pdtname,pobbooking.qty AS pdtqty,pobbooking.qty AS totqty,product.ptr AS pdtmrp,(product.ptr*pobbooking.qty) AS pdttotmrp,sum(product.ptr*pobbooking.qty) AS pdtsummrp from pobbooking,product where pobbooking.productid=product.id AND pobbooking.id='".$obResult['pob_id']."' AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'";
	// echo "select product.pro_name AS pdtname,pobbooking.qty AS pdtqty from pobbooking,product where pobbooking.productid=product.id AND pobbooking.pob_id='".$obResult['pob_id']."' AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'";
	// echo "select product.pro_name AS pdtname,IFNULL(pobbooking.qty,'null') AS pdtqty,product.ptr AS pdtmrp,(product.ptr*pobbooking.qty) AS pdttotmrp from pobbooking,product where pobbooking.productid=product.id AND pobbooking.client_id='".$obResult['wp_dc_id']."' AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id' GROUP BY pob_id";
	$sql = mysql_query("select product.pro_name AS pdtname,IFNULL(pobbooking.qty,'null') AS pdtqty,product.ptr AS pdtmrp,(product.ptr*pobbooking.qty) AS pdttotmrp from pobbooking,product where pobbooking.productid=product.id AND pobbooking.client_id='".$obResult['wp_dc_id']."' AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id' GROUP BY pob_id");
	// $row=mysql_fetch_array($sql);

	$sql1 = mysql_query("select doctor_name from doctors1 where id='".$obResult['stockist_id']."'");
	$row1=mysql_fetch_array($sql1);
	$sql2 = mysql_query("select * from beadname where id='".$obResult['beatid']."'");
	$row2=mysql_fetch_array($sql2);
	$sql12 = mysql_query("select * from representative where id='".$obResult['wp_rep_id']."'");
	$row12=mysql_fetch_array($sql12);

	// echo "select product.pro_name AS pdtname,pobbooking.qty AS pdtqty,product.ptr AS pdtmrp,(product.ptr*pobbooking.qty) AS pdttotmrp from pobbooking,product where pobbooking.productid=product.id  AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'";
	$sql3 = mysql_query("select sum( product.ptr * pobbooking.qty ) AS pdtsummrp from pobbooking,product where pobbooking.productid=product.id  AND pobbooking.`cdate` LIKE '%".$date."%' AND pobbooking.repid='$rep_id'");
	$row3=mysql_fetch_array($sql3);

	// echo mysql_num_rows($sql).'-';
	
	if(mysql_num_rows($sql)!='0')
	{
		while($row=mysql_fetch_array($sql))
		{
			$arrCol['pdtname'] = $row['pdtname'];
			$arrCol['pdtqty'] = $row['pdtqty'];
			$arrCol['totqty'] = "";
			$arrCol['pob_id'] = "";
			$arrCol['cdate'] = "";
			$arrCol['pdtmrp'] = $row['pdtmrp'];
			$arrCol['pdttotmrp'] = round($row['pdttotmrp'],2);

			$arrCol['pdtsummrp'] = round($row3['pdtsummrp'],2);
			if($row['pdtqty']=='0')
			{
				$arrCol['drunavailablereason'] = "No Order";
			}
			else
			{
				$arrCol['drunavailablereason'] = "Order Taken";
			}
			$arrCol['stockistname'] = $row1['doctor_name'];
			$arrCol['beatname'] = $row2['name'];
			$arrCol['repname'] = $row12['rep_name'];
			$arrCol['rephq'] = $row12['rep_pwd'];
			$arrCol['state'] = $row12['statename'];
			$arrCol['district'] = $row12['Districtname'];

			$finaloutputnew.='{"drunavailablereason":"'.$arrCol['drunavailablereason'].'","reportedtime":"'.$arrCol['reportedtime'].'","doctor_addrs":"'.$arrCol['doctor_addrs'].'","doc_contact_no":"'.$arrCol['doc_contact_no'].'","doctor_name":"'.$arrCol['doctor_name'].'","doc_pincode":"'.$arrCol['doc_pincode'].'","reportstatus":"'.$arrCol['reportstatus'].'","attendancestatus":"'.$arrCol['attendancestatus'].'","wp_dc_id":"'.$arrCol['wp_dc_id'].'","area_name":"'.$arrCol['area_name'].'","stockist_id":"'.$arrCol['stockist_id'].'","beatid":"'.$arrCol['beatid'].'","wp_rep_id":"'.$arrCol['wp_rep_id'].'","pdtname":"'.$arrCol['pdtname'].'","pdtqty":"'.$arrCol['pdtqty'].'","totqty":"'.$arrCol['totqty'].'","pdtmrp":"'.$arrCol['pdtmrp'].'","pdttotmrp":"'.$arrCol['pdttotmrp'].'","pdtsummrp":"'.$arrCol['pdtsummrp'].'","stockistname":"'.$row1['doctor_name'].'","beatname":"'.$row2['name'].'","repname":"'.$arrCol['repname'].'","rephq":"'.$arrCol['rephq'].'","state":"'.$arrCol['state'].'","district":"'.$arrCol['district'].'","pob_id":"'.$arrCol['pob_id'].'","cdate":"'.$arrCol['cdate'].'"},';
		}
	}
	else
	{
		$arrCol['pdtname'] = 'No Product';
		$arrCol['pdtqty'] = '0';
		$arrCol['totqty'] = "";
		$arrCol['pdtmrp'] = '0';
		$arrCol['pdttotmrp'] = '0';

		$arrCol['pob_id'] = "";
		$arrCol['cdate'] = "";

		$arrCol['pdtsummrp'] = round($row3['pdtsummrp'],2);
		
		$arrCol['drunavailablereason'] = "No Order";
		$arrCol['stockistname'] = $row1['doctor_name'];
		$arrCol['beatname'] = $row2['name'];
		$arrCol['repname'] = $row12['rep_name'];
		$arrCol['rephq'] = $row12['rep_pwd'];
		$arrCol['state'] = $row12['statename'];
		$arrCol['district'] = $row12['Districtname'];
		$finaloutputnew.='{"drunavailablereason":"'.$arrCol['drunavailablereason'].'","reportedtime":"'.$arrCol['reportedtime'].'","doctor_addrs":"'.$arrCol['doctor_addrs'].'","doc_contact_no":"'.$arrCol['doc_contact_no'].'","doctor_name":"'.$arrCol['doctor_name'].'","doc_pincode":"'.$arrCol['doc_pincode'].'","reportstatus":"'.$arrCol['reportstatus'].'","attendancestatus":"'.$arrCol['attendancestatus'].'","wp_dc_id":"'.$arrCol['wp_dc_id'].'","area_name":"'.$arrCol['area_name'].'","stockist_id":"'.$arrCol['stockist_id'].'","beatid":"'.$arrCol['beatid'].'","wp_rep_id":"'.$arrCol['wp_rep_id'].'","pdtname":"'.$arrCol['pdtname'].'","pdtqty":"'.$arrCol['pdtqty'].'","totqty":"'.$arrCol['totqty'].'","pdtmrp":"'.$arrCol['pdtmrp'].'","pdttotmrp":"'.$arrCol['pdttotmrp'].'","pdtsummrp":"'.$arrCol['pdtsummrp'].'","stockistname":"'.$row1['doctor_name'].'","beatname":"'.$row2['name'].'","repname":"'.$arrCol['repname'].'","rephq":"'.$arrCol['rephq'].'","state":"'.$arrCol['state'].'","district":"'.$arrCol['district'].'","pob_id":"'.$arrCol['pob_id'].'","cdate":"'.$arrCol['cdate'].'"},';
		
	}

	


	array_push($resultArray,$arrCol);
}

$finaloutputnew1= substr($finaloutputnew, 0, -1);

echo "[".$finaloutputnew1."]";

mysql_close($con);



// echo json_encode($resultArray);








?>