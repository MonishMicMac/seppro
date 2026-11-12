<?php
include("connect23.php"); 

  $date=$_REQUEST['date'];
  $wp_rep_id= $_REQUEST['wp_rep_id'];









$a=mysql_query("SELECT COUNT(DISTINCT wp_dc_id) AS CNT FROM tbl_work_plan WHERE wp_date LIKE  '%".$date."%' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1'")or die(mysql_error());

$a_res=mysql_fetch_array($a);
$totals = $a_res['CNT'];


$df=mysql_query("SELECT COUNT(*) AS dftot FROM doctors WHERE rep_assign='$wp_rep_id'")or die(mysql_error());
$df_res=mysql_fetch_array($df);
$approveddocotr= $df_res['dftot'];



$undf=mysql_query("SELECT COUNT(*) AS undftot FROM unapproveddoctors WHERE rep_assign='$wp_rep_id'")or die(mysql_error());
$undf_res=mysql_fetch_array($undf);
$unapproveddocotr= $undf_res['undftot'];



$favundf=mysql_query("SELECT COUNT(*) AS favundftot FROM doctors WHERE rep_assign='$wp_rep_id' AND favourite='1'")or die(mysql_error());
$favundf_res=mysql_fetch_array($favundf);
$favunapproveddocotr= $favundf_res['favundftot'];


$b=mysql_query("SELECT COUNT(DISTINCT wp_dc_id) AS bcnt FROM tbl_work_plan WHERE wp_date LIKE  '%".$date."%' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1' AND drunavailable='0'")or die(mysql_error());
$b_res=mysql_fetch_array($b);
$visited = $b_res['bcnt'];


$c=mysql_query("SELECT COUNT(DISTINCT wp_dc_id) AS ccnt FROM tbl_work_plan WHERE wp_date LIKE  '%".$date."%' AND wp_dc='D' AND wp_rep_id='$wp_rep_id' AND attendancestatus='1' AND drunavailable='1'")or die(mysql_error());
$c_res=mysql_fetch_array($c);
$missed = $c_res['ccnt'];





$performance =($totals/$approveddocotr)*100;


date_default_timezone_set("Asia/Kolkata");
$date =date('Y-m-d');

$full_date=date("Y-m-d",strtotime($date));

$no_of_days=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($full_date)),date("Y",strtotime($full_date)));

$date=date("Y-m",strtotime($full_date));

$i=1;
$j=0;
while($i<=31){

$day=date("l",strtotime($date.'-'.$i));

if($j<=$no_of_days && $day!='Sunday'){

 $auto_date=date("Y-m-d",strtotime($date.'-'.$i));


$jj = mysql_query("SELECT * FROM repgivenasleave WHERE leaveapplieddate='$auto_date' AND repid= '$wp_rep_id' AND expenses = 'others'")or die(mysql_error());
if(mysql_num_rows($jj) == 0) {

$j++;

}
}
$i++;
}

 $j;
  $total=$j;



$leavesworked=mysql_query("select count(id) as leaves_cnt from repgivenasleave where leaveapplieddate LIKE  '%".$date."%' and expenses like('leave') and repid='$wp_rep_id'");
$leavesworkedlist= mysql_fetch_array($leavesworked);
$leavescount=$leavesworkedlist['leaves_cnt'];


$meeting=mysql_query("select count(id) as meeting_cnt from repgivenasleave where leaveapplieddate LIKE  '%".$date."%' and expenses like('meeting') and repid='$wp_rep_id'");
$meetinglist= mysql_fetch_array($meeting);
$meetingcount=$meetinglist['meeting_cnt'];


$rxpad=mysql_query("SELECT COUNT(*) AS rxpaddftot FROM doctors WHERE rep_assign='$wp_rep_id' AND visitcardclinicphoto!=''")or die(mysql_error());
$rxpaddf_res=mysql_fetch_array($rxpad);
$rxpadlisttr= $rxpaddf_res['rxpaddftot'];


$plotpad=mysql_query("SELECT COUNT(*) AS plotdftot FROM doctors WHERE rep_assign='$wp_rep_id' AND dr_latitude!=''")or die(mysql_error());
$plotdf_res=mysql_fetch_array($plotpad);
$plotlisttr= $plotdf_res['plotdftot'];


$tplotpad=mysql_query("SELECT COUNT(*) AS tplotdftot FROM doctors WHERE rep_assign='$wp_rep_id' AND doc_contact_no!=''")or die(mysql_error());
$tplotdf_res=mysql_fetch_array($tplotpad);
$tplotlisttr= $tplotdf_res['tplotdftot'];









echo '[{"Total":"'.$totals.'"'.',"Totaldr":"'.$approveddocotr.'","meeting":"'.$meetingcount.'","phone":"'.$tplotlisttr.'","plotdr":"'.$plotlisttr.'","rxpad":"'.$rxpadlisttr.'","fav":"'.$favunapproveddocotr.'","unapproved":"'.$unapproveddocotr.''.'","workingdays":"'.$total.''.'","leave":"'.$leavescount.'"'.',"perf":"'.round($performance, 0).'"'.',"missed":"'.$missed.'"'.',"visited":"'.$visited.'"'.'}]';

?>