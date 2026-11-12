<?php

include 'connect23.php';

$id = $_REQUEST['id'];
$date = $_REQUEST['date'];

$fromdate = explode('-', $date)[0].'-'.explode('-', $date)[1].'-01';

if($_REQUEST['status']<=1)
{
     $doc_count=" doctor_met_count = '".$_REQUEST['status']."' ";
}
else
{
     $doc_count=" doctor_met_count >= '2' ";
}

$outpu;
$outpu1;

echo '[';

$a = mysql_query("SELECT a.id,a.rep_name FROM representative a,assigningreptomanager b WHERE b.managerid='$id' AND a.id=b.repid ORDER BY rep_order ASC") or die(mysql_error());

while ($jj = mysql_fetch_array($a)) {
    $repname = $jj['rep_name'];
    $repidd = $jj['id'];


    $resultss = mysql_query("SELECT wp_id, count(wp_dc_id) as doctor_met_count FROM tbl_work_plan WHERE wp_rep_id='$repidd' AND wp_dc='D' AND wp_date LIKE  '%".$date."%' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_dc_id HAVING ".$doc_count."  ");
    $num_rowss = mysql_num_rows($resultss);

    $resultss1 = mysql_query("SELECT wp_id, count(wp_dc_id) as doctor_met_count FROM unapprovedtbl_work_plan WHERE wp_rep_id='$repidd' AND wp_dc='D' AND wp_date LIKE  '%".$date."%' AND attendancestatus='1' AND drunavailable='0' GROUP BY wp_dc_id HAVING ".$doc_count."");
    $num_rowss1 = mysql_num_rows($resultss1);

    $num_rowss = ($num_rowss + $num_rowss1);

    if ($num_rowss == '0') {
        $num_rowss = '0';
    } else {
        $repname = $repname;
        $num_rowss = $num_rowss;
    }

    $strSQL = "SELECT a.wp_id,a.drunavailable,a.jointworkby,a.drunavailablereason,a.latitude,a.longitude,GROUP_CONCAT(DATE_FORMAT(a.reporteddate, \"%D\")) as reporteddate,a.reportedtime,b.doctor_name,b.doc_pincode,b.doc_hospital_clinic_name,b.dr_latitude,b.dr_longitude,b.doc_contact_no,b.doc_specilist_id,b.doc_qualification,b.doctor_addrs,a.jointworkby,b.favourite,a.mtp,b.visitcardclinicphoto,b.swid, count(a.wp_dc_id) as doctor_met_count FROM tbl_work_plan a,doctors b WHERE a.wp_rep_id='$repidd' AND a.wp_dc='D' AND a.reporteddate LIKE  '%".$date."%' AND a.attendancestatus='1' AND a.drunavailable='0' AND a.wp_dc_id=b.id GROUP BY a.wp_dc_id HAVING ".$doc_count." ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";
    $objQuery = mysql_query($strSQL);

    $intNumField = mysql_num_fields($objQuery);

    $resultArray = array();

    if (mysql_num_rows($objQuery) > 0) {
        while ($obResult = mysql_fetch_array($objQuery)) {
            $arrCol = array();
            for ($i = 0; $i < $intNumField; ++$i) {
                if ($num_rowss == '0' && mysql_field_name($objQuery, $i) == 'drunavailablereason') {
                    $arrCol[mysql_field_name($objQuery, $i)] = '';
                } else {
                    $arrCol['approved'] = '0';
                    $arrCol[mysql_field_name($objQuery, $i)] = $obResult[$i];
                }
            }

            $arrCol['repnames'] = $repname.' - '.$num_rowss;

            $tbl2qq = mysql_query("SELECT GROUP_CONCAT(repid) AS repid FROM managerjoinworkplans WHERE `date` LIKE  '%".$date."%' AND managerid='$repidd'") or die(mysql_error());
            $tbl_res2qq = mysql_fetch_array($tbl2qq);

            $tbl2qq1 = mysql_query("SELECT GROUP_CONCAT(rep_name) AS rep_name FROM representative WHERE `id` IN ('".$tbl_res2qq['repid']."')") or die(mysql_error());
            $tbl_res2qq1 = mysql_fetch_array($tbl2qq1);

            $arrCol['jww'] = $tbl_res2qq1['rep_name'];
            array_push($resultArray, $arrCol);
        }
    } else {
        $arrCol1['repnames'] = $repname.'- 0';
        array_push($resultArray, $arrCol1);
    }

    if (strlen(json_encode($resultArray)) == 2) {
    } else {
        $result = substr(json_encode($resultArray), 1, -1);

        $outpu1 .= $result.',';
    }

    $strSQL1 = "SELECT a.wp_id,a.drunavailable,a.drunavailablereason,a.latitude,a.longitude,a.jointworkby,GROUP_CONCAT(DATE_FORMAT(a.reporteddate, \"%D\")) as reporteddate,a.reportedtime,b.doctor_name,b.doc_pincode,b.doc_hospital_clinic_name,b.dr_latitude,b.dr_longitude,b.doc_contact_no,b.doc_specilist_id,b.doc_qualification,b.doctor_addrs,a.jointworkby,b.favourite,a.mtp,b.visitcardclinicphoto,b.swid, count(a.wp_dc_id) as doctor_met_count FROM unapprovedtbl_work_plan a,unapproveddoctors b WHERE a.wp_rep_id='$repidd' AND a.wp_dc='D' AND a.reporteddate LIKE  '%".$date."%' AND a.attendancestatus='1' AND a.drunavailable='0' AND a.wp_dc_id=b.id GROUP BY a.wp_dc_id HAVING ".$doc_count." ORDER BY STR_TO_DATE(reportedtime,'%h:%i:%s  %p')";

    $objQuery1 = mysql_query($strSQL1);
    $intNumField = mysql_num_fields($objQuery1);

    $resultArray1 = array();
    if (mysql_num_rows($objQuery1) > 0) {
        while ($obResult1 = mysql_fetch_array($objQuery1)) {
            $arrCol = array();
            for ($i = 0; $i < $intNumField; ++$i) {
                if ($num_rowss == '0' && mysql_field_name($objQuery1, $i) == 'drunavailablereason') {
                    $arrCol[mysql_field_name($objQuery1, $i)] = '';
                } else {
                    $arrCol['approved'] = '1';
                    $arrCol[mysql_field_name($objQuery1, $i)] = $obResult1[$i];
                }

                //$arrCol[mysql_field_name($objQuery1,$i)] = $obResult1[$i];
            }

            $arrCol['repnames'] = $repname.' - '.$num_rowss;

            $tbl2qq = mysql_query("SELECT GROUP_CONCAT(repid) AS repid FROM managerjoinworkplans WHERE `date` LIKE  '%".$date."%' AND managerid='$repidd'") or die(mysql_error());
            $tbl_res2qq = mysql_fetch_array($tbl2qq);

            $tbl2qq1 = mysql_query("SELECT GROUP_CONCAT(rep_name) AS rep_name FROM representative WHERE `id` IN ('".$tbl_res2qq['repid']."')") or die(mysql_error());
            $tbl_res2qq1 = mysql_fetch_array($tbl2qq1);

            $arrCol['jww'] = $tbl_res2qq1['rep_name'];

            array_push($resultArray1, $arrCol);
        }
    } else {
        $arrCol1['repnames'] = $repname.'- 0';
        array_push($resultArray, $arrCol1);
    }
    if (strlen(json_encode($resultArray1)) == 2) {
    } else {
        $result1 = substr(json_encode($resultArray1), 1, -1);

        $outpu1 .= $result1.',';
    }
}

if (strlen(json_encode($result)) > 2) {
    $outpu = substr($outpu1, 0, -1);
    echo $outpu;
    echo ']';
}
