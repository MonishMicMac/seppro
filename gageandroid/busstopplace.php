<?php

include("../includes/connect_db.php");



$sql = "SELECT * FROM mst_pincode where pincode_id IN (SELECT pincode_id FROM tbl_pincode_map where bus_id = ".$_REQUEST["bus_id"].")"; //replace emp_info with your table name
$result = mysql_query($sql);
$json = array();
if(mysql_num_rows($result)){
while($row=mysql_fetch_assoc($result)){
$json[]=$row;
}
}
//mysql_close($db_name);
echo json_encode($json); 

?>