<?php

include("connect2.php"); 




$strSQL = "SELECT id,replace(replace(pro_name,'\\n',''),'\\r','') as pro_name,pro_mrp FROM product";
$objQuery = $je->prepare($strSQL);
	
	
	$objQuery ->execute();


$antony= $objQuery ->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($antony);



?>