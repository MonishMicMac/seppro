<?php
include("connect23.php");
//$strSQL = "SELECT representative.id AS RID,rep_name,COUNT(doctors.id) AS CNT FROM doctors,representative WHERE favourite='1' AND representative.id=doctors.rep_assign  GROUP BY doctors.rep_assign";
 //$strSQL = "SELECT representative.id AS RID,rep_name,SUM(case when favourite = 1 then 1 else 0 end) as CNT ,rep_order FROM doctors,representative WHERE favourite='1' AND representative.id=doctors.rep_assign  GROUP BY doctors.rep_assign";
 $strSQL = "SELECT representative.id AS RID,rep_name,SUM(case when favourite = 1 then 1 else 0 end) as CNT ,rep_order FROM doctors,representative WHERE representative.id=doctors.rep_assign AND representative.rep_order!='0' GROUP BY doctors.rep_assign ORDER BY representative.rep_order";
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
    array_push($resultArray,$arrCol);
  }
  
  mysql_close($con);
  
  echo json_encode($resultArray);
?>