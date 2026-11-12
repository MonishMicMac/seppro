<?php

include("connect1.php");
$shop_name=$_REQUEST['shop_name'];
$owner_name=$_REQUEST['owner_name'];
$rep_id=$_REQUEST['rep_id'];
$pin_id=$_REQUEST['pin_id'];
$pincode=$_REQUEST['pincode'];
$mobile_no=$_REQUEST['mobile_no'];
$customer_address=$_REQUEST['customer_address'];




 $jjxx = mysql_query("SELECT * FROM Hospitalname WHERE hos_name= '$shop_name' AND designation= '$owner_name' AND rep_id= '$rep_id' AND mobile_no='$mobile_no' AND pin_id='$pin_id'")or die(mysql_error());
      $jjxx_count = mysql_num_rows($jjxx);
     if($jjxx_count > 0)
    {

}
else
{
$jjsdzz = mysql_query("insert into Hospitalname(hos_name,designation,rep_id,pin_id,pincode,mobile_no,address)values('$shop_name','$owner_name','$rep_id','$pin_id','$pincode','$mobile_no','$customer_address')")or die(mysql_error());
$chem_id=mysql_insert_id();

$row=mysql_fetch_array($jjxx);
$doctor_id=$row['doctor_id'];

mysql_query("INSERT INTO tbl_doctor_chemist(doctor_id,chemist_id,designation,rep_id) VALUES ('$doctor_id','$chem_id','$owner_name','$rep_id')");
}





?>
