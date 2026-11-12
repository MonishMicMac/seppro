<?php
include("connect23.php"); 
 define('WP_MEMORY_LIMIT', '512M');
$edate=explode("-",$_REQUEST['mdate']);

$fdate=$edate[0]."-".$edate[1]."-"."01";
echo "["; $str="";
$list=mysql_query("SELECT * FROM tbl_work_plan,representative WHERE reporteddate BETWEEN '".$fdate."' AND '".$_REQUEST['mdate']."' AND tbl_work_plan.wp_rep_id=representative.id AND representative.rep_id='0' AND attendancestatus='1' GROUP BY tbl_work_plan.wp_rep_id");
while($list_res=mysql_fetch_array($list))
{
	//echo $list_res['wp_rep_id']."--".$list_res['wp_dc_id']."<br>";
	$metonce=mysql_query("SELECT COUNT(wp_dc_id)  AS M1 FROM tbl_work_plan WHERE wp_rep_id='".$list_res['wp_rep_id']."' AND wp_dc='D' AND reporteddate BETWEEN '".$fdate."' AND '".$_REQUEST['mdate']."' GROUP BY wp_dc_id HAVING COUNT(wp_dc_id) =1");
	$mro=mysql_num_rows($metonce);

	$mettwice=mysql_query("SELECT COUNT(wp_dc_id)  AS M2 FROM tbl_work_plan WHERE wp_rep_id='".$list_res['wp_rep_id']."' AND wp_dc='D' AND reporteddate BETWEEN '".$fdate."' AND '".$_REQUEST['mdate']."' GROUP BY wp_dc_id HAVING COUNT(wp_dc_id) >=2");
	$mrt=mysql_num_rows($mettwice);

	$str.='{"repid":"'.$list_res['wp_rep_id'].'","repname":"'.$list_res['rep_name'].'","metonce":"'.$mro.'","mettwice":"'.$mrt.'"},';
}
	// echo '[{"unvisitdoctors":"'.$unvisitdc.'","report":"'.$count.'","doctors":"'.$count1.'","onevisit":"'.$obResult2.'","twovisit":"'.$obResult3.'","threevisit":"'.$obResult4.'","status":"'.$status1.'"}]';
echo substr($str,0,-1)."]";
?>