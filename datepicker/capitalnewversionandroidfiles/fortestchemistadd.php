<?php

include("connect23.php"); 

$shop_name=$_REQUEST['shop_name'];
$owner_name=$_REQUEST['owner_name'];
$rep_id=$_REQUEST['rep_id'];
$pin_id=$_REQUEST['pin_id'];
$pincode=$_REQUEST['pincode'];
$mobile_no=$_REQUEST['mobile_no'];
$customer_address=$_REQUEST['customer_address'];

$state_id=$_REQUEST['state_id'];




 $jjxx = mysql_query("SELECT * FROM tbl_customer_master WHERE shop_name= '$shop_name' AND owner_name= '$owner_name' AND rep_id= '$rep_id' AND mobile_no='$mobile_no' AND pin_id='$pin_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$pincode1=trim($pincode);
$sql=mysql_query("SELECT id,dist_id FROM pincode_list WHERE pincode='$pincode1' order by id asc limit 1");
$row=mysql_fetch_array($sql);

$jjsdzz = mysql_query("insert into tbl_customer_master(shop_name,owner_name,rep_id,pin_id,pincode,mobile_no,customer_address,area_id,district_id,state_id)values('$shop_name','$owner_name','$rep_id','$pin_id','$pincode','$mobile_no','$customer_address','".$row['id']."','".$row['dist_id']."','$state_id')")or die(mysql_error());
}





?>