<?php
include("connect.php");
print_r('hgfh');exit();
error_reporting(0);
session_start();

$id=$_SESSION['id'];

// $_REQUEST['id']; 
$rep_id=$_REQUEST['representative'];
// print_r($rep_id);exit();
$birthday=$_REQUEST['birthday'];
$remark=$_REQUEST['remark'];
$date=date('Y-m-d');
$rr='1';
$rr='1';


$res=$_REQUEST['id'];
// print_r($res);exit();

$rep_daily=mysql_query("SELECT telecaller_assign_manager.*,telecaller_assign_manager.assigned_to as ass,mst_customer_mapping.*,assign_mapping.*,incharge.inchargename as name,incharge.inchargetype as type FROM telecaller_assign_manager 
LEFT JOIN mst_customer_mapping on mst_customer_mapping.user_id=telecaller_assign_manager.bde_id
LEFT JOIN incharge on incharge.mst_id=mst_customer_mapping.id
LEFT JOIN assign_mapping on assign_mapping.bde_id=mst_customer_mapping.user_id



 WHERE mst_customer_mapping.id=$res ");
// }
// print_r($rep_daily);exit();
	$REPDAILY=mysql_fetch_object($rep_daily);

    // print_r($REPDAILY);exit();
    $incharge_id=$REPDAILY->incharge_id;
    $site_id=$REPDAILY->site_id;

    $bde_id=$REPDAILY->bde_id;
    $telecaller_id=$REPDAILY->telecaller_id;
    // print_r($telecaller_id);exit();
    $status_id=$REPDAILY->status_id;
    $report_status=$REPDAILY->report_status;
  

        // print_r($REPDAILY);exit();
    

// $m_id16=$_SESSION['m_id16'];
$remark=$_REQUEST['remark'];
// exit();

$data = mysql_query("INSERT INTO telecaller_assign_manager(incharge_id,site_id,bde_id,telecaller_id,status_id,report_status,followup_date,feedback,c_date) 
VALUES('$incharge_id','$res','$bde_id','$telecaller_id','$rr','$rr','$birthday','$remark','$date')")or die(mysql_error());


	// $data=	mysql_query("");

	echo "<script>alert('Add Successfully');window.location='../telecaller_followup.php';</script>";
	// print_r($data);exit();
	?>

<?php

?>
