<?php
include("include/connect.php");
session_start();
date_default_timezone_get();
date_default_timezone_set('Asia/Kolkata');

$from_date=date('Y-m', strtotime("+1 month", strtotime(date('Y-m'))))."-01";
$last_date=cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($from_date)),date("Y",strtotime($from_date)));

$sql=mysql_query("SELECT id FROM representative WHERE id IN (select wp_rep_id from mst_tour_plan)");
while($row=mysql_fetch_array($sql)){
    $rep_id=$row['id'];
    mysql_query("DELETE FROM tbl_work_plan WHERE wp_rep_id='$rep_id' AND wp_date>='$from_date'");

    $sql_g=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='$rep_id' ORDER BY id DESC LIMIT 1");
    $row_g=mysql_fetch_array($sql_g);
    $last_date1=$row_g['last_date'];
    $last_day=substr($row_g['last_day'], -1);

    if($last_day!=''){
        $next_first_date=$from_date;
        $prev_first_date='';

        $d=1;
        while ($prev_first_date < $next_first_date) {
            $prev_day=date('l', strtotime($last_date1 . ' +'.$d.' day'));
            if($prev_day=='Sunday'){
                if($last_day==1){
                    $last_day='2';
                } elseif($last_day==2){
                    $last_day='1';
                }
            }
            $prev_first_date=date('Y-m-d', strtotime($last_date1 . ' +'.$d.' day'));
            $d++;
        }
    } else {
        $last_day=1;
    }


    $sql1=mysql_query("SELECT id,doctor_name FROM doctors WHERE rep_id='$rep_id' ORDER BY doctor_name ASC");
    while ($row1=mysql_fetch_array($sql1)) {
        $last=$last_day;
        for ($i=1; $i <= $last_date; $i++) {
            if($i<10){
                $h='0'.$i;
            } else {
                $h=$i;
            }
            $date1=date("Y-m",strtotime($from_date)).'-'.$h;

            $day=date('l',strtotime($date1));

            if($day=='Sunday' && $h!='1'){
                if($last=='1'){
                    $last=2;
                } elseif($last=='2'){
                    $last=1;
                }
            }

            $value='';
            if($day!='Sunday'){
                if($date1>date('Y-m-d')){
                    $week_day=$day.$last;
                    $sql2=mysql_query("SELECT count(*) as cnt FROM mst_tour_plan WHERE wp_day='$week_day' AND wp_rep_id='$rep_id' AND wp_dc_id='".$row1['id']."'");
                    $row2=mysql_fetch_array($sql2);
                    if($row2['cnt']>0){
                        $wp_dc_id=$row1['id'];
                            mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc,wp_dc_id,wp_rep_id,mtp,c_date,c_time)VALUES('$date1','D','$wp_dc_id','$rep_id','1',CURDATE(),CURTIME())");
                    }
                }
            }
        }
    }

    $sql_chk=mysql_query("SELECT * FROM mst_tour_plan WHERE wp_rep_id='$rep_id' ORDER BY id DESC LIMIT 1");
    $row_chk=mysql_fetch_array($sql_chk);
    if($row_chk['last_date']=='0000-00-00' && $row_chk['last_day']==''){
        $date2 = new DateTime($date1);
        $date2->modify("last day of previous month");
        $date3=$date2->format("Y-m-d");
        if($date2->format("l")=='Saturday'){
            $day2=$date2->format("l").'2';
        } else {
            $day2=$date2->format("l").'1';
        }
    }
}
?>
