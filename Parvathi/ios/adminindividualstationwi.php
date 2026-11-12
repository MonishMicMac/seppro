<?php


include("connect1.php");
$repid=$_REQUEST['repid'];

$ladate=$_REQUEST['month1'];


$erql = mysql_query("SELECT rep_id FROM representative where id='$repid'");
$row=mysql_fetch_array($erql);
$reid=$row['rep_id'];

if($reid!='0')
{
global $str;

$individual = mysql_query("SELECT  * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate LIKE '$ladate%' order by leaveapplieddate desc")or die(mysql_error());
if(mysql_num_rows($individual)>0)
{

while($individual_res = mysql_fetch_array($individual))
{

$tbl = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='D' AND drunavailable='0' AND jointworkby='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1'")or die(mysql_error());


$tbl_res = mysql_fetch_array($tbl);




$str.='"count":"'.$tbl_res['CNT'].'","expenses":"'.$individual_res['expenses'].'","jjvisdate":"'.$individual_res['leaveapplieddate'].'"},{';
}
echo '{"title":{"episodes":[{'.substr($str,0,-2).'],"year": 2016} }';
}
else
{
  echo '{"title":{"episodes":[],"year": 2016} }';
}


}
else
{
global $str;

$individual = mysql_query("SELECT  * FROM repgivenasleave WHERE repid='$repid' AND leaveapplieddate LIKE '$ladate%' order by leaveapplieddate desc")or die(mysql_error());
if(mysql_num_rows($individual)>0)
{
while($individual_res = mysql_fetch_array($individual))
{

$tbl = mysql_query("SELECT COUNT(wp_id) AS CNT,wp_date FROM tbl_work_plan WHERE wp_dc='D' AND drunavailable='0' AND wp_rep_id='".$individual_res['repid']."' AND wp_date='".$individual_res['leaveapplieddate']."' AND attendancestatus='1'")or die(mysql_error());


$tbl_res = mysql_fetch_array($tbl);




$str.='"count":"'.$tbl_res['CNT'].'","expenses":"'.$individual_res['expenses'].'","jjvisdate":"'.$individual_res['leaveapplieddate'].'"},{';
}
echo '{"title":{"episodes":[{'.substr($str,0,-2).'],"year": 2016} }';
}
else
{
	echo '{"title":{"episodes":[],"year": 2016} }';	
}
}


?>