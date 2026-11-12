<?php
error_reporting(0);
include("include/connect.php");
$command=$_POST['command'];
if($command=='update_product')
{
$p_id=$_POST['p_id'];
$cnt=count($p_id);
$our_id=$_POST['our_id'];
for($i=0;$i<=$cnt;$i++)
{
    mysql_query("update dist_prod set our_id='$our_id[$i]' where id='$p_id[$i]'");
}


$a=mysql_query("select * from dist_prod where our_id!=''");
while($row_a=mysql_fetch_array($a))
{
    $p_id=$row_a['id'];
    $status=2;
    mysql_query("update dist_prod set status='$status' where id='$p_id'");
}
echo "<script type='text/javascript'>alert('Product Matched Successfully');window.location='upload_product.php';</script>";

}


if($command=='update_our_product')
{

$rtype = $_REQUEST['rtype'];	

if ($rtype == 'new_cust') 
{
$autoid = $_REQUEST['autoid'];
$custid = $_REQUEST['custid'];
$date = date('Y-m-d');
$time = date('H:i:s');
$pincodes = $_REQUEST['pincodes'];
$sal = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where shop_name = '$custid'");
$sal_row = mysql_fetch_array($sal);
$cout = mysql_num_rows($sal);
if ($cout>0) 
{
$our_cust_id = $sal_row['id'];
$rep_id = $sal_row['rep_id'];
$state_id = $sal_row['state_id'];
$district_id = $sal_row['district_id'];
$pin_id = $sal_row['pin_id'];
$pincode = $sal_row['pincode'];
$area_id = $sal_row['area_id'];


mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN ($autoid) ");

mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN ($autoid) ");

}
else 
{

$pins = mysql_query("SELECT * FROM  `pincode_list` WHERE  `pincode` =  '$pincodes' GROUP BY pincode");
$pins_row = mysql_fetch_array($pins);
$state_id = $pins_row['state_id'];
$district_id = $pins_row['dist_id'];
$pin_id = $pins_row['pin_id'];
$pincode = $pins_row['pincode'];
$area_id = $pins_row['id'];

$pinID = mysql_query("SELECT rep_id FROM `rep_area` WHERE `pin_id` = '$pin_id' GROUP BY `pin_id`");
$pinID_row = mysql_fetch_array($pinID);
$rep_id = $pinID_row['rep_id'];

mysql_query("INSERT INTO `tbl_customer_master`(`shop_name`,rep_id,state_id,district_id,pin_id,pincode,area_id,`c_date`, `c_time`) VALUES ('$custid','$rep_id','$state_id','$district_id','$pin_id','$pincode','$area_id','$date','$time')");
$our_cust_id = mysql_insert_id();

$sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$our_cust_id'");
$sala_row = mysql_fetch_array($sala);

$rep_id = $sala_row['rep_id'];
$state_id = $sala_row['state_id'];
$district_id = $sala_row['district_id'];
$pin_id = $sala_row['pin_id'];
$pincode = $sala_row['pincode'];
$area_id = $sala_row['area_id'];

mysql_query("update distributor_customer set our_cust_id='$our_cust_id',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN ($autoid) ");

mysql_query("update areawise_temp set our_cust_id='$our_cust_id',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN ($autoid)");


}

}

if ($rtype == 'exists') {
	
$autoid = $_REQUEST['autoid'];
$custid = $_REQUEST['custid'];

$sala = mysql_query("select id,`rep_id`, `state_id`, `district_id`, `pin_id`, `pincode`, `area_id` from tbl_customer_master where id = '$custid'");
$sala_row = mysql_fetch_array($sala);

$rep_id = $sala_row['rep_id'];
$state_id = $sala_row['state_id'];
$district_id = $sala_row['district_id'];
$pin_id = $sala_row['pin_id'];
$pincode = $sala_row['pincode'];
$area_id = $sala_row['area_id'];

mysql_query("update distributor_customer set our_cust_id='$custid',`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where id IN ($autoid) ");

mysql_query("update areawise_temp set our_cust_id='$custid',rep_id=$rep_id,`state_id`=$state_id,`district_id`=$district_id,`area_id`=$area_id,`pin_id`=$pin_id,`pincode`='$pincode' where dist_cust_id IN ($autoid) ");


}
}

if ($command == 'check_already') {
$pin = $_REQUEST['pincode'];
$ext = $_REQUEST['exists_name'];
$sals = mysql_query("select * from tbl_customer_master where shop_name = '$ext' and pincode = '$pin'");
$sals_row = mysql_fetch_array($sals);
$ss_num = mysql_num_rows($sals);
if ($ss_num > 0) { echo "1"; } else { echo "0"; }

}



if($command=='remove')
{
$did = $_REQUEST['dist'];
mysql_query("update distributor_customer set our_cust_id='' where id = $did");
// mysql_query("update areawise_temp set our_cust_id='' where dist_cust_id =$did");
}