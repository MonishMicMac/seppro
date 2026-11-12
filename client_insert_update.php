<?php
include("include/connect.php");
include("include/select.php");
session_start();
error_reporting(0);

$id=$_SESSION['id'];
$m_id16=$_SESSION['m_id16'];
$ad =new select1;
if(!isset($_SESSION['id']))
{

        echo "<script type='text/javascript'>window.location='index.php?err'</script>"; 
}
else
{

date_default_timezone_set('Asia/Calcutta'); 
 
  
$d=mysql_query("select * from clinetcreation where companyname='".$_REQUEST['companyname']."'  AND pincode='".$_REQUEST['pincode']."' ");
$count_d=mysql_num_rows($d);
if($count_d==0) {

    $clientname0=$_REQUEST['outer-list'][0]['clientname'];
    $emailid0=$_REQUEST['outer-list'][0]['emailid'];
    $phoneno0=$_REQUEST['outer-list'][0]['phoneno'];
    $designation0=$_REQUEST['outer-list'][0]['designation'];
    $mobileno0=$_REQUEST['outer-list'][0]['mobileno'];
  

  mysql_query("INSERT INTO clinetcreation(companyname,type,address,landmark,pincode,name,emailid,mobileno,desgination,mobilenoland,areaname,source,typeofcustomer,date,time)VALUES('".$_REQUEST['companyname']."','".$_REQUEST['type']."','".$_REQUEST['address']."','".$_REQUEST['landmark']."','".$_REQUEST['pincode']."','".$clientname0."','".$emailid0."','".$phoneno0."','".$designation0."','".$mobileno0."','".$_REQUEST['areaname']."','".$_REQUEST['source']."','".$_REQUEST['typecustomer']."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
  $LastId = mysql_insert_id();



  

for ($i=1; $i <count($_REQUEST['outer-list']) ; $i++) { 
 $client_id=$LastId;
   $clientname=$_REQUEST['outer-list'][$i]['clientname'];
   $emailid=$_REQUEST['outer-list'][$i]['emailid'];
   $phoneno=$_REQUEST['outer-list'][$i]['phoneno'];
   $designation=$_REQUEST['outer-list'][$i]['designation'];
   $mobileno=$_REQUEST['outer-list'][$i]['mobileno'];

  mysql_query("INSERT INTO client_contact(client_id,contact_person,emailid,phoneno,designation,mobilenoland,date,time)VALUES('".$client_id."','".$clientname."','".$emailid."','".$phoneno."','".$designation."','".$mobileno."','".date('Y-m-d')."','".date('H:i:s')."')")or die(mysql_error());  
}


for ($j=0; $j <count($_REQUEST['outer-list1']) ; $j++) { 	
   $product=$_REQUEST['outer-list1'][$j]['product'];
   $quantity=$_REQUEST['outer-list1'][$j]['quantity']; 
     $pro_id = mysql_query("SELECT * FROM product WHERE pro_name='".$product."'")or die(mysql_error());
      $pro_id_res = mysql_fetch_array($pro_id); 
	  for ($k=0; $k <count($_REQUEST['outer-list1'][$j]['inner-list1']) ; $k++) { 
	  	 $client_id=$LastId;
		   $modelno=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['modelno'];
		   $sino=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['sino'];
       $invoiceno=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['invoiceno'];
		   $purchasedate=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['purchasedate'];
		   $pay=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['pay'];
		   $startdate=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['startdate'];  
		   $enddate=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['enddate'];
       $brandname=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['brandname'];  
       $capacity=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['capacity'];        
       $remarks=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['remarks'];
       $amount=$_REQUEST['outer-list1'][$j]['inner-list1'][$k]['amount'];

		   // echo "INSERT INTO client_product_list(clientid,product,quantity,model_no,sl_no,purchase_date,type,start_date,end_date,date,time)VALUES('".$client_id."','".$product."','".$quantity."','".$modelno."','".$sino."','".$purchasedate."','".$pay."','".$startdate."','".$enddate."','".date('Y-m-d')."','".date('H:i:s')."')";

		   mysql_query("INSERT INTO client_product_list(clientid,product,quantity,model_no,sl_no,purchase_date,type,start_date,end_date,brand_name,capacity,remarks,source,date,time,product_id,invoice_no)VALUES('".mysql_real_escape_string($client_id)."','".$product."','".$quantity."','".$modelno."','".$sino."','".$purchasedate."','".$pay."','".$startdate."','".$enddate."','".$brandname."','".$capacity."','".$remarks."','".$_REQUEST['source']."','".date('Y-m-d')."','".date('H:i:s')."','".$pro_id_res['id']."','".$invoiceno."')")or die(mysql_error());  
	 }

}


  

   
  echo "<script type='text/javascript'>alert('Add Successfully');window.location.href='client_creation.php';</script>";
 
}
else{
echo "<script type='text/javascript'>alert('Already Added');window.location.href='client_creation.php';</script>";
}



        
} 
?>