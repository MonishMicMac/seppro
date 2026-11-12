<?php

include("connect1.php");
$repid=$_REQUEST['repid'];;

$ladate=$_REQUEST['ladate'];;

$sql = mysql_query("SELECT rep_id FROM representative where id='$repid'");
$row=mysql_fetch_array($sql);
$reid=$row['rep_id'];



if($reid!='0' || $reid=='0')
{


$totalcals= mysql_query("SELECT COUNT(wp_id) AS TC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D'")or die(mysql_error());

$totalcals_res = mysql_fetch_array($totalcals);

$jjtotalcount = $totalcals_res['TC'];



$visitedcals= mysql_query("SELECT COUNT(wp_id) AS VC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1'")or die(mysql_error());

$visitedcals_res = mysql_fetch_array($visitedcals);

$jjvisitcount = $visitedcals_res['VC'];



$missedcals= mysql_query("SELECT COUNT(wp_id) AS MC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='0'")or die(mysql_error());

$missedcals_res = mysql_fetch_array($missedcals);

$jjmissedcount = $missedcals_res['MC'];




$jointwork= mysql_query("SELECT COUNT(wp_id) AS JWC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby!='0'")or die(mysql_error());

$jointwork_res = mysql_fetch_array($jointwork);

$jjjoinedcount = $jointwork_res['JWC'];



$individual= mysql_query("SELECT COUNT(wp_id) AS IC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby='0'")or die(mysql_error());

$individual_res = mysql_fetch_array($individual);

$jjindividualcount = $individual_res['IC'];


$dravailable= mysql_query("SELECT COUNT(wp_id) AS DA FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());

$dravailable_res = mysql_fetch_array($dravailable);

$jjdravailcount = $dravailable_res['DA'];



$drunavailable= mysql_query("SELECT COUNT(wp_id) AS DUA FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='1'")or die(mysql_error());

$drunavailable_res = mysql_fetch_array($drunavailable);

$jjdrunavailcount = $drunavailable_res['DUA'];



echo '[{"calls":"totalcalls","count":'.'"'.$jjtotalcount.'"}'.',{"calls":"visitedcalls","count":'.'"'."$jjvisitcount".'"},{"calls":"missedcalls","count":"'."$jjmissedcount".'"},{"calls":"joinedwork","count":"'."$jjjoinedcount".'"},{"calls":"individual","count":"'."$jjindividualcount".'"},{"calls":"Dr available","count":"'."$jjdravailcount".'"},{"calls":"Dr unavailable","count":"'."$jjdrunavailcount".'"}]';
}
else
{



$totalcals= mysql_query("SELECT COUNT(wp_id) AS TC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D'")or die(mysql_error());

$totalcals_res = mysql_fetch_array($totalcals);

$jjtotalcount = $totalcals_res['TC'];



$visitedcals= mysql_query("SELECT COUNT(wp_id) AS VC FROM tbl_work_plan WHERE jointworkby='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1'")or die(mysql_error());

$visitedcals_res = mysql_fetch_array($visitedcals);

$jjvisitcount = $visitedcals_res['VC'];



$missedcals= mysql_query("SELECT COUNT(wp_id) AS MC FROM tbl_work_plan WHERE jointworkby='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='0'")or die(mysql_error());

$missedcals_res = mysql_fetch_array($missedcals);

$jjmissedcount = $missedcals_res['MC'];




$jointwork= mysql_query("SELECT COUNT(wp_id) AS JWC FROM tbl_work_plan WHERE jointworkby='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby!='0'")or die(mysql_error());

$jointwork_res = mysql_fetch_array($jointwork);

$jjjoinedcount = $jointwork_res['JWC'];



$individual= mysql_query("SELECT COUNT(wp_id) AS IC FROM tbl_work_plan WHERE jointworkby='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby='0'")or die(mysql_error());

$individual_res = mysql_fetch_array($individual);

$jjindividualcount = $individual_res['IC'];


$dravailable= mysql_query("SELECT COUNT(wp_id) AS DA FROM tbl_work_plan WHERE jointworkby='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());

$dravailable_res = mysql_fetch_array($dravailable);

$jjdravailcount = $dravailable_res['DA'];



$drunavailable= mysql_query("SELECT COUNT(wp_id) AS DUA FROM tbl_work_plan WHERE jointworkby='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='1'")or die(mysql_error());

$drunavailable_res = mysql_fetch_array($drunavailable);

$jjdrunavailcount = $drunavailable_res['DUA'];



echo '[{"calls":"totalcalls","count":'.'"'.$jjtotalcount.'"}'.',{"calls":"visitedcalls","count":'.'"'."$jjvisitcount".'"},{"calls":"missedcalls","count":"'."$jjmissedcount".'"},{"calls":"joinedwork","count":"'."$jjjoinedcount".'"},{"calls":"individual","count":"'."$jjindividualcount".'"},{"calls":"Dr available","count":"'."$jjdravailcount".'"},{"calls":"Dr unavailable","count":"'."$jjdrunavailcount".'"}]';
}



?>
