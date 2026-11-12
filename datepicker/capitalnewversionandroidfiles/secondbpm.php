<?php

include("connect23.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;




$strSQLss = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE representative.rep_id='0' AND assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");
while($strSQL_ress=mysql_fetch_array($strSQLss))
{

$repname=$strSQL_ress['rep_name'];
$repidd=$strSQL_ress['id'];



$totaldr1=mysql_query("select count(DISTINCT id) as tota from doctors where rep_assign='$repidd'");
$total_dr_list= mysql_fetch_array($totaldr1);
$totaldr=$total_dr_list['tota'];



$dayw='';
$dayav='';
 
for ($i=0; $i<=11; $i++) 
{ 
$day=date('Y-m-', strtotime("-$i month")).',';
$dayas=date('Y-m-', strtotime("-$i month"));




$v1=mysql_query("select count(DISTINCT wp_dc_id) as v1_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v1_dr_list= mysql_fetch_array($v1);
$visitedcount=$v1_dr_list['v1_cnt'];


$dravg=($visitedcount/$totaldr)*100;

$dravgwe=round($dravg);

$er=$dravgwe.'%,';
$dayav.=$er;
$dayw.=$day;
}





$outpu='{"REPID":"'.$repidd.'","REPNAME":"'.$repname."".'","month":"'.substr($dayw,0,-1).'","bpmavg":"'.substr($dayav,0,-1).'"},';

$outpu1.=$outpu;


}







$finaloutput= substr($outpu1, 0, -1);
echo "[".$finaloutput."]";







?>