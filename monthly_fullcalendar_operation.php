<?php
	include("autosearch-y/connect_db.php");
if(isset($_REQUEST['rep_id'])){
  $rep_id=$_REQUEST['rep_id'];


$sql = "SELECT wp_id as id,concat('P : ',sum(case when mtp='1' then 1 else 0 end),' - V : ',sum(case when attendancestatus='1' then 1 else 0 end),' - M : ',sum(case when (mtp='1' and attendancestatus='0') then 1 else 0 end)) as title, date(wp_date) as start from tbl_work_plan WHERE wp_rep_id='$rep_id' GROUP BY wp_date";

try {
$db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
} catch(Exception $e) {
 exit('Unable to connect to database.');
}

$result = $db->query($sql) or die(print_r($db->errorInfo()));

echo json_encode($result->fetchAll(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);
} else { echo json_encode(''); }
?>