<?php

include("connect23.php"); 
$pid=$_REQUEST['pid'];
$favourite=$_REQUEST['favourite'];




$strSQLs = "SELECT representative.id,representative.rep_name,representative.rep_order FROM representative,assigningreptomanager WHERE assigningreptomanager.managerid='$pid' AND representative.rep_order!='0' AND representative.id=assigningreptomanager.repid ORDER BY representative.rep_order ASC";

$objQuerys = mysql_query($strSQLs);
	$intNumField = mysql_num_fields($objQuerys);
	$resultArray = array();
	while($obResult = mysql_fetch_array($objQuerys))
	{
		$arrCol = array();
		for($i=0;$i<$intNumField;$i++)
		{
			$arrCol[mysql_field_name($objQuerys,$i)] = $obResult[$i];
		}


          $strSQL = "SELECT sum(case when mtp =1 then 1 else 0 end) as mtptot,sum(case when mtp =1 and drunavailable=0 and attendancestatus=1 then 1 else 0 end) as attmtp FROM tbl_work_plan WHERE wp_rep_id='".$obResult['id']."' and wp_date = '".$_REQUEST['date']."'  ";
          
          //echo "SELECT sum(case when mtp =1 then 1 else 0 end) as mtptot,sum(case when mtp =1 and drunavailable=0 and attendancestatus=1 then 1 else 0 end) as attmtp FROM tbl_work_plan WHERE wp_rep_id='".$obResult['id']."' and wp_date = '".$_REQUEST['date']."'  ";
          
          
	    $objQuery = mysql_query($strSQL);
	    $obResult = mysql_fetch_array($objQuery);
	
		$attmtp=$obResult['attmtp'];
		$mtptot= $obResult['mtptot'];
        //echo "fds".$attmtp.$mtptot; exit();
        
		$total = round(($attmtp/$mtptot)*100);

       $arrCol['percentage'] = $total;

		array_push($resultArray,$arrCol);
        //
	}
	
	mysql_close($con);
	
	echo json_encode($resultArray);


 
	
	

?>