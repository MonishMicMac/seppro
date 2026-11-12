<?php
include("connect23.php"); 

$dcid=$_REQUEST['dcid'];
$chemistid=$_REQUEST['chemistid'];
$repid=$_REQUEST['repid'];



$proid = explode(",",$chemistid);





for($i=0;$i< count($proid);$i++){
  


$jjsdzz = mysql_query("UPDATE tbl_cds_master SET mapping='0' WHERE tbl_cds_dcsid= '$dcid' AND mapping= '$proid[$i]' AND tbl_cds_status='D' AND tbl_cds_repid= '$repid'")or die(mysql_error());

echo "UPDATE tbl_cds_master SET mapping='0' WHERE tbl_cds_dcsid= '$dcid' AND mapping= '$proid[$i]' AND tbl_cds_status='D' AND tbl_cds_repid= '$repid'";

}

?>