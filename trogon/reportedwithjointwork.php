<?php

include("connect23.php"); 
 

$doctorid=$_REQUEST['doctorid'];

global $res;

echo '[';

$strSQL = mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,representative.rep_name
FROM tbl_work_plan,representative
WHERE tbl_work_plan.wp_dc_id=  '$doctorid' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.jointworkby>0 AND representative.id=tbl_work_plan.jointworkby ORDER BY tbl_work_plan.wp_id DESC LIMIT 30")or die(mysql_error());

while($strSQL_res=mysql_fetch_array($strSQL))
{
   $name=$strSQL_res['rep_name'];

$res.='{"drunavailablereason":"'.$strSQL_res['drunavailablereason'].'","reporteddate":"'.$strSQL_res[reporteddate].'","reportedtime":"'.$strSQL_res[reportedtime].'","rep_name":"'.$name.'"},';
}
echo "SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,representative.rep_name
FROM tbl_work_plan,representative
WHERE tbl_work_plan.wp_dc_id=  '$doctorid' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.jointworkby=0 AND representative.id=tbl_work_plan.jointworkby ORDER BY tbl_work_plan.wp_id DESC LIMIT 30";

$strSQL1 = mysql_query("SELECT tbl_work_plan.drunavailablereason,tbl_work_plan.reporteddate,tbl_work_plan.reportedtime,representative.rep_name
FROM tbl_work_plan,representative
WHERE tbl_work_plan.wp_dc_id=  '$doctorid' AND tbl_work_plan.wp_dc='D' AND tbl_work_plan.jointworkby=0 AND representative.id=tbl_work_plan.jointworkby ORDER BY tbl_work_plan.wp_id DESC LIMIT 30")or die(mysql_error());

while($strSQL1_res=mysql_fetch_array($strSQL1))
{
   $name="Individual";

$res1.='{"drunavailablereason":"'.$strSQL1_res['drunavailablereason'].'","reporteddate":"'.$strSQL1_res[reporteddate].'","reportedtime":"'.$strSQL1_res[reportedtime].'","rep_name":"'.$name.'"},';
}
echo $res1;
?>