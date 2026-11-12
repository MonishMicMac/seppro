<?php

include("connect23.php"); 

 $id=$_REQUEST['id'];
$outpu;
$outpu1;




$strSQLss = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE representative.rep_id!='0' AND assigningreptomanager.managerid='$id' AND representative.id=assigningreptomanager.repid");
while($strSQL_ress=mysql_fetch_array($strSQLss))
{

$repname=$strSQL_ress['rep_name'];
$repidd=$strSQL_ress['id'];

$strSQL = mysql_query("SELECT representative.id,representative.rep_name FROM representative,assigningreptomanager WHERE representative.rep_id='0' AND assigningreptomanager.managerid='$repidd' AND representative.id=assigningreptomanager.repid");

while($strSQL_res=mysql_fetch_array($strSQL))
{
$repnames=$strSQL_res['rep_name'];
$repidds=$strSQL_res['id'];


$totaldr1=mysql_query("select count(DISTINCT id) as tota from doctors where rep_assign='$repidds'");
$total_dr_list= mysql_fetch_array($totaldr1);
 $totaldr=$total_dr_list['tota']; 



$dayw='';
$dayav='';
 
for ($i=0; $i<=11; $i++) 
{ 
$day=date('Y-m-', strtotime("-$i month")).',';
 $dayas=date('Y-m-', strtotime("-$i month"));



if($i==0)
{
$v1=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v1_cnt,count(DISTINCT wp_dc_id) as cntof from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v1_dr_list= mysql_fetch_array($v1);
$visitedcount11=$v1_dr_list['v1_cnt'];
$visitedcount1=$v1_dr_list['cntof'];
$monthof1=($visitedcount1/$totaldr)*100;
$percentagesd= round($monthof1);
if($visitedcount11=='')
{
$visitedcount11=0;
}
}
if($i==1)
{

$v2=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v2_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v2_dr_list= mysql_fetch_array($v2);
$visitedcount12=$v2_dr_list['v2_cnt'];
if($visitedcount12=='')
{
$visitedcount12=0;
}
if($visitedcount12==0)
{
$monthof1=0;
}
else
{
$vc11=explode(",",$visitedcount11);
$vc12=explode(",",$visitedcount12);
$array= array_diff($vc12,$vc11);
$result = count($array);
$monthof1=($result/$totaldr)*100;
$cominev1v2=$visitedcount11.",".$visitedcount12;
}
}
if($i==2)
{
$v3=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v3_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v3_dr_list= mysql_fetch_array($v3);
$visitedcount13=$v3_dr_list['v3_cnt'];
if($visitedcount13=='')
{
$visitedcount13=0;
}

if($visitedcount13==0)
{
$monthof1=0;
}
else
{
if($repidds==1)
{
$vc13=explode(",",$cominev1v2);
$vc14=explode(",",$visitedcount13);
$array= array_diff($vc14,$vc13);
$result = count($array);
$monthof1=($result/$totaldr)*100;
}
}


}










if($i==3)
{
$v4=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v4_cnt,count(DISTINCT wp_dc_id) as cntof from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v4_dr_list= mysql_fetch_array($v4);
$visitedcount14=$v4_dr_list['v4_cnt'];
$visitedcount2=$v4_dr_list['cntof'];
$monthof1=($visitedcount2/$totaldr)*100;
$percentagesd= round($monthof1);
if($visitedcount14=='')
{
$visitedcount14=0;
}
}

if($i==4)
{

$v5=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v5_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v5_dr_list= mysql_fetch_array($v5);
$visitedcount15=$v5_dr_list['v5_cnt'];
if($visitedcount15=='')
{
$visitedcount15=0;
}
if($visitedcount15==0)
{
$monthof1=0;
}
else
{
$vc14=explode(",",$visitedcount14);
$vc15=explode(",",$visitedcount15);
$array= array_diff($vc15,$vc14);
$result = count($array);
$monthof1=($result/$totaldr)*100;
$cominev3v4=$visitedcount14.",".$visitedcount15;
}
}

if($i==5)
{
$v6=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v6_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v6_dr_list= mysql_fetch_array($v6);
$visitedcount16=$v6_dr_list['v6_cnt'];
if($visitedcount16=='')
{
$visitedcount16=0;
}

if($visitedcount16==0)
{
$monthof1=0;
}
else
{
if($repidds==1)
{
$vc16=explode(",",$cominev3v4);
$vc17=explode(",",$visitedcount16);
$array= array_diff($vc17,$vc16);
$result = count($array);
$monthof1=($result/$totaldr)*100;
}
}





}


















if($i==6)
{
$v7=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v7_cnt,count(DISTINCT wp_dc_id) as cntof from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v7_dr_list= mysql_fetch_array($v7);
$visitedcount17=$v7_dr_list['v7_cnt'];
$visitedcount3=$v7_dr_list['cntof'];
$monthof1=($visitedcount3/$totaldr)*100;
$percentagesd= round($monthof1);
if($visitedcount17=='')
{
$visitedcount17=0;
}
}

if($i==7)
{

$v8=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v8_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v8_dr_list= mysql_fetch_array($v8);
$visitedcount18=$v8_dr_list['v8_cnt'];
if($visitedcount18=='')
{
$visitedcount18=0;
}
if($visitedcount18==0)
{
$monthof1=0;
}
else
{
$vc17=explode(",",$visitedcount17);
$vc18=explode(",",$visitedcount18);
$array= array_diff($vc18,$vc17);
$result = count($array);
$monthof1=($result/$totaldr)*100;
$cominev5v6=$visitedcount17.",".$visitedcount18;
}
}

if($i==8)
{
$v9=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v9_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v9_dr_list= mysql_fetch_array($v9);
$visitedcount19=$v9_dr_list['v9_cnt'];
if($visitedcount19=='')
{
$visitedcount19=0;
}

if($visitedcount19==0)
{
$monthof1=0;
}
else
{
if($repidds==1)
{
$vc18=explode(",",$cominev5v6);
$vc19=explode(",",$visitedcount19);
$array= array_diff($vc19,$vc18);
$result = count($array);
$monthof1=($result/$totaldr)*100;
}
}





}













if($i==9)
{
$v10=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v10_cnt,count(DISTINCT wp_dc_id) as cntof from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v10_dr_list= mysql_fetch_array($v10);
$visitedcount20=$v10_dr_list['v10_cnt'];
$visitedcount4=$v10_dr_list['cntof'];
$monthof1=($visitedcount4/$totaldr)*100;
$percentagesd= round($monthof1);
if($visitedcount20=='')
{
$visitedcount20=0;
}
}

if($i==10)
{

$v11=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v11_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v11_dr_list= mysql_fetch_array($v11);
$visitedcount21=$v11_dr_list['v11_cnt'];
if($visitedcount21=='')
{
$visitedcount21=0;
}
if($visitedcount21==0)
{
$monthof1=0;
}
else
{
$vc20=explode(",",$visitedcount20);
$vc21=explode(",",$visitedcount21);
$array= array_diff($vc21,$vc20);
$result = count($array);
$monthof1=($result/$totaldr)*100;
$cominev7v8=$visitedcount20.",".$visitedcount21;
}
}

if($i==11)
{
$v12=mysql_query("select GROUP_CONCAT(DISTINCT wp_dc_id) as v12_cnt from tbl_work_plan where wp_dc='D' and wp_rep_id='$repidds' and jointworkby='$repidd' and wp_date LIKE  '%".$dayas."%' and attendancestatus='1' and drunavailable='0'");
$v12_dr_list= mysql_fetch_array($v12);
$visitedcount22=$v12_dr_list['v12_cnt'];
if($visitedcount22=='')
{
$visitedcount22=0;
}

if($visitedcount22==0)
{
$monthof1=0;
}
else
{
if($repidds==1)
{
$vc21=explode(",",$cominev7v8);
$vc22=explode(",",$visitedcount22);
$array= array_diff($vc22,$vc21);
$result = count($array);
$monthof1=($result/$totaldr)*100;
}
}





}





$er=round($monthof1).',';
$dayav.=$er;
$dayw.=$day;

 }





$outpu='{"REPID":"'.$repidds.'","REPNAME":"'.$repnames."[".$repname."".'","month":"'.substr($dayw,0,-1).'","bpmavg":"'.substr($dayav,0,-1).'"},';
$outpu1.=$outpu;
}

}






$finaloutput= substr($outpu1, 0, -1);

echo "[".$finaloutput."]";







?>