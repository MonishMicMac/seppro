<?php

include("connect1.php");

$inout5=mysql_query("SELECT reportedtime, wp_id FROM tbl_work_plan where `reportedtime` != ''")or die(mysql_error());
while($inout_row5=mysql_fetch_array($inout5)) :
	$inout_row5["reportedtime"];
	$time = (int)substr($inout_row5["reportedtime"], 0, 2);
	
	$am = substr($inout_row5["reportedtime"], 9, 2);
	if($am=="PM") :
		$time+=12;
	else :
		if($time<10) :
			$time = "0".$time;
		endif;
	endif;
	
	mysql_query("update tbl_work_plan set reportedtime='".$time.substr($inout_row5["reportedtime"], 2, 6)."' where `wp_id` = '".$inout_row5["wp_id"]."'");
	//exit;
endwhile;


	mysql_close($con);
?>