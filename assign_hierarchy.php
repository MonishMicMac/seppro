<?php
include("include/connect.php");


if(isset($_REQUEST['business_hierarchy'])){
$b_h=$_REQUEST['business_hierarchy'];
$rep_id=$_REQUEST['rep_id'];

for ($i=0; $i < count($rep_id); $i++) { 
	$sql=mysql_query("UPDATE representative SET rep_grade='".$b_h."' where id='".$rep_id[$i]."'");
}
header('location:business_hierarchy.php');
}


if(isset($_REQUEST['grade'])){
	$rep='';
	$grade=$_REQUEST['grade'];
	if($grade==0){
		$sql1=" and rep_grade!='$grade'";
	} else {
		$sql1=" and rep_grade='$grade'";
	}
	$sql=mysql_query("SELECT id from representative where id!='' $sql1");
	while ($row=mysql_fetch_array($sql)) {
		$rep[]=$row['id'];
	}
	echo json_encode($rep);
}

if(isset($_REQUEST['map_id'])){
	$i=0; $j=5;
	$map_id=$_REQUEST['map_id'];
	$sql=mysql_query("SELECT id,rep_name from representative where rep_grade='$map_id'");
	echo "<table cellpadding='10'>";
	while ($row=mysql_fetch_array($sql)) {
		if($i == $j) { $j=$j+5; echo '<tr>'; }
		echo "<td><input type='radio' class='top_val' name='hierarchy_person_name' id='$map_id' repid='".$row['id']."' value='".$row['id']."'>".$row['rep_name']."</td>";
		if($i == $j) { echo '</tr>'; }
		$i++;
	}
	echo "</table>";

	$sql1=mysql_query("SELECT id,business_hierarchy from mst_business_hierarchy where id<'$map_id' order by id desc");
	echo "<select name='hierarchy_less_name' onchange='rep_map_down(this)' required><option value=''>- Select -</option>";
	while ($row1=mysql_fetch_array($sql1)) {
		echo "<option value='".$row1['id']."'>".$row1['business_hierarchy']."</option>";
	}
	echo "</select>";
}

if(isset($_REQUEST['rep_map_id'])){
	$i=0; $j=5;
	$map_id=$_REQUEST['rep_map_id'];
	$sql=mysql_query("SELECT id,rep_name from representative where rep_grade='$map_id' and id not in (select repid from assigningreptomanager)");
	echo "<table cellpadding='10'>";
	while ($row=mysql_fetch_array($sql)) {
		if($i == $j) { $j=$j+5; echo '<tr>'; }
		echo "<td><input type='checkbox' class='low_val' name='map_name[]' id='".$row['id']."' value='".$row['id']."'>".$row['rep_name']."</td>";
		if($i == $j) { echo '</tr>'; }
		$i++;
	}
	echo "</table>";
}

if(isset($_REQUEST['h_mapping_submit'])){
	$mgr_id=$_REQUEST['hierarchy_person_name'];
	$rep_id=$_REQUEST['map_name'];

	for ($i=0; $i < count($rep_id); $i++) { 
		$sql=mysql_query("INSERT into assigningreptomanager(managerid,repid) values('".$mgr_id."','".$rep_id[$i]."')");
	}
	header('location:hierarchy_mapping.php');
}

if(isset($_REQUEST['hierarchy_reporting'])){
	$hierarchy_name=$_REQUEST['hierarchy_name'];
	$priority_name=$_REQUEST['priority_name'];
	$reporting_to=$_REQUEST['reporting_to'];

	for ($i=0; $i < count($hierarchy_name); $i++) { 
		$sql=mysql_query("UPDATE mst_business_hierarchy set priority='".$priority_name[$i]."',reporting_to='".$reporting_to[$i]."' where id='".$hierarchy_name[$i]."'");
	}
	header('location:business_hierarchy.php');
}
?>