<?php
include("connect23.php"); 

$repid=$_REQUEST['repid'];;

$ladate=$_REQUEST['ladate'];;








$totalcals= mysql_query("SELECT COUNT(wp_id) AS TC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D'")or die(mysql_error());

$totalcals_res = mysql_fetch_array($totalcals);

$jjtotalcount = $totalcals_res['TC'];


$totalcals1= mysql_query("SELECT COUNT(wp_id) AS TC FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D'")or die(mysql_error());

$totalcals_res1 = mysql_fetch_array($totalcals1);

$jjtotalcount1 = $totalcals_res1['TC'];

$jjtotalcount=($jjtotalcount+$jjtotalcount1);









$visitedcals= mysql_query("SELECT COUNT(wp_id) AS VC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());

$visitedcals_res = mysql_fetch_array($visitedcals);

$jjvisitcount = $visitedcals_res['VC'];


$visitedcals1= mysql_query("SELECT COUNT(wp_id) AS VC FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());

$visitedcals_res1 = mysql_fetch_array($visitedcals1);

$jjvisitcount1 = $visitedcals_res1['VC'];


$jjvisitcount=($jjvisitcount+$jjvisitcount1);




$missedcals= mysql_query("SELECT COUNT(wp_id) AS MC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='0'")or die(mysql_error());

$missedcals_res = mysql_fetch_array($missedcals);

$jjmissedcount = $missedcals_res['MC'];


$missedcals1= mysql_query("SELECT COUNT(wp_id) AS MC FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='0'")or die(mysql_error());

$missedcals_res1 = mysql_fetch_array($missedcals1);

$jjmissedcount1 = $missedcals_res1['MC'];

$jjmissedcount=($jjmissedcount+$jjmissedcount1);


$jointwork= mysql_query("SELECT COUNT(wp_id) AS JWC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby!='0' and drunavailable='0'")or die(mysql_error());

$jointwork_res = mysql_fetch_array($jointwork);

$jjjoinedcount = $jointwork_res['JWC'];


$jointwork1= mysql_query("SELECT COUNT(wp_id) AS JWC FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby!='0' and drunavailable='0'")or die(mysql_error());

$jointwork_res1 = mysql_fetch_array($jointwork1);

$jjjoinedcount1 = $jointwork_res1['JWC'];

$jjjoinedcount=($jjjoinedcount+$jjjoinedcount1);


$tbl23 = mysql_query("SELECT GROUP_CONCAT(jointworkby) AS jointworkby FROM tbl_work_plan WHERE wp_dc='D' AND wp_rep_id='$repid' AND wp_date='$ladate' AND attendancestatus='1' and drunavailable='0'")or die(mysql_error());


$tbl_res23 = mysql_fetch_array($tbl23);
$rty= $tbl_res23['jointworkby'];


$individual= mysql_query("SELECT COUNT(wp_id) AS IC FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby='0' and drunavailable='0'")or die(mysql_error());

$individual_res = mysql_fetch_array($individual);

$jjindividualcount = $individual_res['IC'];


$individual1= mysql_query("SELECT COUNT(wp_id) AS IC FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND jointworkby='0' and drunavailable='0'")or die(mysql_error());

$individual_res1 = mysql_fetch_array($individual1);

$jjindividualcount1 = $individual_res1['IC'];

$jjindividualcount=($jjindividualcount+$jjindividualcount1);


$dravailable= mysql_query("SELECT COUNT(wp_id) AS DA FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='0' and drunavailable='0'")or die(mysql_error());

$dravailable_res = mysql_fetch_array($dravailable);

$jjdravailcount = $dravailable_res['DA'];



$drunavailable= mysql_query("SELECT COUNT(wp_id) AS DUA FROM tbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='1'")or die(mysql_error());

$drunavailable_res = mysql_fetch_array($drunavailable);

$jjdrunavailcount = $drunavailable_res['DUA'];


$drunavailable1= mysql_query("SELECT COUNT(wp_id) AS DUA FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repid' AND wp_date ='$ladate' AND wp_dc='D' AND attendancestatus='1' AND drunavailable='1'")or die(mysql_error());

$drunavailable_res1 = mysql_fetch_array($drunavailable1);

$jjdrunavailcount1 = $drunavailable_res1['DUA'];

$jjdrunavailcount=($jjdrunavailcount+$jjdrunavailcount1);

echo '[{"calls":"planned","count":'.'"'.$jjtotalcount.'"}'.',{"calls":"VISITED","count":'.'"'."$jjvisitcount".'"},{"calls":"MISSED","count":"'."$jjmissedcount".'"},{"calls":"JOINT","count":"'."$jjjoinedcount".'"},{"calls":"INDIVIDUAL","count":"'."$jjindividualcount".'"},{"calls":"AVAILABLE","count":"'."$jjdravailcount".'"},{"calls":"UN AVAILABLE","count":"'."$jjdrunavailcount".'"},{"calls":"JWO","count":"'.$rty.'"}]';

?>
