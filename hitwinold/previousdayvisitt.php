<?php

include("connect.php"); 

 $id=$_REQUEST['id'];
 






$strSQL = "SELECT clinetcreation.typeofcustomer,reorting.id,reorting.sparepartused,reorting.repremarks,reorting.usedsapreparts,reorting.remarks,reorting.repid,reorting.sparepartneeded,reorting.pickups,reorting.reportedtime,reorting.complaints,reorting.amount,reorting.typeofcall,reorting.servicetype,reorting.latt,reorting.longg,reorting.attendance,reorting.reporteddate,reorting.scheduledtime,clinetcreation.name,clinetcreation.mobileno,clinetcreation.address,clinetcreation.landmark,clinetcreation.companyname,clinetcreation.address,clinetcreation.pincode,clinetcreation.latts,clinetcreation.longgs,clinetcreation.type,reorting.productrequested,reorting.repreportedpro,reorting.reprepamount,reorting.billno,reorting.repservice FROM reorting,clinetcreation WHERE reorting.clientid='$id' AND reorting.clientid=clinetcreation.id ORDER BY reorting.reporteddate DESC";

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


$sqlss=mysql_query("SELECT GROUP_CONCAT(rep_name) as rep_name FROM representative WHERE id IN (".$arrCol['repid'].")");
		$rowss=mysql_fetch_array($sqlss);
		$arrCol['nameofrep']=$rowss['rep_name'];



                    $arrCol['repnames'] = $repname." - ".$num_rowss;
		array_push($resultArray,$arrCol);
	}

echo json_encode($resultArray);
	

	


?>