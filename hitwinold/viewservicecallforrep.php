<?php
include("connect.php"); 

$date=$_REQUEST['date'];


$type=$_REQUEST['type'];












$strSQL = "SELECT reorting.id,reorting.amount,reorting.complaints,clinetcreation.id as clientid,reorting.typeofcall,reorting.reporteddate,reorting.scheduleddate,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.companyname,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested FROM reorting,clinetcreation WHERE reorting.repid='0' AND reorting.tdate='$date' AND typeofcall='$type' AND reorting.clientid=clinetcreation.id";

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