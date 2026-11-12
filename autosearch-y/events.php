<?php
session_start();
include("connect_db.php");
$rep_id=$_REQUEST['rep_id'];
$sql = "SELECT wp_rep_id as id,wp_date as start,count(*) as title FROM tbl_work_plan WHERE wp_rep_id='$rep_id' GROUP BY wp_date";

try {
	$host=DB_HOST; $name=DB_NAME; $user=DB_USER; $pass=DB_PASS;
	$db = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
} catch(Exception $e) {
	exit('Unable to connect to database.');
}

$result = $db->query($sql) or die(print_r($db->errorInfo()));

echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

?>