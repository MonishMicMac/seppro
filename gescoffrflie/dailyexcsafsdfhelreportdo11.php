<?php

include("connect1.php"); 

$rep_id=$_REQUEST['rep_id'];
$date=$_REQUEST['date'];

$fromdate=explode("-",$date);


$stdate=$fromdate[0]."-".$fromdate[1]."-"."01";

$errr=$fromdate[2]-1;

if($errr<10)
{
$errr='0'.$errr;
}
else
{
$errr=$errr;

}

$eddate=$fromdate[0]."-".$fromdate[1]."-".$errr;



$sqls=mysql_query("SELECT COUNT(*) AS CNTS FROM doctors,tbl_work_plan where (tbl_work_plan.wp_date BETWEEN '$stdate' AND '$eddate')  AND doctors.drorchemist='DOCTOR' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
$a=mysql_fetch_array($sqls);
$drcaall=$a['CNTS'];

$sqlsw=mysql_query("SELECT COUNT(*) AS CNTSw FROM doctors,tbl_work_plan where (tbl_work_plan.wp_date BETWEEN '$stdate' AND '$eddate')  AND doctors.drorchemist='SHOP' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.attendancestatus='1'")or die(mysql_error());
$aw=mysql_fetch_array($sqlsw);
$chemistcall=$aw['CNTSw'];

$sumofco=($drcaall+$chemistcall);



$sqlswq=mysql_query("SELECT count(*) AS CNTSwq FROM pobbooking1 where (cdate BETWEEN '$stdate' AND '$eddate') AND repid='$rep_id' GROUP BY client_id, cdate")or die(mysql_error());
$chemistcallq=mysql_num_rows($sqlswq);


$tosqlswq=mysql_query("SELECT count(*) AS CNTSwq FROM pobbooking1 where cdate='$date' AND repid='$rep_id' GROUP BY client_id, cdate")or die(mysql_error());
$tochemistcallq=mysql_num_rows($tosqlswq);




$prwwe=0;
 $sqlwwe=mysql_query("SELECT productid,qty FROM pobbooking1 where (cdate BETWEEN '$stdate' AND '$eddate') AND repid='$rep_id'");
		
		while($rowwwe=mysql_fetch_array($sqlwwe))
		{	

 		 $sqlprwwe=mysql_query("SELECT pro_mrp FROM product where id='".$rowwwe['productid']."'");
			$rowprwwe=mysql_fetch_array($sqlprwwe);
				

			$rtwwe=$rowwwe['qty']*$rowprwwe['pro_mrp'];

$prwwe=($prwwe+$rtwwe);
			
		}




$strSQL = "SELECT tbl_work_plan.checkintime,tbl_work_plan.wp_dc_id,tbl_work_plan.drunavailablereason,tbl_work_plan.gift,doctors.dob,doctors.exsnew,doctors.drorchemist,doctors.doctor_addrs,doctors.doc_specilist_id,doctors.doc_contact_no,doctors.doc_qualification,doctors.id,doctors.doc_contact_no,doctors.doctor_name,doctors.doc_pincode,doctors.doc_qualification,doctors.doc_specilist_id,doctors.favourite,tbl_work_plan.wp_id,doctors.doc_hospital_clinic_name,doctors.dr_latitude,doctors.dr_longitude,tbl_work_plan.reportstatus,tbl_work_plan.attendancestatus,IFNULL((select area_name from pincode_list where pincode=doc_pincode order by id asc limit 1),'No area name') as area_name FROM doctors,tbl_work_plan where tbl_work_plan.wp_date='$date' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.wp_rep_id='$rep_id' AND tbl_work_plan.wp_dc_id=doctors.id";




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
		
              

            $sql=mysql_query("SELECT productid,qty FROM pobbooking1 where client_id='".$arrCol['wp_dc_id']."' AND cdate='$date'");
		$pr=0;
		while($row=mysql_fetch_array($sql))
		{	

 		 $sqlpr=mysql_query("SELECT pro_mrp FROM product where id='".$row['productid']."'");
			$rowpr=mysql_fetch_array($sqlpr);
				

			$rt=$row['qty']*$rowpr['pro_mrp'];

$pr=($pr+$rt);
			
		}
		$arrCol['sum']=$pr;
              $arrCol['tdr']=$drcaall;
              $arrCol['tsh']=$chemistcall; 
$arrCol['tdrch']=$sumofco; 
$arrCol['productivecalls']=$chemistcallq; 
$arrCol['toprocall']=$tochemistcallq;

$arrCol['pobto']=$prwwe; 

		
		array_push($resultArray,$arrCol);
	}
	
	mysql_close($con);
	
	
	
	echo json_encode($resultArray);
	
	
	
	
	
	
	
	
	
?>