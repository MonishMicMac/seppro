<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='admin_password')
{
$autho=$_POST['autho'];
$n_pass=mysql_real_escape_string($_POST['n_pass']);
mysql_query("update admin set pass='$n_pass' where authority='$autho'");

echo "<script type=text/javascript>alert('Your Password Changed.Your New Password is : $n_pass');window.location='admin_password.php';</script>";
}

if($command=='clear_error')
{
$m_id16=$_POST['m_id16'];
$new_pincode=$_POST['new_pincode'];
$old_pincode=$_POST['old_pincode'];
$optionsRadios=$_POST['optionsRadios'];
$state_name=$_POST['state_name'];
$dist_id=$_POST['dist_id'];
$area_name=$_POST['area_name'];
$c_date=date('d-m-Y');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
if($state_name!='' && $dist_id!='' & $area_name!='')
{
$c1=mysql_query("select * from district where id='$dist_id'");
$row_c1=mysql_fetch_array($c1);
$city_name=$row_c1['dist_name'];
if($optionsRadios=='1')
{
/******************Pincode and Customer insert start*******************************/
mysql_query("insert into pincode_list(state_name,dist_id,area_name,pincode,c_date,c_time)values('$state_name','$dist_id','$area_name','$new_pincode','$c_date','$c_time')");
$last_id=mysql_insert_id();
$r=mysql_query("select * from temp_table where pincode='$old_pincode'");
$count_r=mysql_num_rows($r);
while($row_r=mysql_fetch_array($r))
{
$cust_name=mysql_real_escape_string($row_r['cust_name']);
$dc_id=$row_r['dc_id'];
$distrib_id=$row_r['distrib_id'];
$mark_id=$row_r['mark_id'];
$t_id=$row_r['id'];

$res=mysql_query("select * from customer order by id desc");
$res1=mysql_num_rows($res);
if($res1>0)
{
$row_dis=mysql_fetch_array($res);
$cus_no=$row_dis['cust_id'];
$cus_next=$cus_no+1;
}
if($res1=='0')
{
$cus_next=100001;
}

mysql_query("insert into customer(mark_id,cust_name,distrib_id,dc_id,cust_id,dist_id,state_name,dist_name,area_id,area_name,pincode,c_date,c_time)values('$mark_id','$cust_name','$distrib_id','$dc_id','$cus_next','$dist_id','$state_name','$city_name','$last_id','$area_name','$new_pincode','$c_date','$c_time')");

mysql_query("delete from temp_table where id='$t_id'");
echo "<script type=text/javascript>alert('Pincode and Customer Names Updated in Database');window.location='view_invalidpin.php';</script>";
}
/******************Pincode insert End*******************************/

}
if($optionsRadios=='2')
{
mysql_query("insert into pincode_list(state_name,dist_id,area_name,pincode,c_date,c_time)values('$state_name','$dist_id','$area_name','$new_pincode','$c_date','$c_time')");

echo "<script type=text/javascript>alert('Pincode  Updated in Database');window.location='view_invalidpin.php';</script>";
}


}
else
{

if($optionsRadios=='1')
{
$r12=mysql_query("select * from temp_table where pincode='$old_pincode'");
$count_r12=mysql_num_rows($r12);
while($row_r12=mysql_fetch_array($r12))
{
$cust_name=mysql_real_escape_string($row_r12['cust_name']);
$dc_id=$row_r12['dc_id'];
$distrib_id=$row_r12['distrib_id'];
$mark_id=$row_r12['mark_id'];
$t_id=$row_r12['id'];

$res12=mysql_query("select * from customer order by id desc");
$res112=mysql_num_rows($res12);
if($res112>0)
{
$row_dis12=mysql_fetch_array($res12);
$cus_no=$row_dis12['cust_id'];
$cus_next=$cus_no+1;
}
if($res112=='0')
{
$cus_next=100001;
}
$ht=mysql_query("select * from pincode_list where pincode='$new_pincode'");
$row_ht=mysql_fetch_array($ht);
$area_id=$row_ht['id'];
$area_name=$row_ht['area_name'];
$dist_id=$row_ht['dist_id'];
$state_name=$row_ht['state_name'];
$ht1=mysql_query("select * from district where id='$dist_id'");
$row_ht1=mysql_fetch_array($ht1);
$dist_name=$row_ht1['dist_name'];

mysql_query("insert into customer(mark_id,cust_name,distrib_id,dc_id,cust_id,dist_id,state_name,dist_name,area_id,area_name,pincode,c_date,c_time)values('$m_id16','$cust_name','$distrib_id','$dc_id','$cus_next','$dist_id','$state_name','$dist_name','$area_id','$area_name','$new_pincode','$c_date','$c_time')");

mysql_query("delete from temp_table where id='$t_id'");

echo "<script type=text/javascript>alert('Customer Names Updated in Database');window.location='view_invalidpin.php';</script>";

}

}

if($optionsRadios=='2')
{

echo "<script type=text/javascript>alert('No Changes Made!.');window.location='view_invalidpin.php';</script>";
}






}
}



if($command=='rep_password')
{
$user_id=$_POST['user_id'];
$n_pass=mysql_real_escape_string($_POST['n_pass']);

mysql_query("update admin set pass='$n_pass' where id='$user_id'");
echo "<script type=text/javascript>alert('Your Password Changed.Your New Password is : $n_pass');window.location='change_password.php';</script>";
}


if($command=='edit_admin')
{
$m_id16=$_POST['m_id16'];
$name=$_POST['name'];
$mobile=$_POST['mobile'];
$email=$_POST['email'];
$address=mysql_real_escape_string($_POST['address']);

mysql_query("update admin_details set name='$name',contact_no='$mobile',email='$email',address='$address' where m_id16='$m_id16'");

echo "<script type=text/javascript>alert('CEO details Updated');window.location='add_admin.php';</script>";
}
?>