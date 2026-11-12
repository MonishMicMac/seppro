<?php
session_start();
include("include/connect.php");

$week_day=array('1' => "Monday1",'2' => "Tuesday1",'3' => "Wednesday1",'4' => "Thursday1",'5' => "Friday1",'6' => "Saturday1",'7' => "Monday2",'8' => "Tuesday2",'9' => "Wednesday2",'10' => "Thursday2",'11' => "Friday2",'12' => "Saturday2");

$sql=mysql_query("SELECT last_date FROM mst_tour_plan ORDER BY id DESC");
$row=mysql_fetch_array($sql);
$tp_last_date=$row['last_date'];
$f_date = new DateTime($tp_last_date);
$final_date=$f_date->modify('first monday')->format('Y-m-d');

$d=0;
foreach ($week_day as $day) {
	if(date('l', strtotime($final_date . ' +'.$d.' day'))!='Sunday'){
		$date = date('Y-m-d', strtotime($final_date . ' +'.$d.' day'));
	} else {
		$d++;
		$date = date('Y-m-d', strtotime($final_date . ' +'.$d.' day'));
	}
	$sql1=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_day='$day'");
	if(mysql_num_rows($sql1)>0){
		while($row1=mysql_fetch_array($sql1)){
			$wp_dc_id=$row1['wp_dc_id'];
			$rep_id=$row1['wp_rep_id'];
			mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,c_date,c_time)VALUES('$date','D','$wp_dc_id','$rep_id',CURDATE(),CURTIME())");
			mysql_query("INSERT INTO mst_tour_plan(wp_date,wp_day,wp_dc_id,wp_rep_id,c_date,c_time)VALUES('$date','$day','$wp_dc_id','$rep_id',CURDATE(),CURTIME())");
		}
	}
	$d++;
}
mysql_query("UPDATE mst_tour_plan SET last_date='$date' WHERE c_date=CURDATE()");

?>