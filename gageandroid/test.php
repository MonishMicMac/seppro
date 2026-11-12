<?php

include("../includes/connect_db.php");


$strSQL="SELECT 
  a.Subject_name AS subjectname, 
  b.section AS section,
  c.class_name AS class 
     FROM 
        exam_schedule d, 
        subject a, 
        section b,
        classes c
          WHERE 
            d.Subject_id = a.sub_id
            and
            d.Section_id = b.sec_id
			and
			d.Standard_id=c.class_id";


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

