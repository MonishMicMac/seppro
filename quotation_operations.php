<?php
include("include/connect.php");


if(@$_REQUEST['condition']=="show_val"){
	$json=array();
	$sql=mysql_query("SELECT ptr,pts FROM product WHERE id='".$_REQUEST['id']."'");
	while($row=mysql_fetch_array($sql)){
		$json[]['ptr']=$row['ptr'];
		$json[]['pts']=$row['pts'];
	}
	echo json_encode($json);
}
?>