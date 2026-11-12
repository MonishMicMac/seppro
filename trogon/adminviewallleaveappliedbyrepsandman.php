<?php

include("connect23.php"); 





$repid=$_REQUEST['repid'];
$date = date('Y-m-d');
$a = mysql_query("SELECT * FROM doctors WHERE rep_assign='$repid'")or die(mysql_error());
//echo $acount = mysql_num_rows($a);
global $str;
echo '[{';
while($a_res = mysql_fetch_array($a))
{

$b = mysql_query("SELECT * FROM tbl_work_plan WHERE  wp_dc_id='".$a_res['id']."' AND wp_dc='D' AND reporteddate!='' ORDER BY wp_id DESC LIMIT 1")or die(mysql_error());
$b_res = mysql_fetch_array($b);

$repodate = $b_res['reporteddate'];
if($repodate == '')
{
$days='Not visited';
}
else
{
$diff = abs(strtotime($date) - strtotime($repodate));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
}
$dname= $a_res['doctor_name']." ".$b_res['reporteddate']." ".$days;

$sr='"drname":"'.$a_res['doctor_name'].'","pincode":"'.$a_res['doc_pincode'].'","qual":"'.$a_res['doc_qualification'].'","lastvisited":"'.$b_res['reporteddate'].'","days":"'.$days.'"},{';
$str.=$sr;

}

echo $jj = substr($str,0,-4).'"}]';

?>