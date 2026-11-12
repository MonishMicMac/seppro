<?php

include("connect2.php"); 


$repid=$_REQUEST['repid'];
$month1=$_REQUEST['month1'];

 $sub = substr($month1,5,2);
$year1 = substr($month1,0,4);


global $str;
echo '[{';

$list=array();
$month = $sub;
$year = $year1;

for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);          
    if (date('m', $time)==$month)       
        $list=date('Y-m-d', $time);


//echo $list;echo "<br>";

$a = mysql_query("SELECT COUNT(wp_id) FROM tbl_work_plan WHERE wp_date LIKE '$list' AND attendancestatus='1' AND wp_rep_id='$repid' AND wp_dc='D'")or die(mysql_error());
$a_res = mysql_fetch_array($a);
//echo $list." - ".$a_res['COUNT(wp_id)'];echo "<br>";

$str.='"count":'.'"'.$a_res['COUNT(wp_id)'].'","date":"'.$list.'"},{';
}
 
 $pan =$str; 

echo $jj = substr($pan,0, -2).']';

?>