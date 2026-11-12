<?php

include("../includes/connect_db.php");
$sql = "SELECT * FROM bus_record, mst_pincode, tbl_pincode_map WHERE bus_record.id = tbl_pincode_map.bus_id AND tbl_pincode_map.bus_id =(SELECT bus_id from student_profile WHERE stu_id = ".$_REQUEST["stu_id"].") AND mst_pincode.pincode_id=tbl_pincode_map.pincode_id";
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