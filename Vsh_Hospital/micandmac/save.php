<?php
error_reporting(0);
include('../include/connect.php');
	$command=$_POST['command'];
	if($command=="site_conf")
	{
	$c_date=date("d-m-Y");
	
	$timezone = new DateTimeZone("Asia/Kolkata" );
	$date = new DateTime();
	$date->setTimezone($timezone );
	$ss=$date->format( 'G:i:s' );
	
	$sel=mysql_query("select * from site_conf");
	$sel_num=mysql_num_rows($sel);
	if($sel_num>0)
	{
	$rr=mysql_fetch_array($sel);
	$u_id=$rr['id'];
	$logo=$rr['logo'];
	$favicon=$rr['favicon'];
	
	$random_no=rand(100000000,999999999);
	$ans01=$_FILES['logo']['name'];
	if(!empty($ans01))
	{	
	$target_path = "../logo/";
	$uploaded_ans4=$random_no."_".$_FILES['logo']['name'];
	move_uploaded_file($_FILES['logo']['tmp_name'], $target_path . $random_no."_".$_FILES['logo']['name']);
	unlink("../logo/".$logo);
	}
	else
	{
	$uploaded_ans4=$logo;
	}
	$logo_name=mysql_real_escape_string($uploaded_ans4);
	$random_no1=rand(100000000,999999999);
	$ans011=$_FILES['favicon']['name'];
	if(!empty($ans011))
	{	
	$target_path1 = "../favicon/";
	$uploaded_ans=$random_no1."_".$_FILES['favicon']['name'];
	move_uploaded_file($_FILES['favicon']['tmp_name'], $target_path1 . $random_no1."_".$_FILES['favicon']['name']);
	unlink("../favicon/".$favicon);
	}
	else
	{
	$uploaded_ans=$favicon;
	}
	$favicon_name=mysql_real_escape_string($uploaded_ans);
	$footer=mysql_real_escape_string($_POST['footer']);
	
	//echo "update site_conf set logo='$logo_name',favicon='$favicon_name',footer='$footer',id_key='$id_key',c_date='$c_date',c_time='$ss' where id='$u_id'";exit;
	mysql_query("update site_conf set logo='$logo_name',favicon='$favicon_name',footer='$footer',c_date='$c_date',c_time='$ss' where id='$u_id'")or die(mysql_error());
	echo "<script type=text/javascript>alert('Site Configuration updated Successfully');window.location='site_config.php';</script>";
	}
	else
	{
	
	$random_no=rand(100000000,999999999);
	$ans01=$_FILES['logo']['name'];
	if(!empty($ans01))
	{	
	$target_path = "../logo/";
	$uploaded_ans4=$random_no."_".$_FILES['logo']['name'];
	move_uploaded_file($_FILES['logo']['tmp_name'], $target_path . $random_no."_".$_FILES['logo']['name']);
	}
	$random_no1=rand(100000000,999999999);
	$ans011=$_FILES['favicon']['name'];
	if(!empty($ans011))
	{	
	$target_path1 = "../favicon/";
	$uploaded_ans=$random_no1."_".$_FILES['favicon']['name'];
	move_uploaded_file($_FILES['favicon']['tmp_name'], $target_path1 . $random_no1."_".$_FILES['favicon']['name']);
	}
	$footer=mysql_real_escape_string($_POST['footer']);

	mysql_query("insert into site_conf(logo,favicon,footer ,c_date,c_time)values('$uploaded_ans4','$uploaded_ans','$footer','$c_date','$ss')")or die(mysql_error());
	
	echo "<script type=text/javascript>alert('Site Configuration Inserted Successfully');window.location='site_config.php';</script>";
	}
	
	
	

	}
	else if($command=="add_admin")
	{
	$name=$_POST['name'];
	
	
	$mobile=$_POST['mobile'];
	$alt_no=$_POST['alt_no'];
	$address=mysql_real_escape_string($_POST['address']);
	$u_name=$_POST['u_name'];
	$pass=$_POST['pass'];
	$authority=$_POST['authority'];
	mysql_query("insert into admin(name,mobile,alt_no,address,u_name,pass,authority)values('$name','$mobile','$alt_no','$address','$u_name','$pass','$authority')")or die(mysql_error());
	echo "<script type=text/javascript>alert('Admin Inserted Successfully');window.location='add_admin.php';</script>";
	}
	else if($command=="change_pass")
{

    $c_pass=$_POST['c_pass'];	
	$n_pass=$_POST['n_pass'];
	$user_id=$_POST['user_id'];
	mysql_query("update login set password='$n_pass' where id='$user_id' and password='$c_pass'");
	echo "<script type='text/javascript'>alert('Your password Changed Successfully');window.location.href='change_pass.php';</script>";
}


//-------------------------------------
//update comand
//-------------------------------//
else if($command=="edit_admin")
{
$a_id=$_POST['a_id'];
$name=$_POST['name'];
$mobile=$_POST['mobile'];
$alt_no=$_POST['alt_no'];
$address=mysql_real_escape_string($_POST['address']);
$authority=$_POST['authority'];
$pass=$_POST['pass']; 
mysql_query("update  admin set name='$name',mobile='$mobile',alt_no='$alt_no',address='$address',pass='$pass',authority='$authority' where  id='$a_id' ");
echo "<script type=text/javascript>alert('Details Edited Successfully');window.location='add_admin.php';</script>";
}
else if($command=="add_mark")
{
$mark_name=$_POST['mark_name'];
$mark_id=$_POST['mark_id'];
$mark_abb=$_POST['mark_abb'];
$email=$_POST['email'];
$cp_name=$_POST['cp_name'];
$cp_no=$_POST['cp_no'];
$alternate_no1=$_POST['alternate_no1'];
$alternate_no2=$_POST['alternate_no2'];
$fax_no=$_POST['fax_no'];
$reg_addr=mysql_real_escape_string($_POST['reg_addr']);
$reg_addr1=mysql_real_escape_string($_POST['reg_addr1']);
$reg_area=$_POST['reg_area'];
$reg_pin=$_POST['reg_pin'];
$corp_addr=mysql_real_escape_string($_POST['corp_addr']);
$corp_addr1=mysql_real_escape_string($_POST['corp_addr1']);
$corp_area=$_POST['corp_area'];
$corp_pin=$_POST['corp_pin'];
$c_date=date('d-m-Y');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );

$ff=mysql_query("select * from admin where authority='2' order by id desc");
$count_ff=mysql_num_rows($ff);
if($count_ff>0)
{
$row_ff=mysql_fetch_array($ff);
$pass=$row_ff['pass'];
}
else
{
$pass="12345";
}

mysql_query("insert into marketer(mark_name,mark_id,mark_abb,reg_addr,reg_addr1,reg_area,reg_pin,corp_addr,corp_addr1,corp_area,corp_pin,cp_name ,cp_no,alternate_no1,alternate_no2,email,fax_no,c_date,c_time)values('$mark_name','$mark_id','$mark_abb','$reg_addr','$reg_addr1','$reg_area','$reg_pin','$corp_addr','$corp_addr1','$corp_area','$corp_pin','$cp_name','$cp_no','$alternate_no1','$alternate_no2','$email','$fax_no','$c_date','$c_time')");

mysql_query("insert into admin(u_name,pass,authority)values('$mark_id','$pass','2')");

$ff1=mysql_query("select * from admin_details  order by id desc");
$count_ff1=mysql_num_rows($ff1);
if($count_ff1>0)
{
$row_ff1=mysql_fetch_array($ff1);
$pass2=$row_ff1['admin_id'];
$pass1=$pass2+1;
}
else
{
$pass1="50001";
}

mysql_query("insert into admin_details(m_id16,admin_id,c_date,c_time)values('$mark_id','$pass1','$c_date','$c_time')");

mysql_query("insert into admin(u_name,pass,authority)values('$mark_id','12345','1')");

echo "<script type=text/javascript>alert('marketer Details added Successfully');window.location='add_marketer.php';</script>";
}
?>

