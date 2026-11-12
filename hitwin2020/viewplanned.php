<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];
$date=$_REQUEST['date'];


$status=$_REQUEST['status'];

if($status=='1')
{


	$strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate,reorting.auto_fare,reorting.collected_auto_fare,reorting.collected_amount,reorting.rental_advance_amt,reorting.rental_advance_amt_received,reorting.rental_deposit_amt,reorting.rental_deposit_amt_received,reorting.accessories,reorting.paymenttype,reorting.paymentmode,reorting.tracking_id   FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

	$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {    
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
		//$sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];
		
		$tracking_id = $arrCol['tracking_id'];
		if(strpos($tracking_id, 'HSAL') !== false){
			$call_type = 'Sales';
		  }else if(strpos($tracking_id, 'HREN') !== false){
			$call_type = 'Rental';
		  }else if(strpos($tracking_id, 'HSER') !== false ){
			$call_type = 'Service';
		  }else {
			$call_type = '';
		  }

		if($call_type == 'Sales' || $call_type == 'Service'){
			$sqls=mysql_query("SELECT pro_name FROM product WHERE pro_id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		}else{
			$sqls=mysql_query("SELECT pro_name FROM product_rental WHERE pro_id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		}
		


		$arrCol1='';
		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);
		}

		$arrCol['pro_name']=$arrCol1;





		// $sqls2=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");

		if($call_type == 'Sales' || $call_type == 'Service'){
			$sqls2=mysql_query("SELECT pro_name FROM product WHERE pro_id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		}else{
			$sqls2=mysql_query("SELECT pro_name FROM product_rental WHERE pro_id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		}

		
		$arrCol12='';
		while($rows2=mysql_fetch_array($sqls2))
		{
			$arrCol12.=$rows2['pro_name'].',';
		}
		if(!$arrcol12='')
		{
			$arrCol12=substr($arrCol12, 0, -1);
		}

		$arrCol['reppro_name']=$arrCol12;


		
		array_push($resultArray,$arrCol);
	}
	echo json_encode($resultArray);
}
else if($status=='2')

{

	/*echo "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.repremarks,reorting.usedsapreparts,reorting.remarks,clinetcreation.id as clientid,reorting.reportedtime,reorting.sparepartneeded,reorting.pickups,reorting.comingtime,reorting.complaints,reorting.amount,reorting.comingtime,reorting.reporteddate,reorting.scheduleddate,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.landmark,clinetcreation.companyname,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.attendance='1' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";exit();*/

	$strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.repremarks,reorting.usedsapreparts,reorting.remarks,clinetcreation.id as clientid,reorting.reportedtime,reorting.sparepartneeded,reorting.pickups,reorting.comingtime,reorting.complaints,reorting.amount,reorting.comingtime,reorting.reporteddate,reorting.scheduleddate,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.landmark,clinetcreation.companyname,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice,reorting.rentalfromdate,reorting.rentaltodate,reorting.auto_fare,reorting.collected_auto_fare,reorting.collected_amount,reorting.rental_advance_amt,reorting.rental_advance_amt_received,reorting.rental_deposit_amt,reorting.rental_deposit_amt_received,reorting.accessories,reorting.paymenttype,reorting.paymentmode,reorting.tracking_id FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5')  AND reorting.attendance='1' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

	$objQuery = mysql_query($strSQL);


	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) { 
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		// $sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];
		
		$tracking_id = $arrCol['tracking_id'];
		if(strpos($tracking_id, 'HSAL') !== false){
			$call_type = 'Sales';
		}else if(strpos($tracking_id, 'HREN') !== false){
		$call_type = 'Rental';
		}else if(strpos($tracking_id, 'HSER') !== false ){
		$call_type = 'Service';
		}else {
		$call_type = '';
		}

		if($call_type == 'Sales' || $call_type == 'Service'){
			$sqls=mysql_query("SELECT pro_name FROM product WHERE pro_id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		}else{
			$sqls=mysql_query("SELECT pro_name FROM product_rental WHERE pro_id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		}


		$arrCol1='';

		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);
		}

		$arrCol['pro_name']=$arrCol1;





		// $sqls2=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		if($call_type == 'Sales' || $call_type == 'Service'){
			$sqls2=mysql_query("SELECT pro_name FROM product WHERE pro_id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		}else{
			$sqls2=mysql_query("SELECT pro_name FROM product_rental WHERE pro_id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		}
		$arrCol12='';
		while($rows2=mysql_fetch_array($sqls2))
		{
			$arrCol12.=$rows2['pro_name'].',';
		}
		if(!$arrcol12='')
		{
			$arrCol12=substr($arrCol12, 0, -1);
		}

		$arrCol['reppro_name']=$arrCol12;
		
		array_push($resultArray,$arrCol);
	}
	
	echo json_encode($resultArray);







}
else if($status=='3')
{


	// $strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,clinetcreation.id as clientid,reorting.remarks,reorting.comingtime,reorting.sparepartneeded,reorting.pickups,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.scheduleddate,reorting.reportedtime,reorting.reporteddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.call_stage,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate,reorting.auto_fare,reorting.collected_auto_fare,reorting.collected_amount,reorting.rental_advance_amt,reorting.rental_advance_amt_received,reorting.rental_deposit_amt,reorting.rental_deposit_amt_received,reorting.accessories,reorting.paymenttype,reorting.paymentmode,reorting.tracking_id FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5')  AND reorting.attendance='0' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.scheduledtime DESC";

	$strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,clinetcreation.id as clientid,reorting.remarks,reorting.comingtime,reorting.sparepartneeded,reorting.pickups,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.scheduleddate,reorting.reportedtime,reorting.reporteddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.call_stage,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate,reorting.auto_fare,reorting.collected_auto_fare,reorting.collected_amount,reorting.rental_advance_amt,reorting.rental_advance_amt_received,reorting.rental_deposit_amt,reorting.rental_deposit_amt_received,reorting.accessories,reorting.paymenttype,reorting.paymentmode,reorting.tracking_id FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5')  AND reorting.attendance='0' AND reorting.scheduleddate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.scheduledtime DESC";
	

	$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		// $sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");

		$tracking_id = $arrCol['tracking_id'];
		if(strpos($tracking_id, 'HSAL') !== false){
			$call_type = 'Sales';
		  }else if(strpos($tracking_id, 'HREN') !== false){
			$call_type = 'Rental';
		  }else if(strpos($tracking_id, 'HSER') !== false ){
			$call_type = 'Service';
		  }else {
			$call_type = '';
		  }

		if($call_type == 'Sales' || $call_type == 'Service'){
			$sqls=mysql_query("SELECT pro_name FROM product WHERE pro_id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		}else{
			$sqls=mysql_query("SELECT pro_name FROM product_rental WHERE pro_id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		}
		


		$arrCol1='';

		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);
		}

		$arrCol['pro_name']=$arrCol1;
		array_push($resultArray,$arrCol);
	}
	
	echo json_encode($resultArray);


}





?>