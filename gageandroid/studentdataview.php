<?php 
include("../includes/connect_db.php");

$jj = "SELECT * FROM tbl_demo";

$result = mysql_query($jj);
$json = array();
if(mysql_num_rows($result)){
while($row=mysql_fetch_assoc($result)){
$json[]=$row;
}
}
//mysql_close($db_name);
echo json_encode($json); 
?>