<?php
include("include/connect.php");	
	$SQL=mysql_query("SELECT distributor_customer.our_cust_id, distributor_customer.id, areawise_temp.id,areawise_temp.dist_id,areawise_temp.cust_name,areawise_temp.pincode FROM areawise_temp, distributor_customer WHERE areawise_temp.dist_id = '100014' AND areawise_temp.our_cust_id = '' AND  distributor_customer .distributor_id= '100014' AND distributor_customer.id=areawise_temp.dist_cust_id");
	echo mysql_error();
	while($Y=mysql_fetch_object($SQL)){
	echo "UPDATE areawise_temp SET our_cust_id ='".$Y->our_cust_id."' WHERE areawise_temp.dist_id = 100014 AND areawise_temp.our_cust_id = '' AND dist_cust_id = '".$Y->id."'  ";
		echo mysql_query("UPDATE areawise_temp SET our_cust_id ='".$Y->our_cust_id."' WHERE areawise_temp.dist_id = '100014' AND areawise_temp.our_cust_id = '' AND id = '".$Y->id."'  ");
		echo mysql_error();
	}
?>