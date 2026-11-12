<?php
include('connect.php');



mysql_query("UPDATE clinetcreation SET companyname='".$_REQUEST['companyname']."',name='".$_REQUEST['name']."',address='".$_REQUEST['address']."',pincode='".$_REQUEST['pincode']."',type='".$_REQUEST['type']."',mobileno='".$_REQUEST['mobileno']."',repid='".$_REQUEST['repid']."',date='".$_REQUEST['date']."',time='".$_REQUEST['time']."',emailid='".$_REQUEST['emailid']."',landmark='".$_REQUEST['landmark']."',typeofcustomer='".$_REQUEST['tycu']."' WHERE id='".$_REQUEST['cid']."'")or die(mysql_error());


?>