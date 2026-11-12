<?php
include("include/connect.php");

$date = $_REQUEST['date'];

$arr 	= array();
$arr1 	= array();
$arr2 	= array();
$result	= array();
$repname = array();

$sql="SELECT count(*) plan, sum(case when attendance='1' then 1 else 0 end) as visit, (select rep_name from representative where id=reorting.repid) as rep_name FROM reorting WHERE tdate='$date' GROUP BY repid";
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
	$arr2[] = strtoupper($row['rep_name']);
}



array_push($result,$arr1);
array_push($result,$arr);

$values['values']=$result;
$values['repname']=$arr2;

print json_encode($values, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
