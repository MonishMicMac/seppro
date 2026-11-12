<?php 
include("../includes/connect_db.php");
$tbl_id=$_REQUEST['tbl_id'];
$jj = "SELECT * FROM tbl_demo WHERE tbl_id='$tbl_id'";

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