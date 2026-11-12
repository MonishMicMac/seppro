<?php

include("../includes/connect_db.php");



$sql = "SELECT * FROM bus_record where bus_ime_no=".$_REQUEST["bus_ime_no"].""; 
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