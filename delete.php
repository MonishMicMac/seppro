<?php
include("include/connect.php");
require_once("include/select.php");
include("encrypt.php");
$ad=new select1();
$comm=$_REQUEST['comm'];
if(isset($_REQUEST['d_id']))
{
   $d_id=$_REQUEST['d_id'];   
}
if($comm=='distributor')
{
$dis_del=$ad->delete('distributor','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Distributor Deleted Successfully');window.location='view_distributor.php';</script>";
}
if($comm=='marketer')
{
$res=$ad->view('marketer','where id='.$d_id,'');
$row_res=mysql_fetch_array($res);
$mark_id=$row_res['mark_id'];
$mark_product=$ad->delete('product','where mark_id='.$mark_id,'');
$mark_del_under=$ad->delete('under_marketer','where mark_id='.$mark_id,'');
$mark_del=$ad->delete('marketer','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Marketer Deleted Successfully');window.location='view_marketer.php';</script>";
}
if($comm=='representative')
{
$dis_del=$ad->delete('representative','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Representative Deleted Successfully');window.location='view_representative.php';</script>";
}
if($comm=='representative_pon')
{
 mysql_query("UPDATE representative SET delete_status='1' WHERE id = '".$d_id."'") or die(mysql_error());
echo "<script type='text/javascript'>alert('Representative Deleted Successfully');window.location='view_representative_pon.php';</script>";
}
if($comm=='twp_delete')
{
$dis_del=$ad->delete('tbl_work_plan','where wp_id='.$d_id,'');
echo "<script type='text/javascript'>alert('Representative Deleted Successfully');window.location='monthly_fullcalendar.php';</script>";
}
if($comm=='twp_add')
{    
mysql_query("INSERT INTO tbl_work_plan(wp_date,wp_dc_id,wp_rep_id,wp_dc,c_date,c_time)VALUES('".$_REQUEST['dateid']."','".$d_id."','".$_REQUEST['rpid']."','D','". date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error()); 
echo "<script type='text/javascript'>alert('Representative Deleted Successfully');window.location='monthly_fullcalendar.php';</script>";
}
if($comm=='product')
{
$dis_del=$ad->delete('product','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Product Deleted Successfully');window.location='view_product.php';</script>";
}
if($comm=='product_anderson')
{
$dis_del=$ad->delete('product','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Product Deleted Successfully');window.location='view_product_anderson.php';</script>";
}
if($comm=='pincode')
{
$dis_del=$ad->delete('pincode_list','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Pincode Deleted Successfully');window.location='view_pincode.php';</script>";
}
if($comm=='customer')
{
$dis_del=$ad->delete('customer','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Customer Deleted Successfully');window.location='view_customer.php';</script>";
}


if($comm=='invalid')
{

mysql_query("delete from temp_table where pincode='$d_id'");
echo "<script type='text/javascript'>alert('Pincode Deleted Successfully');window.location='view_invalidpin.php';</script>";
}
if($comm=='dist')
{
$dis_del=$ad->delete('dist_prod','where id='.$d_id,'');
echo "<script type='text/javascript'>alert('Product  Deleted Successfully');window.location='upload_product.php';</script>";
}

if($comm=='doctor')
{
    $d_id=decrypt($_REQUEST['d_id']);
    $ad->delete('doctors','where id='.$d_id,'');     
    echo "<script type='text/javascript'>alert('Doctor  Deleted Successfully');window.location='view_doctor.php';</script>";
}

if($comm=='cust')
{

    $ted=$_REQUEST['c_id'];
    $resew=mysql_query("DELETE FROM `tbl_customer_master` WHERE id = '$ted'");

    // print_r($resew);exit();

    // $c_id=decrypt($_REQUEST['c_id']);
    // $ad->delete('tbl_customer_master','where id='.$c_id.'');     
    echo "<script type='text/javascript'>alert('Customer  Deleted Successfully');window.location='view_customer.php';</script>";
}


if($comm === 'manager')
{
    $id=$_REQUEST['m_id'];
    $ad->delete('managers','where id='.$id,''); 
    echo "<script type='text/javascript'>alert('Manager  Deleted Successfully');window.location='view_managers.php';</script>";
}


if($comm === 'del_un_mat')
{
    mysql_query("Delete from unmat_tble_customer_master where mat_status='1'")or die(mysql_error());
    echo "UnMatched Customer Deleted Sucessfully";
}