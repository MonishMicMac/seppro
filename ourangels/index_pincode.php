<?php

$hostname="localhost";
$username="gageco_ems";
$password="school@123";
$database="gageco_ems";

 $con=mysql_connect($hostname,$username,$password)or die('could not connect');
 mysql_select_db($database,$con)or die ('could not database');


$sql = "SELECT areawise_temp.pincode, areawise_temp.net_amount,areawise_temp.bill_date, pincode_list.pincode, pincode_list.area_name, areawise_temp.our_cust_id, master_district.district_id,  master_district.district_name, pincode_list.dist_id FROM areawise_temp,pincode_list,master_district WHERE areawise_temp.pincode=pincode_list.pincode AND master_district.district_id= pincode_list.dist_id AND areawise_temp.our_cust_id != '' GROUP BY areawise_temp.pincode ORDER BY areawise_temp.id "; 

//replace emp_info with your table namesss
$result = mysql_query($sql);
$json = array();
if(mysql_num_rows($result)){
while($row=mysql_fetch_assoc($result)){
$sql2="SELECT  pincode, SUM(net_amount) AS NETAT, area_name  FROM areawise_temp WHERE  pincode='".$row['pincode']."'";$result2=mysql_query($sql2);while($customers1=mysql_fetch_assoc($result2)){$json1[]=$customers1;}
$json[]=$row;
}
}
//mysql_close($db_name);
//$json2=array_combine($json,$json1);
echo json_encode($json1);
?>