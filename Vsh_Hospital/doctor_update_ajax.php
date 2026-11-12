<?php
include("include/connect.php");
session_start();
error_reporting(0);

 if($_REQUEST['doctor']=='up')
         {
         	// echo "update doctors set tray_details='".$_REQUEST['tray']."',cares='".$_REQUEST['cares']."',values_info='".$_REQUEST['values_info']."' where id='".$_REQUEST['doctor_id']."'";
         	// echo "update tbl_work_plan set tray_details='".$_REQUEST['tray']."',cares='".$_REQUEST['cares']."',values_info='".$_REQUEST['values_info']."' where wp_id='".$_REQUEST['doctor_id']."'";
       $update=mysql_query("update tbl_work_plan set tray_details='".$_REQUEST['tray']."',cares='".$_REQUEST['cares']."',values_info='".$_REQUEST['values_info']."' where wp_id='".$_REQUEST['doctor_id']."'");
       if($update)
       {
        echo "success";
       }
       }?>