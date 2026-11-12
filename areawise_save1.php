<?php
error_reporting(0);
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 15000);

include("include/connect.php");
require_once("include/select.php");

$command=$_REQUEST['command'];
$c_date=date('Y-m-d');
date_default_timezone_set('Asia/Kolkata');
$date = new DateTime();
$c_time=$date->format( 'H:i:s A' );
$ip_addr=$_SERVER['REMOTE_ADDR']; 
$cur_year=date('Y');
include 'excel_reader.php';
$excel = new PhpExcelReader;
$m_id16=$_REQUEST['m_id16'];
$dist_id=$_REQUEST['dist_id'];
$date_format=$_REQUEST['date_format'];
$rec_id=$_REQUEST['rec_id'];








$z=mysql_query("select * from areawise_temp where  m_id16='$m_id16' and dist_id='$dist_id' and c_date='$c_date' and record_id='$rec_id'");
while($row_z=mysql_fetch_array($z))
{
$z_id_b=$row_z['id'];
$dc_id=$row_z['cust_id'];
$pro_id_b=$row_z['pro_id'];

$bill_date1=$row_z['bill_date'];	
if($date_format=='1')
{
$new_cat1=explode('-',$bill_date1);
$date1=$new_cat1[0];
$month1=$new_cat1[1];
$year1=$new_cat1[2];
$our_year1="20".$year1;
$bill_date_proper=$our_year1.'-'.$month1.'-'.$date1;
$bill_date_string=strtotime($bill_date_proper);
}
if($date_format=='2')
{

$new_cat2=explode('-',$bill_date1);
$date2=$new_cat2[0];
$month2=$new_cat2[1];
$year2=$new_cat2[2];
$bill_date_proper=$year2.'-'.$month2.'-'.$date2;
$bill_date_string=strtotime($bill_date_proper);

}
if($date_format=='3')
{
$new_cat3=explode('-',$bill_date1);
$date3=$new_cat3[2];
$month3=$new_cat3[1];
$year3=$new_cat3[0];
$our_year3="20".$year3;
$bill_date_proper=$our_year3.'-'.$month3.'-'.$date3;
$bill_date_string=strtotime($bill_date_proper);


}
if($date_format=='4')
{
$new_cat4=explode('-',$bill_date1);
$date4=$new_cat4[2];
$month4=$new_cat4[1];
$year4=$new_cat4[0];
$bill_date_proper=$year4.'-'.$month4.'-'.$date4;
$bill_date_string=strtotime($bill_date_proper);
}

if($date_format=='5')
{
$new_cat1=explode('/',$bill_date1);
$date1=$new_cat1[0];
$month1=$new_cat1[1];
$year1=$new_cat1[2];
$our_year1="20".$year1;
$bill_date_proper=$our_year1.'-'.$month1.'-'.$date1;
$bill_date_string=strtotime($bill_date_proper);
}
if($date_format=='6')
{

$new_cat2=explode('/',$bill_date1);
$date2=$new_cat2[0];
$month2=$new_cat2[1];
$year2=$new_cat2[2];
$bill_date_proper=$year2.'-'.$month2.'-'.$date2;
$bill_date_string=strtotime($bill_date_proper);

}
if($date_format=='7')
{
$new_cat3=explode('/',$bill_date1);
$date3=$new_cat3[2];
$month3=$new_cat3[1];
$year3=$new_cat3[0];
$our_year3="20".$year3;
$bill_date_proper=$our_year3.'-'.$month3.'-'.$date3;
$bill_date_string=strtotime($bill_date_proper);


}
if($date_format=='8')
{
$new_cat4=explode('-',$bill_date1);
$date4=$new_cat4[2];
$month4=$new_cat4[1];
$year4=$new_cat4[0];
$bill_date_proper=$year4.'-'.$month4.'-'.$date4;
$bill_date_string=strtotime($bill_date_proper);
}




$sa=mysql_query("select * from dist_prod where pro_id='$pro_id_b' and dist_id='$dist_id' and mark_id='$m_id16' and our_id!=''");
$count_sa=mysql_num_rows($sa);
if($count_sa>0)
{
$row_sa=mysql_fetch_array($sa);
$our_id=$row_sa['our_id'];
}
else
{
$our_id="";
mysql_query("insert into invalid_prod(mark_id,dist_id,r_id)values('$m_id16','$dist_id','$z_id_b')");
}

$pincode12=$row_z['pincode'];
$d=mysql_query("select * from pincode_list where pincode='$pincode12'");
$num_d=mysql_num_rows($d);
if($num_d>0)
{
$row_d=mysql_fetch_array($d);
$d_id=$row_d['id'];
}
else
{
mysql_query("insert into invallid_pin(mark_id,dist_id,r_id)values('$m_id16','$dist_id','$z_id_b')");
}
  
  
  
$e=mysql_query("select * from customer where dc_id='$dc_id' and distrib_id='$dist_id' and mark_id='$m_id16'");
$num_e=mysql_num_rows($e);
if($num_e>0)
{
$row_e=mysql_fetch_array($e);
$e_id=$row_e['id'];
}
else
{
mysql_query("insert into invallid_cust(mark_id,dist_id,r_id)values('$m_id16','$dist_id','$z_id_b')");
}
  

mysql_query("update  areawise_temp set   bill_date='$bill_date_proper',bill_string='$bill_date_string',our_id='$our_id'  where id='$z_id_b'");
}

$i=mysql_query("select * from invallid_pin order by id desc");
$count_i=mysql_num_rows($i);
if($count_i>0)
{
while($row_i=mysql_fetch_array($i))
{
$r_id1=$row_i['r_id'];
$dist_id1=$row_i['dist_id'];
$mark_id1=$row_i['mark_id'];


/*$g1=mysql_query("select * from invalid_total where r_id='$r_id1' and status1='1'");
$count_g1=mysql_num_rows($g1);
if($count_g1>0)
{

}
else
{*/
mysql_query("insert into invalid_total(record_id,mark_id,dist_id,r_id,status1,c_date,c_time)values('$rec_id','$mark_id1','$dist_id1','$r_id1',1,'$c_date','$c_time')");
/*}*/




mysql_query("update  areawise_temp set  invalid_pin='1'  where id='$r_id1'");
}
}


$j=mysql_query("select * from invallid_cust order by id desc");
$count_j=mysql_num_rows($j);
if($count_j>0)
{
while($row_j=mysql_fetch_array($j))
{
$r_id2=$row_j['r_id'];
$dist_id2=$row_j['dist_id'];
$mark_id2=$row_j['mark_id'];
mysql_query("insert into invalid_total(record_id,mark_id,dist_id,r_id,status2,c_date,c_time)values('$rec_id','$mark_id2','$dist_id2','$r_id2',1,'$c_date','$c_time')");
mysql_query("update  areawise_temp set  invalid_cust='1'  where id='$r_id2'");
}
}


$k=mysql_query("select * from invalid_prod order by id desc");
$count_k=mysql_num_rows($k);
if($count_k>0)
{
while($row_k=mysql_fetch_array($k))
{
$r_id3=$row_k['r_id'];
$dist_id3=$row_k['dist_id'];
$mark_id3=$row_k['mark_id'];

mysql_query("insert into invalid_total(record_id,mark_id,dist_id,r_id,status3,c_date,c_time)values('$rec_id','$mark_id3','$dist_id3','$r_id3',1,'$c_date','$c_time')");
mysql_query("update  areawise_temp set  invalid_prod='1'  where id='$r_id3'");
}
}


mysql_query("delete from invalid_prod");
mysql_query("delete from invallid_cust");
mysql_query("delete from invallid_pin");

 echo "<script type=text/javascript>alert('Updated');window.location='upload_areawise.php';</script>";


?>