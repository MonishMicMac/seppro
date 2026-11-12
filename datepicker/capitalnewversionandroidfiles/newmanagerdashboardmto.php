<?php

include("connect23.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;

$date=$_REQUEST['date'];
$full_date=date("Y-m-d",strtotime($date));
$dt = explode("-",$full_date);

$datr=$dt[0]."-".$dt[1]."-";

$datr1=$dt[0]."-".$dt[1];

$strSQL = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE representative.rep_id='0' AND assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");

while($strSQL_res=mysql_fetch_array($strSQL))
{
$repname=$strSQL_res['rep_name'];
$repidd=$strSQL_res['id'];


$v1=mysql_query("select count(DISTINCT wp_dc_id) as v1_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidd' and wp_date LIKE  '%".$datr."%' and attendancestatus='1' and drunavailable='0'");
$v1_dr_list= mysql_fetch_array($v1);
$visitedcount=$v1_dr_list['v1_cnt'];


$totaldr1=mysql_query("select count(DISTINCT id) as tota from doctors where rep_assign='$repidd'");
$total_dr_list= mysql_fetch_array($totaldr1);
$totaldr=$total_dr_list['tota'];
$missedr=$totaldr-$visitedcount;


$dravg=($visitedcount/$totaldr)*100;

$daysworked=mysql_query("select count(id) as daysworked1_cnt from repgivenasleave where leaveapplieddate LIKE  '%".$datr."%' and (expenses not in('leave')) and (expenses not in('others')) and repid='$repidd'");
$daysworkedlist= mysql_fetch_array($daysworked);
$daysworkedcount=$daysworkedlist['daysworked1_cnt'];
$leavesworked=mysql_query("select count(id) as leaves_cnt from repgivenasleave where leaveapplieddate LIKE  '%".$datr."%' and expenses like('leave') and repid='$repidd'");
$leavesworkedlist= mysql_fetch_array($leavesworked);
$leavescount=$leavesworkedlist['leaves_cnt'];

$meetingworked=mysql_query("select count(id) as meeting_cnt from repgivenasleave where leaveapplieddate LIKE  '%".$datr."%' and expenses like('meeting') and repid='$repidd'");
$meetingworkedlist= mysql_fetch_array($meetingworked);
$meetingcount=$meetingworkedlist['meeting_cnt'];

$chemistv1=mysql_query("select count(DISTINCT wp_dc_id) as chemistv1_cnt from tbl_work_plan where wp_dc='C' and wp_rep_id='$repidd' and wp_date LIKE  '%".$datr."%' and attendancestatus='1' and drunavailable='0'");
$chemistv1_dr_list= mysql_fetch_array($chemistv1);
$chemistvisitedcount=$chemistv1_dr_list['chemistv1_cnt'];

$totalch1=mysql_query("select count(DISTINCT id) as totach from tbl_customer_master where rep_id='$repidd'");
$total_ch_list= mysql_fetch_array($totalch1);
$totalch=$total_ch_list['totach'];


$totalchavg=($chemistvisitedcount/$totalch)*100;


$totaldrfav1=mysql_query("select count(DISTINCT id) as totafav from doctors where rep_assign='$repidd' AND favourite='1'");
$total_drfav_list= mysql_fetch_array($totaldrfav1);
$totaldrfav=$total_drfav_list['totafav'];



$totaldrfavvisited=mysql_query("SELECT COUNT(DISTINCT wp_dc_id)  as totafavvisited FROM tbl_work_plan,doctors WHERE tbl_work_plan.wp_rep_id='$repidd' AND tbl_work_plan.attendancestatus='1' AND tbl_work_plan.drunavailable='0' AND tbl_work_plan.wp_dc='D'  AND doctors .favourite='1' AND tbl_work_plan.wp_dc_id=doctors.id AND tbl_work_plan.wp_date like '%$datr%'");
$total_drfavvisited_list= mysql_fetch_array($totaldrfavvisited);
$totaldrfavvisited=$total_drfavvisited_list['totafavvisited'];

$totaldrfavnotmetts=$totaldrfav-$totaldrfavvisited; 





$strSQLss = mysql_query("SELECT doctor_name,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='Not Met' then count( wp_dc_id) else '0' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$datr1' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as days FROM doctors WHERE rep_id='$repidd'")or die(mysql_error());

$metonce=0;
$mettwice=0;

$extravisit=0;


while($ressss=mysql_fetch_array($strSQLss))
{

if($ressss['days']=='1')
{
$metonce++;
}
else if($ressss['days']=='2')
{
$mettwice++;
}
else if($ressss['days']>='3')
{
$extravisit++;
}


}




$mettwice=$mettwice+$extravisit;









$strSQLssdf = mysql_query("SELECT doctor_name,(SELECT (case when group_concat(DATE_FORMAT(wp_date,'%d'))!='Not Met' then count( wp_dc_id) else '0' end) FROM tbl_work_plan WHERE wp_dc_id=doctors.id and DATE_FORMAT(tbl_work_plan.wp_date,'%Y-%m')='$datr1' and attendancestatus='1' and drunavailable='0' and wp_dc='D') as days FROM doctors WHERE rep_id='$repidd' and favourite='1'")or die(mysql_error());

$fametonce=0;
$famettwice=0;

$faextravisit=0;


while($ressssgqr=mysql_fetch_array($strSQLssdf))
{

if($ressssgqr['days']=='1')
{
$fametonce++;
}
else if($ressssgqr['days']=='2')
{
$famettwice++;
}
else if($ressssgqr['days']>='3')
{
$faextravisit++;
}


}




$famettwice=$famettwice+$faextravisit;


$bpmv1=mysql_query("select count(DISTINCT wp_dc_id) as bpmv1_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidd' and wp_date LIKE  '%".$datr."%' and attendancestatus='1' and drunavailable='0' AND jointworkby!=0");
$bpmv1_dr_list= mysql_fetch_array($bpmv1);
$bpmvisitedcount=$bpmv1_dr_list['bpmv1_cnt'];


$bpmdravg=($bpmvisitedcount/$totaldr)*100;


$outpu='{"REPID":"'.$repidd.'","REPNAME":"'.$repname.'","bpmavg":"'.round($bpmdravg).'","totalchemistt":"'.$totalch.'","totaldr":"'.$totaldr.'","favmetonce":"'.$fametonce.'","favmettwice":"'.$famettwice.'","chemistavg":"'.round($totalchavg).'","dravg":"'.round($dravg).'","drmetonce":"'.$metonce.'","mettwice":"'.$mettwice.'","extra":"'.$extravisit.'","drmet":"'.$visitedcount.'","drmissed":"'.$missedr.'","dayworked":"'.$daysworkedcount.'","leave":"'.$leavescount.'","meeting":"'.$meetingcount.'","chemistmet":"'.$chemistvisitedcount.'","totalfav":"'.$totaldrfav.'","totalnotmet":"'.$totaldrfavnotmetts.'"},';


$outpu1.=$outpu;
}


$finaloutput= substr($outpu1, 0, -1);

echo "[".$finaloutput."]";







?>