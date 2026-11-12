<?php
include("include/connect.php");

$sql=mysql_query("SELECT doctor_id,chemist_id,count(*) as cnt FROM tbl_doctor_chemist GROUP BY CONCAT(doctor_id,' - ',chemist_id) HAVING cnt>1 ORDER BY cnt DESC");
while ($row=mysql_fetch_array($sql)) {
	$doctor_id=$row['doctor_id'];
	$chemist_id=$row['chemist_id'];
	$cnt=$row['cnt']-1;

	mysql_query("DELETE FROM tbl_doctor_chemist WHERE doctor_id='$doctor_id' AND chemist_id='$chemist_id' LIMIT $cnt");
}
?>