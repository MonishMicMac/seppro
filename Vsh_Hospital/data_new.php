<?php
include("include/connect.php");

$manager = $_REQUEST['manager'];
$date = $_REQUEST['date'];
$level = $_REQUEST['level'];

$mgr_id='';
if($manager!=''){
	$mgr_id="and assigningreptomanager.managerid='$manager'";
}

$arr 	= array();
$arr1 	= array();
$arr2 	= array();
$result	= array();
$repname = array();

if($level == 'manager'){
	$sql = "SELECT (select rep_name from representative where id=assigningreptomanager.managerid) level_name,sum(case when tbl_work_plan.UP='P' or tbl_work_plan.UP='U' then 1 else 0 end) as plan, sum(case when tbl_work_plan.attendancestatus='1' then 1 else 0 end) as visit FROM assigningreptomanager,tbl_work_plan WHERE assigningreptomanager.repid=tbl_work_plan.wp_rep_id and tbl_work_plan.wp_date='$date' and assigningreptomanager.managerid in (select managerid FROM assigningreptomanager group by managerid) group by assigningreptomanager.managerid";
} elseif($level == 'rep_id'){
	$sql="SELECT (select rep_name from representative where id=assigningreptomanager.repid) level_name,sum(case when tbl_work_plan.UP='P' or tbl_work_plan.UP='U' then 1 else 0 end) as plan, sum(case when tbl_work_plan.attendancestatus='1' then 1 else 0 end) as visit FROM assigningreptomanager,tbl_work_plan WHERE assigningreptomanager.repid=tbl_work_plan.wp_rep_id and tbl_work_plan.wp_date='$date' and assigningreptomanager.managerid='$manager' and assigningreptomanager.managerid in (select managerid FROM assigningreptomanager group by managerid) group by assigningreptomanager.repid";
}
$q	 = mysql_query($sql);
$j = 0;
while($row = mysql_fetch_assoc($q)){
	if($j == 0){
	$arr['name'] = 'Plan';
	$arr1['name'] = 'Visit';
		$j++;
	}
	$arr['data'][] = $row['plan'];
	$arr1['data'][] = $row['visit'];
	$arr2[] = strtoupper($row['level_name']);
}



array_push($result,$arr1);
array_push($result,$arr);

$values['values']=$result;
$values['repname']=$arr2;

print json_encode($values, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
