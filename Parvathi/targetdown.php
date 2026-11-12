<?php

include("connect1.php");

$pid=$_REQUEST['pid'];

$month=$_REQUEST['month'];
$year=$_REQUEST['year'];


$mye=$year.'-'.$month;



$strSQL = "SELECT id,doc_contact_no,dob,visitpermonth,prescriber,corebrand,doctor_name,email,doc_pincode,doc_qualification,drorchemist,doc_gender,doc_specilist_id,doc_hospital_clinic_name,visitcardclinicphoto,doc_specific,time_specific,dob,anniversary,doc_gender,applyforedit,onetimeallowforrep,c_date,c_time,managerapprovestatus,dob,doctor_addrs,favourite,IFNULL((select targetamount from targetachievemneet where cusid=doctors.id AND month='$month' AND year='$year'),'No target') as area_name FROM doctors WHERE rep_assign='$pid' ORDER BY id DESC";



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

                $sql=mysql_query("SELECT productid,qty FROM pobbooking1 where client_id='".$arrCol['id']."' AND cdate LIKE '%$mye%'");
		$pr=0;
		while($row=mysql_fetch_array($sql))
		{	

 		 $sqlpr=mysql_query("SELECT pro_mrp FROM product where id='".$row['productid']."'");
			$rowpr=mysql_fetch_array($sqlpr);
				

			$rt=$row['qty']*$rowpr['pro_mrp'];

$pr=($pr+$rt);
			
		}
		$arrCol['sum']=$pr;


		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);
?>