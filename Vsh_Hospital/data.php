<?php
include("include/connect.php");

$manager = $_REQUEST['manager'];
$date = $_REQUEST['date'];
$level = $_REQUEST['level'];


$arr 	= array();
$arr1 	= array();
$arr2 	= array();
$result	= array();
$repname = array();

if($level == 'manager'){
	$sql = "SELECT representative.rep_state_status level_name,count(wp_id) as plan, sum(case when tbl_work_plan.attendancestatus='1' then 1 else 0 end) as visit FROM representative,tbl_work_plan WHERE representative.id=tbl_work_plan.wp_rep_id and tbl_work_plan.wp_date='$date' and representative.rep_name!='' group by representative.rep_state_status";
} elseif($level == 'rep_id'){
	$sql="SELECT id,rep_name level_name,rep_state_status FROM representative WHERE rep_state_status='".$manager."'";
}
$q	 = mysql_query($sql);
$j = 0;
while($row = mysql_fetch_assoc($q)){
	if($j == 0){
		$arr['name'] = 'Plan';
		$arr1['name'] = 'Visit';
		$j++;
	}

	if($level == 'rep_id'){
		$sql1=mysql_query("SELECT representative.rep_name level_name,count(wp_id) as plan, sum(case when tbl_work_plan.attendancestatus='1' then 1 else 0 end) as visit FROM representative,tbl_work_plan WHERE representative.id=tbl_work_plan.wp_rep_id and tbl_work_plan.wp_date='$date' and representative.rep_state_status='$manager' and representative.id='".$row['id']."' and representative.rep_name!='' group by representative.id");
		$row1 = mysql_fetch_assoc($sql1);

		if(mysql_num_rows($sql1)>0){
			$arr['data'][] = $row1['plan'];
			$arr1['data'][] = $row1['visit'];
			$arr2[] = strtoupper($row1['level_name']);
		} else {
			$arr['data'][] = '0';
			$arr1['data'][] = '0';
			$arr2[] = strtoupper($row['level_name']);
		}
	} else {
		$arr['data'][] = $row['plan'];
		$arr1['data'][] = $row['visit'];
		$arr2[] = strtoupper($row['level_name']);
	}
}



array_push($result,$arr1);
array_push($result,$arr);

$values['values']=$result;
$values['repname']=$arr2;

print json_encode($values, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
