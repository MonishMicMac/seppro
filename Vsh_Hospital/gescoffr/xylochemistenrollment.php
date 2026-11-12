<?php
include("connect1.php");
$shop_name=$_REQUEST['shop_name'];
$owner_name=$_REQUEST['owner_name'];
$rep_id=$_REQUEST['rep_id'];
$pin_id=$_REQUEST['pin_id'];
$pincode=$_REQUEST['pincode'];
$mobile_no=$_REQUEST['mobile_no'];




 $jjxx = mysql_query("SELECT * FROM tbl_customer_master WHERE shop_name= '$shop_name' AND owner_name= '$owner_name' AND rep_id= '$rep_id' AND mobile_no='$mobile_no' AND pin_id='$pin_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into tbl_customer_master(shop_name,owner_name,rep_id,pin_id,pincode,mobile_no)values('$shop_name','$owner_name','$rep_id','$pin_id','$pincode','$mobile_no')")or die(mysql_error());
}





?>
