<?php
	ini_set('memory_limit', '-1');
	ini_set('upload_max_filesize', '1024M');
	ini_set('post_max_size', '1024M');
	ini_set('max_input_time', 30000);
	ini_set('max_execution_time', 150000);
	$conn = mysql_connect("localhost","root","$3pp60@2016");
	mysql_select_db("systopic");
	$SQL = mysql_query("SELECT shop_name,pincode,id FROM tbl_customer_master WHERE (id BETWEEN 12176 AND 12646) GROUP BY shop_name,pincode");
	while($Y=mysql_fetch_object($SQL)){
		mysql_query("UPDATE distributor_customer SET our_cust_id='".$Y->id."' WHERE customer_name = '".$Y->shop_name."' AND pincode = '".$Y->pincode."' AND our_cust_id=''");
		mysql_query("UPDATE areawise_temp SET our_cust_id='".$Y->id."' WHERE cust_name = '".$Y->shop_name."' AND pincode = '".$Y->pincode."' AND our_cust_id=''");
	}
?>