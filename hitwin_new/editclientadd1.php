<?php
include('connect.php');



mysql_query("UPDATE clinetcreation SET companyname='".$_REQUEST['companyname']."',name='".$_REQUEST['name']."',address='".$_REQUEST['address']."',pincode='".$_REQUEST['pincode']."',type='".$_REQUEST['type']."',mobileno='".$_REQUEST['mobileno']."',repid='".$_REQUEST['repid']."',date='".$_REQUEST['date']."',time='".$_REQUEST['time']."',emailid='".$_REQUEST['emailid']."',landmark='".$_REQUEST['landmark']."',typeofcustomer='".$_REQUEST['tycu']."',Addrtess_line1='".$_REQUEST['address1']."',Addrtess_line2='".$_REQUEST['address2']."',emailid1='".$_REQUEST['emailid1']."',name1='".$_REQUEST['name1']."',NAME1DESIG='".$_REQUEST['NAME1DESIG']."',mobileno1='".$_REQUEST['mobileno1']."' WHERE id='".$_REQUEST['cid']."'")or die(mysql_error());
?>