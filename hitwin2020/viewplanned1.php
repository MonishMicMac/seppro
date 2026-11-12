<?php
include("connect.php"); 

$pid=$_REQUEST['pid'];
$date=$_REQUEST['date'];


$status=$_REQUEST['status'];

if($status=='1')
{
    
    
    $strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='1' and  reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

	$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {    
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		$sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		$arrCol1='';
		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);;
		}

		$arrCol['pro_name']=$arrCol1;


		$sqls2=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		$arrCol12='';
		while($rows2=mysql_fetch_array($sqls2))
		{
			$arrCol12.=$rows2['pro_name'].',';
		}
		if(!$arrcol12='')
		{
			$arrCol12=substr($arrCol12, 0, -1);;
		}

		$arrCol['reppro_name']=$arrCol12;


		
		array_push($resultArray,$arrCol);
	}
	echo json_encode($resultArray);
}
else if($status=='2')

{

	/*echo "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.repremarks,reorting.usedsapreparts,reorting.remarks,clinetcreation.id as clientid,reorting.reportedtime,reorting.sparepartneeded,reorting.pickups,reorting.comingtime,reorting.complaints,reorting.amount,reorting.comingtime,reorting.reporteddate,reorting.scheduleddate,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.landmark,clinetcreation.companyname,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.repid='$pid' AND reorting.attendance='1' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";exit();*/

	/*$strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.repremarks,reorting.usedsapreparts,reorting.remarks,clinetcreation.id as clientid,reorting.reportedtime,reorting.sparepartneeded,reorting.pickups,reorting.comingtime,reorting.complaints,reorting.amount,reorting.comingtime,reorting.reporteddate,reorting.scheduleddate,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.landmark,clinetcreation.companyname,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5')  AND reorting.attendance='1' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";*/
    
    $strSQL = "SELECT client_enquiry.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,client_enquiry.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,client_enquiry.name,client_enquiry.mobileno,CONCAT(client_enquiry.`address`,' ',client_enquiry.`Addrtess_line1`,' ',client_enquiry.`Addrtess_line2`) as address,client_enquiry.landmark,client_enquiry.companyname,client_enquiry.pincode,client_enquiry.latts,client_enquiry.longgs,client_enquiry.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,client_enquiry WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='2' and  reorting.clientid=client_enquiry.id ORDER BY reorting.reportedtime DESC";
    
    $strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='1' and  reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

	$objQuery = mysql_query($strSQL);


	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) { 
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		$sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		$arrCol1='';
		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);;
		}

		$arrCol['pro_name']=$arrCol1;



		$sqls2=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['repreportedpro'].") ORDER BY FIELD( id, ".$arrCol['repreportedpro']." ) ");
		$arrCol12='';
		while($rows2=mysql_fetch_array($sqls2))
		{
			$arrCol12.=$rows2['pro_name'].',';
		}
		if(!$arrcol12='')
		{
			$arrCol12=substr($arrCol12, 0, -1);;
		}

		$arrCol['reppro_name']=$arrCol12;
		
		array_push($resultArray,$arrCol);
	}
	
	echo json_encode($resultArray);







}
else if($status=='3')
{


	/*$strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,clinetcreation.id as clientid,reorting.remarks,reorting.comingtime,reorting.sparepartneeded,reorting.pickups,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.scheduleddate,reorting.reportedtime,reorting.reporteddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5')  AND reorting.attendance='0' AND reorting.tdate='$date' AND reorting.clientid=clinetcreation.id ORDER BY reorting.scheduledtime DESC";
    */ 
    
    $strSQLtype = mysql_query("select * from reorting where repid='$pid' and tdate='$date'");
    $resultArray=array();
    $intNumField = mysql_num_fields($strSQLtype);
    while($obType = mysql_fetch_array($strSQLtype)) {
    $arrCol = array();
    if($obType['client_type']=='2')
    {
       $strSQL = mysql_query("SELECT client_enquiry.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,client_enquiry.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.amount,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,client_enquiry.name,client_enquiry.mobileno,CONCAT(client_enquiry.`address`,' ',client_enquiry.`Addrtess_line1`,' ',client_enquiry.`Addrtess_line2`) as address,client_enquiry.landmark,client_enquiry.companyname,client_enquiry.pincode,client_enquiry.latts,client_enquiry.longgs,client_enquiry.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,client_enquiry WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='2' and  reorting.clientid=client_enquiry.id ORDER BY reorting.reportedtime DESC");
       
       //$strSQL = mysql_query("SELECT * from client_enquiry where id='".$obType['clientid']."'");
       $obResult = mysql_fetch_array($strSQL);
       
       
       
       $arrCol['id']=$obResult['id'];
       $arrCol['typeofcustomer']=$obResult['typeofcustomer'];
       $arrCol['sparepartused']=$obResult['sparepartused'];
       $arrCol['remarks']=$obResult['remarks'];
       $arrCol['clientid']=$obResult['clientid'];
       $arrCol['sparepartneeded']=$obResult['sparepartneeded'];
       $arrCol['pickups']=$obResult['pickups'];
       $arrCol['typeofcall']=$obResult['typeofcall'];
       $arrCol['complaints']=$obResult['complaints'];
       $arrCol['comingtime']=$obResult['comingtime'];
       $arrCol['amount']=$obResult['amount'];
       $arrCol['reporteddate']=$obResult['reporteddate'];
       $arrCol['scheduleddate']=$obResult['scheduleddate'];
       $arrCol['servicetype']=$obResult['servicetype'];
       $arrCol['latt']=$obResult['latt'];
       $arrCol['longg']=$obResult['longg'];
       $arrCol['attendance']=$obResult['attendance'];
       $arrCol['scheduledtime']=$obResult['scheduledtime'];
       $arrCol['name']=$obResult['name'];
       $arrCol['longg']=$obResult['longg'];
       $arrCol['rentalfromdate']=$obResult['rentalfromdate'];
       $arrCol['landmark']=$obResult['landmark'];
       $arrCol['productrequested']=$obResult['productrequested'];
       $arrCol['latts']=$obResult['latts'];
       $arrCol['longgs']=$obResult['longgs']; 
       $arrCol['companyname']=$obResult['companyname'];
       $arrCol['pincode']=$obResult['pincode'];
       $arrCol['address']=$obResult['address'];
       $arrCol['type']=$obResult['type'];
       $arrCol['mobileno']=$obResult['mobileno'];
       $arrCol['reppro_name']=$obResult['companyname'];
       $arrCol['pro_name']=$obResult['companyname'];
       $arrCol['rentaltodate']=$obResult['rentaltodate'];
       
       
       /*
       for($i=0;$i<$intNumField;$i++) {
        
			$arrCol[mysql_field_name($strSQLtype,$i)] = $obResult[$i];
		}

        $arrCol['companyname']=$arrCol['companyname'];
        $arrCol['pincode']=$arrCol['pincode'];
        $arrCol['address']=$arrCol['address'];
        $arrCol['address']=$arrCol['address'];
        
		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		$sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		$arrCol1='';
		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);;
		}
        */
            
    }
    
    else if($obType['client_type']=='1')
    {
       $strSQL = mysql_query("SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='1' and reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC");
       
       $obResult = mysql_fetch_array($strSQL);
       
       //echo $intNumField;
       //echo "<pre>";
       //print_r($obResult);
       //exit();
       
         
       //$obResult = mysql_fetch_array($strSQL);
       $arrCol['id']=$obResult['id'];
       $arrCol['typeofcustomer']=$obResult['typeofcustomer'];
       $arrCol['sparepartused']=$obResult['sparepartused'];
       $arrCol['remarks']=$obResult['remarks'];
       $arrCol['clientid']=$obResult['clientid'];
       $arrCol['sparepartneeded']=$obResult['sparepartneeded'];
       $arrCol['pickups']=$obResult['pickups'];
       $arrCol['typeofcall']=$obResult['typeofcall'];
       $arrCol['complaints']=$obResult['complaints'];
       $arrCol['comingtime']=$obResult['comingtime'];
       $arrCol['amount']=$obResult['amount'];
       $arrCol['reporteddate']=$obResult['reporteddate'];
       $arrCol['scheduleddate']=$obResult['scheduleddate'];
       $arrCol['servicetype']=$obResult['servicetype'];
       $arrCol['latt']=$obResult['latt'];
       $arrCol['longg']=$obResult['longg'];
       $arrCol['attendance']=$obResult['attendance'];
       $arrCol['scheduledtime']=$obResult['scheduledtime'];
       $arrCol['name']=$obResult['name'];
       $arrCol['longg']=$obResult['longg'];
       $arrCol['rentalfromdate']=$obResult['rentalfromdate'];
       $arrCol['landmark']=$obResult['landmark'];
       $arrCol['productrequested']=$obResult['productrequested'];
       $arrCol['latts']=$obResult['latts'];
       $arrCol['longgs']=$obResult['longgs']; 
       $arrCol['companyname']=$obResult['companyname'];
       $arrCol['pincode']=$obResult['pincode'];
       $arrCol['address']=$obResult['address'];
       $arrCol['type']=$obResult['type'];
       $arrCol['mobileno']=$obResult['mobileno'];
       $arrCol['reppro_name']=$obResult['companyname'];
       $arrCol['pro_name']=$obResult['companyname'];
       $arrCol['rentaltodate']=$obResult['rentaltodate'];
       /*
       for($i=0;$i<$intNumField;$i++) {
			$arrCol[mysql_field_name($strSQLtype,$i)] = $obResult[$i];
		}

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		$sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		$arrCol1='';
		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);;
		}
        */
            
    }
    
    array_push($resultArray,$arrCol);
    
    
    }
    
    echo json_encode($resultArray);
    
    /*
    
    echo $obType['client_type'];
     
    if($obType['client_type']=='2')
    {
    $strSQL = "SELECT client_enquiry.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,client_enquiry.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,client_enquiry.name,client_enquiry.mobileno,CONCAT(client_enquiry.`address`,' ',client_enquiry.`Addrtess_line1`,' ',client_enquiry.`Addrtess_line2`) as address,client_enquiry.landmark,client_enquiry.companyname,client_enquiry.pincode,client_enquiry.latts,client_enquiry.longgs,client_enquiry.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,client_enquiry WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='2' and  reorting.clientid=client_enquiry.id ORDER BY reorting.reportedtime DESC";
    }
    else if($obType['client_type']=='1')
    {
    $strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='1' and reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";
    }
    //echo "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.remarks,clinetcreation.id as clientid,reorting.sparepartneeded,reorting.pickups,reorting.typeofcall,reorting.complaints,reorting.comingtime,reorting.amount,reorting.reportedtime,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,CONCAT(clinetcreation.`address`,' ',clinetcreation.`Addrtess_line1`,' ',clinetcreation.`Addrtess_line2`) as address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.rentalfromdate,reorting.rentaltodate FROM reorting,clinetcreation WHERE (reorting.repid='$pid' or reorting.not_assign_schedulle='5') AND reorting.tdate='$date' AND reorting.client_type='1' and  reorting.clientid=clinetcreation.id ORDER BY reorting.reportedtime DESC";

	$objQuery = mysql_query($strSQL);
     
	$intNumField = mysql_num_fields($objQuery);

	$resultArray = array();
    
    //$obResult = mysql_fetch_array($objQuery);
    //echo "<pre>";
    //print_r($obResult);
    
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}

		$arrCol['rental_date']=$arrCol['rentalfromdate'].' - '.$arrCol['rentaltodate'];

		$sqls=mysql_query("SELECT pro_name FROM product WHERE id IN (".$arrCol['productrequested'].") ORDER BY FIELD( id, ".$arrCol['productrequested']." ) ");
		$arrCol1='';
		while($rows=mysql_fetch_array($sqls))
		{
			$arrCol1.=$rows['pro_name'].',';
		}
		if(!$arrcol1='')
		{
			$arrCol1=substr($arrCol1, 0, -1);;
		}

		$arrCol['pro_name']=$arrCol1;
		array_push($resultArray,$arrCol);
	}


}	*/

	
//    unset($resultArray);


}





?>