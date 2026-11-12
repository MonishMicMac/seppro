<?php
include("connect.php"); 

$date=$_REQUEST['date'];


$repid=$_REQUEST['repid'];

$strSQL = "SELECT reorting.id,reorting.repid,reorting.repservice,reorting.sparepartused,clinetcreation.typeofcustomer,reorting.repremarks,reorting.usedsapreparts,reorting.pickups,reorting.sparepartneeded,reorting.remarks,reorting.typeofcall,reorting.complaints,reorting.amount,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.reportedtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.repid='$repid' AND reorting.tdate LIKE '%$date%' AND reorting.attendance='0' AND reorting.clientid=clinetcreation.id";

$objQuery = mysql_query($strSQL);
	$intNumField = mysql_num_fields($objQuery);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuery)) {
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++) {    
			$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
		}
		
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
	echo json_encode($resultArray);





?>